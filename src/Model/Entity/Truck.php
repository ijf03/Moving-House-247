<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Truck Entity
 *
 * @property int $truck_id
 * @property string $name
 * @property string $rego
 * @property string|null $truck_size
 * @property string|null $capacity_m3
 * @property string|null $max_payload_kg
 * @property string|null $current_location
 * @property \Cake\I18n\Date|null $next_service_date
 * @property bool $is_active
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class Truck extends Entity
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
        'name' => true,
        'rego' => true,
        'truck_size' => true,
        'capacity_m3' => true,
        'max_payload_kg' => true,
        'current_location' => true,
        'next_service_date' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
    ];
}
