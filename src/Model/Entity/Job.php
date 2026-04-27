<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Job Entity
 *
 * @property int $job_id
 * @property int $job_type_id
 * @property string $description
 * @property string $pickup_address
 * @property string $dropoff_address
 * @property string $job_date
 * @property string $job_time
 * @property int $customer_id
 *
 * @property \App\Model\Entity\JobType $job_type
 * @property \App\Model\Entity\Customer $customer
 */
class Job extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'job_type_id' => true,
        'description' => true,
        'pickup_address' => true,
        'dropoff_address' => true,
        'job_date' => true,
        'job_time' => true,
        'customer_id' => true,
        'job_type' => true,
        'customer' => true,
    ];
}
