<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class StaffJob extends Entity
{
    protected array $_accessible = [
        '*' => true,
        'allocation_id' => false,
    ];
}
