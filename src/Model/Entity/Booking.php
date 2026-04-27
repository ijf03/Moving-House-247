<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Booking extends Entity
{
    protected array $_accessible = [
        'customer_id' => true,
        'job_type_id' => true,
        'pickup_address' => true,
        'dropoff_address' => true,
        'job_date' => true,
        'job_time' => true,
        'status' => true,
        'notes' => true,
        'created' => true,
        'customer' => true,
        'job_type' => true,
    ];
}
