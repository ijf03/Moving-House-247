<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class JobTruck extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'job_truck_id' => false,
    ];
}
