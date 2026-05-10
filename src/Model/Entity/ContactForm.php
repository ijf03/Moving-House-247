<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContactForm Entity
 *
 * @property int $contact_form_id
 * @property int $customer_id
 * @property string $subject
 * @property string $message
 * @property \Cake\I18n\DateTime $created
 * @property string $status
 * @property string|null $admin_reply
 * @property \Cake\I18n\DateTime|null $replied_at
 *
 * @property \App\Model\Entity\Customer $customer
 */
class ContactForm extends Entity
{
    protected array $_accessible = [
        'customer_id' => true,
        'subject' => true,
        'message' => true,
        'status' => true,
        'admin_reply' => true,
        'replied_at' => true,
        'created' => true,
        'customer' => true,
        'contact_form_replies' => true,
    ];
}
