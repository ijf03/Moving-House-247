<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use function PHPUnit\Framework\isNull;

/**
 * ContactForms Controller
 *
 * @property \App\Model\Table\ContactFormsTable $ContactForms
 */
class ContactFormsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Public users can only access the contact form submission page
        $this->Authentication->allowUnauthenticated(['add']);
    }

    /**
     * Simple admin guard.
     * Adjust the user_type check if your admin value is different.
     */
    private function requireAdmin(): void
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity) {
            throw new ForbiddenException('You are not authorised to access this page.');
        }

        $userType = $identity->get('user_type') ?? null;

        // Assumes admin user_type = 1
        if ((int)$userType !== 1) {
            throw new ForbiddenException('Admins only.');
        }
    }

    public function index()
    {
        $this->requireAdmin();

        $query = $this->ContactForms->find()
            ->contain(['Customers'])
            ->orderBy(['ContactForms.created' => 'DESC']);

        $contactForms = $this->paginate($query);

        $this->set(compact('contactForms'));
    }

    public function view($id = null)
    {
        $this->requireAdmin();

        $contactForm = $this->ContactForms->get($id, contain: ['Customers']);
        $this->set(compact('contactForm'));
    }

    public function add()
    {
        $contactForm = $this->ContactForms->newEmptyEntity();
        $siteKey = Configure::read('Recaptcha.siteKey');
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $captchaResponse = $data['g-recaptcha-response'] ?? '';

            if (empty($captchaResponse)) {
                $this->Flash->error(__('Please complete the reCAPTCHA.'));
                $this->set(compact('contactForm'));
                return;
            }

            $secretKey = Configure::read('Recaptcha.secretKey');

            $verifyResponse = file_get_contents(
                'https://www.google.com/recaptcha/api/siteverify?secret='
                . urlencode($secretKey)
                . '&response=' . urlencode($captchaResponse)
                . '&remoteip=' . urlencode($this->request->clientIp() ?? '')
            );

            $captchaSuccess = json_decode($verifyResponse, true);

            if (empty($captchaSuccess['success'])) {
                $this->Flash->error(__('reCAPTCHA verification failed. Please try again.'));
                $this->set(compact('contactForm'));
                return;
            }

            $customersTable = $this->fetchTable('Customers');

            $customer = $customersTable->find()
                ->where([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ])
                ->first();

            if (!$customer) {
                $customer = $customersTable->newEntity([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                ]);

                if ($customer->getErrors()) {
                    foreach ($customer->getErrors() as $field => $error) {
                        $this->Flash->error(__($error[$field]));}
                    $this->set(compact('contactForm'));
                    return;
                }
                if (!$customersTable->save($customer)) {
                    $this->Flash->error(__('The customer could not be created. Please try again.'));
                    $this->set(compact('contactForm'));
                    return;
                }
            }

            $contactFormData = [
                'customer_id' => $customer->customer_id,
                'subject' => $data['subject'],
                'message' => $data['message'],
                'status' => 'new',
                'admin_reply' => null,
                'replied_at' => null,
            ];

            $contactForm = $this->ContactForms->newEntity($contactFormData);

            if ($this->ContactForms->save($contactForm)) {
                $this->Flash->success(__('Your message has been sent successfully.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }

            $this->Flash->error(__('The contact form could not be saved. Please try again.'));
        }

        $this->set(compact('contactForm', 'siteKey'));
    }

    public function edit($id = null)
    {
        $this->requireAdmin();

        $contactForm = $this->ContactForms->get($id, contain: ['Customers']);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Update customer details as well
            if ($contactForm->customer) {
                $customer = $contactForm->customer;
                $customer = $this->ContactForms->Customers->patchEntity($customer, [
                    'first_name' => $data['first_name'] ?? $customer->first_name,
                    'last_name'  => $data['last_name'] ?? $customer->last_name,
                    'email'      => $data['email'] ?? $customer->email,
                    'phone'      => $data['phone'] ?? $customer->phone,
                ]);

                $this->ContactForms->Customers->save($customer);
            }

            $contactForm = $this->ContactForms->patchEntity($contactForm, [
                'subject' => $data['subject'] ?? $contactForm->subject,
                'message' => $data['message'] ?? $contactForm->message,
            ]);

            if ($this->ContactForms->save($contactForm)) {
                $this->Flash->success(__('The contact form has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The contact form could not be saved. Please try again.'));
        }

        $this->set(compact('contactForm'));
    }

    public function delete($id = null)
    {
        $this->requireAdmin();

        $this->request->allowMethod(['post', 'delete']);
        $contactForm = $this->ContactForms->get($id);

        if ($this->ContactForms->delete($contactForm)) {
            $this->Flash->success(__('The contact form has been deleted.'));
        } else {
            $this->Flash->error(__('The contact form could not be deleted. Please try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function reply($id = null)
    {
        $this->requireAdmin();

        $contactForm = $this->ContactForms->get($id, contain: ['Customers']);

        if (!$contactForm->customer || !$contactForm->customer->email) {
            throw new NotFoundException('Customer email not found.');
        }

        if ($this->request->is('post')) {
            $replyMessage = trim((string)$this->request->getData('reply_message'));

            if ($replyMessage === '') {
                $this->Flash->error(__('Reply message cannot be empty.'));
                $this->set(compact('contactForm'));
                return;
            }

            try {
                $mailer = new Mailer('default');
                $mailer
                    ->setTo($contactForm->customer->email)
                    ->setSubject('Re: ' . $contactForm->subject)
                    ->deliver(
                        "Hello {$contactForm->customer->first_name},\n\n" .
                        $replyMessage . "\n\n" .
                        "Regards,\nMoving House 24/7"
                    );

                // Save reply back to database
                $contactForm->admin_reply = $replyMessage;
                $contactForm->status = 'replied';
                $contactForm->replied_at = date('Y-m-d H:i:s');

                if ($this->ContactForms->save($contactForm)) {
                    $this->Flash->success(__('Reply email sent successfully.'));
                } else {
                    $this->Flash->warning(__('Email sent, but the reply could not be saved to the database.'));
                }

                return $this->redirect(['action' => 'view', $contactForm->contact_form_id]);
            } catch (\Exception $e) {
                $this->Flash->error(__('Email could not be sent: {0}', $e->getMessage()));
            }
        }

        $this->set(compact('contactForm'));
    }
}
