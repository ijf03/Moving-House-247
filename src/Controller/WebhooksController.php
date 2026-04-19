<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class WebhooksController extends AppController
{
    public function stripe(): Response
    {
        $this->request->allowMethod(['post']);
        $this->autoRender = false;

        $payload = (string)$this->request->getBody();
        $sigHeader = $this->request->getHeaderLine('Stripe-Signature');
        $endpointSecret = Configure::read('Stripe.webhookSecret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return $this->response->withStatus(400)->withStringBody('Invalid payload');
        } catch (SignatureVerificationException $e) {
            return $this->response->withStatus(400)->withStringBody('Invalid signature');
        }

        $invoicesTable = $this->fetchTable('Invoices');

        switch ($event->type) {
            case 'invoice.paid':
                $stripeInvoice = $event->data->object;

                $invoice = $invoicesTable->find()
                    ->where(['stripe_invoice_id' => $stripeInvoice->id])
                    ->first();

                if ($invoice) {
                    $invoice->status = 'paid';
                    $invoice->paid_at = date('Y-m-d H:i:s');
                    $invoicesTable->save($invoice);
                }
                break;

            case 'payment_intent.processing':
                $paymentIntent = $event->data->object;

                $invoice = $invoicesTable->find()
                    ->where(['stripe_invoice_id' => $paymentIntent->invoice ?? null])
                    ->first();

                if ($invoice) {
                    $invoice->status = 'processing';
                    $invoicesTable->save($invoice);
                }
                break;

            case 'invoice.payment_failed':
                $stripeInvoice = $event->data->object;

                $invoice = $invoicesTable->find()
                    ->where(['stripe_invoice_id' => $stripeInvoice->id])
                    ->first();

                if ($invoice) {
                    $invoice->status = 'payment_failed';
                    $invoicesTable->save($invoice);
                }
                break;
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(['received' => true]));
    }
}
