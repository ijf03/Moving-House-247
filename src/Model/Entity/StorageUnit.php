<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StorageUnit Entity
 *
 * @property int $storage_unit_id
 * @property string $unit_code
 * @property string $facility_name
 * @property string|null $unit_size_m3
 * @property string $status
 * @property string|null $security_level
 * @property bool $is_climate_controlled
 * @property bool $is_active
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class StorageUnit extends Entity
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
        'unit_code' => true,
        'facility_name' => true,
        'unit_size_m3' => true,
        'status' => true,
        'security_level' => true,
        'is_climate_controlled' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
    ];
}
