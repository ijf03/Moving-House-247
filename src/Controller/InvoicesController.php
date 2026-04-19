<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Stripe\StripeClient;

/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 */
class InvoicesController extends AppController
{
    private function presetOptions(): array
    {
        return [
            '' => 'Custom item',
            'labour_hour' => [
                'description' => 'Labour - per hour',
                'unit_price_cents' => 8500,
            ],
            'truck_small' => [
                'description' => 'Truck rental - small truck',
                'unit_price_cents' => 18000,
            ],
            'truck_large' => [
                'description' => 'Truck rental - large truck',
                'unit_price_cents' => 28000,
            ],
            'packing_materials' => [
                'description' => 'Packing materials',
                'unit_price_cents' => 5000,
            ],
            'stairs_surcharge' => [
                'description' => 'Stairs surcharge',
                'unit_price_cents' => 7500,
            ],
        ];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Invoices->find()
            ->contain(['Bookings', 'Customers']);
        $invoices = $this->paginate($query);

        $this->set(compact('invoices'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoice = $this->Invoices->get($id, contain: ['Bookings', 'Customers']);
        $this->set(compact('invoice'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($bookingId = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->get('user_type') != 1) {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $booking = $this->fetchTable('Bookings')->get($bookingId, contain: ['Customers', 'JobTypes']);
        $invoice = $this->fetchTable('Invoices')->newEmptyEntity();
        $presets = $this->presetOptions();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $itemsInput = $data['items'] ?? [];

            $validItems = [];
            $subtotal = 0;
            $sortOrder = 1;

            foreach ($itemsInput as $item) {
                $presetKey = (string)($item['preset'] ?? '');
                $description = trim((string)($item['description'] ?? ''));
                $quantity = (float)($item['quantity'] ?? 0);
                $unitPriceDollars = (float)($item['unit_price'] ?? 0);

                if ($presetKey !== '' && isset($presets[$presetKey])) {
                    $description = $presets[$presetKey]['description'];
                    $unitPriceCents = (int)$presets[$presetKey]['unit_price_cents'];
                } else {
                    $unitPriceCents = (int)round($unitPriceDollars * 100);
                }

                if ($description === '' || $quantity <= 0 || $unitPriceCents < 0) {
                    continue;
                }

                $lineTotal = (int)round($quantity * $unitPriceCents);
                $subtotal += $lineTotal;

                $validItems[] = [
                    'description' => $description,
                    'quantity' => $quantity,
                    'unit_price_cents' => $unitPriceCents,
                    'line_total_cents' => $lineTotal,
                    'sort_order' => $sortOrder++,
                ];
            }

            if (empty($validItems)) {
                $this->Flash->error(__('Please add at least one valid invoice item.'));
                $this->set(compact('booking', 'invoice', 'presets'));
                return;
            }

            $invoiceData = [
                'booking_id' => $booking->booking_id,
                'customer_id' => $booking->customer_id,
                'status' => 'draft',
                'subtotal_cents' => $subtotal,
                'total_cents' => $subtotal,
            ];

            $invoice = $this->fetchTable('Invoices')->patchEntity($invoice, $invoiceData);

            if ($invoice->hasErrors()) {
                $this->Flash->error(__('Invoice validation failed.'));
                $this->set(compact('booking', 'invoice', 'presets'));
                return;
            }

            $connection = $this->fetchTable('Invoices')->getConnection();
            $connection->begin();

            try {
                $this->fetchTable('Invoices')->saveOrFail($invoice);

                foreach ($validItems as $itemData) {
                    $itemData['invoice_id'] = $invoice->invoice_id;
                    $item = $this->fetchTable('InvoiceItems')->newEntity($itemData);
                    $this->fetchTable('InvoiceItems')->saveOrFail($item);
                }

                $stripe = new StripeClient((string)Configure::read('Stripe.secretKey'));

                $customer = $this->fetchTable('Customers')->get($booking->customer_id);

                if (empty($customer->stripe_id)) {
                    $fullName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''));

                    $stripeCustomer = $stripe->customers->create([
                        'name' => $fullName !== '' ? $fullName : null,
                        'email' => $customer->email ?: null,
                        'phone' => $customer->phone ?: null,
                        'description' => 'Customer for booking invoice',
                        'metadata' => [
                            'local_customer_id' => (string)$customer->customer_id,
                        ],
                    ]);

                    $customer->stripe_id = $stripeCustomer->id;
                    $this->fetchTable('Customers')->saveOrFail($customer);
                }

                $stripeInvoice = $stripe->invoices->create([
                    'customer' => $customer->stripe_id,
                    'collection_method' => 'send_invoice',
                    'days_until_due' => 7,
                    'auto_advance' => false,
                    'metadata' => [
                        'local_invoice_id' => (string)$invoice->invoice_id,
                        'booking_id' => (string)$booking->booking_id,
                    ],
                ]);

                $invoiceItems = $this->fetchTable('InvoiceItems')->find()
                    ->where(['invoice_id' => $invoice->invoice_id])
                    ->orderBy(['sort_order' => 'ASC'])
                    ->all();

                foreach ($invoiceItems as $line) {
                    $stripe->invoiceItems->create([
                        'customer' => $customer->stripe_id,
                        'invoice' => $stripeInvoice->id,
                        'currency' => 'aud',
                        'amount' => $line->line_total_cents,
                        'description' => sprintf(
                            '%s (Qty: %s @ $%0.2f)',
                            $line->description,
                            rtrim(rtrim(number_format((float)$line->quantity, 2, '.', ''), '0'), '.'),
                            $line->unit_price_cents / 100
                        ),
                    ]);
                }

                $finalizedInvoice = $stripe->invoices->finalizeInvoice($stripeInvoice->id, [
                    'auto_advance' => false,
                ]);

                $stripe->invoices->sendInvoice($stripeInvoice->id, []);

                $invoice->stripe_invoice_id = $finalizedInvoice->id;
                $invoice->invoice_url = $finalizedInvoice->hosted_invoice_url ?? null;
                $invoice->status = $finalizedInvoice->status ?? 'open';
                $invoice->sent_at = date('Y-m-d H:i:s');

                $this->fetchTable('Invoices')->saveOrFail($invoice);

                $connection->commit();

                $this->Flash->success(__('Invoice generated and sent successfully.'));
                return $this->redirect(['action' => 'view', $invoice->invoice_id]);
            } catch (\Throwable $e) {
                $connection->rollback();
                $this->Flash->error(__('Invoice creation failed: {0}', $e->getMessage()));
            }
        }

        $this->set(compact('booking', 'invoice', 'presets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoice = $this->Invoices->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            if ($this->Invoices->save($invoice)) {
                $this->Flash->success(__('The invoice has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice could not be saved. Please, try again.'));
        }
        $bookings = $this->Invoices->Bookings->find('list', limit: 200)->all();
        $customers = $this->Invoices->Customers->find('list', limit: 200)->all();
        $this->set(compact('invoice', 'bookings', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoice = $this->Invoices->get($id);
        if ($this->Invoices->delete($invoice)) {
            $this->Flash->success(__('The invoice has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
