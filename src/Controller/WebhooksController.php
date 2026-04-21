<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
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
