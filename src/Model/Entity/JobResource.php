<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * JobResource Entity
 *
 * @property int $booking_resource_id
 * @property int|null $booking_id
 * @property string $resource_type
 * @property int $resource_id
 * @property string $quantity
 * @property string|null $notes
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Booking $booking
 */
class JobResource extends Entity
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
        'job_id' => true,
        'truck_id' => true,
        'equipment_id' => true,
        'storage_unit_id' => true,
        'inventory_id' => true,
        'quantity' => true,
        'created' => true,
        'modified' => true,

        'job' => true,
        'truck' => true,
        'equipment' => true,
        'storage_unit' => true,
        'inventory_item' => true,
    ];
}
