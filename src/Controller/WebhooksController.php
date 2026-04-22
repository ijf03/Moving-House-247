<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Mailer\Mailer;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class WebhooksController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['stripe']);
    }

    public function stripe(): Response
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $payload = (string)$this->request->getBody();
        $sigHeader = $this->request->getHeaderLine('Stripe-Signature');
        $endpointSecret = Configure::read('Stripe.webhookKey');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return $this->response
                ->withStatus(400)
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'ok' => false,
                    'stage' => 'payload',
                    'message' => $e->getMessage(),
                ]));
        } catch (SignatureVerificationException $e) {
            return $this->response
                ->withStatus(400)
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'ok' => false,
                    'stage' => 'signature',
                    'message' => $e->getMessage(),
                ]));
        }

        $invoicesTable = $this->fetchTable('Invoices');

        if ($event->type === 'invoice.paid') {
            $stripeInvoice = $event->data->object;

            $updated = $invoicesTable->updateQuery()
                ->set([
                    'status' => 'paid',
                    'paid_at' => date('Y-m-d H:i:s'),
                ])
                ->where(['stripe_invoice_id' => $stripeInvoice->id])
                ->execute()
                ->rowCount();

            if ($updated > 0) {
                $invoice = $invoicesTable->find()
                    ->contain(['Customers', 'Bookings'])
                    ->where(['stripe_invoice_id' => $stripeInvoice->id])
                    ->first();

                if ($invoice) {
                    $customerName = trim(
                        ($invoice->customer->first_name ?? '') . ' ' . ($invoice->customer->last_name ?? '')
                    );

                    $adminEmail = '	noreply@review.fit3047.u26s1158.iedev.org';

                    $body = "An invoice has been paid.\n\n"
                        . "Invoice ID: " . $invoice->invoice_id . "\n"
                        . "Stripe Invoice ID: " . ($invoice->stripe_invoice_id ?? 'N/A') . "\n"
                        . "Customer: " . ($customerName !== '' ? $customerName : 'N/A') . "\n"
                        . "Customer Email: " . ($invoice->customer->email ?? 'N/A') . "\n"
                        . "Booking ID: " . ($invoice->booking_id ?? 'N/A') . "\n"
                        . "Amount Paid: $" . number_format(($invoice->total_cents ?? 0) / 100, 2) . "\n"
                        . "Paid At: " . date('Y-m-d H:i:s') . "\n";

                    $mailer = new Mailer('default');
                    $mailer
                        ->setTo($adminEmail)
                        ->setSubject('Invoice paid - #' . $invoice->invoice_id)
                        ->deliver($body);
                }
            }

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'ok' => true,
                    'event_type' => $event->type,
                    'stripe_invoice_id' => $stripeInvoice->id ?? null,
                    'updated_rows' => $updated,
                ]));
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'ok' => true,
                'event_type' => $event->type,
                'ignored' => true,
            ]));
    }
}
