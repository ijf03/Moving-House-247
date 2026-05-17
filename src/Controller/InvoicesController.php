<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Stripe\StripeClient;

/**
 * Invoices Controller
 *
 * @property \App\Model\Table\InvoicesTable $Invoices
 */
class InvoicesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        if ($this->Authentication->getIdentity()) {
            $user = $this->Authentication->getIdentity();
            $userId = $user->user_id;
            $users = $this->fetchTable('Users');
            $roleQuery = $users->find()
                ->where(['user_id' => $userId])
                ->contain(['UserTypes'])
                ->first();
            $isAdmin = $roleQuery->user_type_name == 'Admin';
            if (!$isAdmin) {
                return $this->redirect('/');
            }
        }
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

        $search = trim((string)$this->request->getQuery('search'));

        if ($search !== '') {
            $conditions = [
                'OR' => [
                    'Invoices.status LIKE' => "%$search%",
                    'Customers.first_name LIKE' => "%$search%",
                    'Customers.last_name LIKE' => "%$search%",
                    'Customers.email LIKE' => "%$search%",
                ]
            ];

            if (is_numeric($search)) {
                $conditions['OR']['Invoices.invoice_id'] = (int)$search;
            }

            $query->where($conditions);
        }

        $invoices = $this->paginate($query);

        $this->set(compact('invoices', 'search'));
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
    public function add()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->get('user_type') != 1) {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $bookingsTable = $this->fetchTable('Bookings');
        $bookings = $bookingsTable->find()
            ->contain(['Customers'])
            ->all()
            ->combine(
                'booking_id',
                function ($booking) {
                    $customerName = 'Unknown customer';

                    if (!empty($booking->customer)) {
                        $name = trim(
                            ($booking->customer->first_name ?? '') . ' ' .
                            ($booking->customer->last_name ?? '')
                        );

                        if ($name !== '') {
                            $customerName = $name;
                        }
                    }

                    return 'Booking #' . $booking->booking_id . ' - ' . $customerName;
                }
            )
            ->toArray();

        $invoices = $this->fetchTable('Invoices');
        $invoice = $this->fetchTable('Invoices')->newEmptyEntity();

        if ($this->request->is('post')) {

            $bookingId = $this->request->getData('booking_id');
            $dueDate = $this->request->getData('due_date');

            if (empty($bookingId)) {
                $this->Flash->error(__('Please select a booking.'));
                $this->set(compact( 'invoice', 'bookings'));
                return;
            }

            $booking = $bookingsTable->get($bookingId);

            $invoiceData = [
                'booking_id' => $booking->booking_id,
                'customer_id' => $booking->customer_id,
                'status' => 'draft',
                'subtotal_cents' => 0,
                'total_cents' => 0,
                'due_date' => $dueDate,
            ];

            $invoice = $this->fetchTable('Invoices')->patchEntity($invoice, $invoiceData);

            if ($invoices->save($invoice)) {
                $this->Flash->success(__('Invoice created. You can now add invoice items.'));
                return $this->redirect(['action' => 'edit',$invoice->invoice_id]);
            } else {
                $this->Flash->error(__('Invoice validation failed.'));
                $this->set(compact('bookings', 'invoice'));
                return;
            }

        }

        $this->set(compact('bookings', 'invoice'));
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

        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->get('user_type') != 1) {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $invoicesTable = $this->fetchTable('Invoices');
        $invoiceItemsTable = $this->fetchTable('InvoiceItems');
        $bookingsTable = $this->fetchTable('Bookings');
        $customersTable = $this->fetchTable('Customers');

        $invoice = $invoicesTable->get($id, [
            'contain' => ['InvoiceItems']
        ]);

        $booking = $bookingsTable->get($invoice->booking_id);
        $customer = $customersTable->get($invoice->customer_id);
        $presetsTable = $this->fetchTable('InvoiceItemPresets');

        $presets = $presetsTable->find()
            ->where(['is_active' => 1])
            ->orderBy(['sort_order' => 'ASC', 'name' => 'ASC'])
            ->all();

        $presetOptions = ['' => 'Custom item'];

        foreach ($presets as $key => $preset) {
            if ($key === '' || !is_array($preset)) {
                continue;
            }

            $presetOptions[$key] = $preset['description'] . ' ($' .
                number_format($preset['unit_price_cents'] / 100, 2) . ')';
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $action = $this->request->getData('action');

            if ($action === 'add_item') {
                $presetId = (int)$this->request->getData('preset_id');
                $description = trim((string)$this->request->getData('description'));
                $quantity = (float)$this->request->getData('quantity');
                $unitPriceDollars = (float)$this->request->getData('unit_price');

                if ($presetId > 0) {
                    $preset = $presetsTable->get($presetId);
                    $description = $preset->description;
                    $unitPriceCents = (int)$preset->unit_price_cents;
                } else {
                    $unitPriceCents = (int)round($unitPriceDollars * 100);
                }

                if ($description === '' || $quantity <= 0 || $unitPriceCents < 0) {
                    $this->Flash->error(__('Please enter a valid invoice item.'));
                    return $this->redirect(['action' => 'edit', $invoice->invoice_id]);
                }

                $lineTotalCents = (int)round($quantity * $unitPriceCents);

                $lastSortOrder = $invoiceItemsTable
                    ->find()
                    ->where(['invoice_id' => $invoice->invoice_id])
                    ->orderBy(['sort_order' => 'DESC'])
                    ->first();

                $sortOrder = $lastSortOrder ? $lastSortOrder->sort_order + 1 : 1;

                $item = $invoiceItemsTable->newEntity([
                    'invoice_id' => $invoice->invoice_id,
                    'description' => $description,
                    'quantity' => $quantity,
                    'unit_price_cents' => $unitPriceCents,
                    'line_total_cents' => $lineTotalCents,
                    'sort_order' => $sortOrder,
                ]);

                if (!$invoiceItemsTable->save($item)) {
                    $this->Flash->error(__('The invoice item could not be saved.'));
                    return $this->redirect(['action' => 'edit', $invoice->invoice_id]);
                }

                $this->recalculateInvoiceTotals($invoice->invoice_id);

                $this->Flash->success(__('Invoice item added.'));
                return $this->redirect(['action' => 'edit', $invoice->invoice_id]);
            }

            if ($action === 'save_invoice') {
                $invoice = $invoicesTable->patchEntity($invoice, [
                    'due_date' => $this->request->getData('due_date'),
                ]);

                if ($invoicesTable->save($invoice)) {
                    $this->Flash->success(__('Invoice details updated.'));
                    return $this->redirect(['action' => 'edit', $invoice->invoice_id]);
                }

                $this->Flash->error(__('The invoice could not be updated.'));
            }
        }


        $invoice = $invoicesTable->get($id, [
            'contain' => [
                'InvoiceItems' => [
                    'sort' => ['InvoiceItems.sort_order' => 'ASC']
                ]
            ]
        ]);

        $this->set(compact(
            'invoice',
            'booking',
            'customer',
            'presets',
            'presetOptions'
        ));
    }

    public function send($id = null)
    {
        $connection = $this->fetchTable('Invoices')->getConnection();
        $connection->begin();

        $invoicesTable = $this->fetchTable('Invoices');
        $customersTable = $this->fetchTable('Customers');
        $invoiceItemsTable = $this->fetchTable('InvoiceItems');

        $invoice = $invoicesTable->get($id, [
            'contain' => ['InvoiceItems']
        ]);
        $customer = $customersTable->get($invoice->customer_id);

        try {
            $stripe = new StripeClient(Configure::read('Stripe.secretKey'));

            if (empty($customer->stripe_id)) {
                $fullName = trim(
                    ($customer->first_name ?? '') . ' ' .
                    ($customer->last_name ?? '')
                );

                $stripeCustomer = $stripe->customers->create([
                    'name' => $fullName !== '' ? $fullName : null,
                    'email' => $customer->email ?: null,
                    'phone' => $customer->phone ?: null,
                    'description' => 'Customer for booking invoice',
                    'metadata' => [
                        'local_customer_id' => $customer->customer_id,
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
                    'local_invoice_id' => $invoice->invoice_id,
                    'booking_id' => $invoice->booking_id,
                ],
            ]);

            $invoiceItems = $invoiceItemsTable
                ->find()
                ->where(['invoice_id' => $invoice->invoice_id])
                ->orderBy(['sort_order' => 'ASC'])
                ->all();

            foreach ($invoiceItems as $line) {
                $stripe->invoiceItems->create([
                    'customer' => $customer->stripe_id,
                    'invoice' => $stripeInvoice->id,
                    'currency' => 'aud',
                    'amount' => (int)$line->line_total_cents,
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

            $sentInvoice = $stripe->invoices->sendInvoice($finalizedInvoice->id, []);

            $invoice->stripe_invoice_id = $sentInvoice->id;
            $invoice->invoice_url = $sentInvoice->hosted_invoice_url ?? $finalizedInvoice->hosted_invoice_url ?? null;
            $invoice->status = $sentInvoice->status ?? 'open';
            $invoice->sent_at = date('Y-m-d H:i:s');


            $mailer = new Mailer('default');
            $body = "Hi " . ($customer->first_name !== '' ? $customer : 'there') . ",\n\n"
                . "Your invoice is ready.\n\n"
                . "You can view and pay it here:\n"
                . $finalizedInvoice->hosted_invoice_url . "\n\n"
                . "If you have any questions, please reply to this email.\n\n"
                . "Regards,\n"
                . "Moving House 24/7";

            $mailer
                ->setTo($customer->email)
                ->setSubject('Your invoice is ready')
                ->deliver($body);


            $invoicesTable->saveOrFail($invoice);

            $connection->commit();

            $this->Flash->success(__('Invoice generated and sent successfully.'));
            return $this->redirect(['action' => 'index']);

        } catch (\Throwable $e) {
            $connection->rollback();

            $this->Flash->error(__('Invoice could not be sent: {0}', $e->getMessage()));
            return $this->redirect(['action' => 'edit', $invoice->invoice_id]);
        }
    }
    private function recalculateInvoiceTotals($invoiceId)
    {
        $invoicesTable = $this->fetchTable('Invoices');
        $invoiceItemsTable = $this->fetchTable('InvoiceItems');

        $items = $invoiceItemsTable
            ->find()
            ->where(['invoice_id' => $invoiceId])
            ->all();

        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += (int)$item->line_total_cents;
        }

        $invoice = $invoicesTable->get($invoiceId);
        $invoice->subtotal_cents = $subtotal;
        $invoice->total_cents = $subtotal;

        return $invoicesTable->save($invoice);
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
