<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class ContactFormReply extends Entity
{
    protected array $_accessible = [
        'contact_form_id' => true,
        'sender_type' => true,
        'message' => true,
        'created' => true,
        'modified' => true,
        'contact_form' => true,
    ];
}
