<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InventoryItem Entity
 *
 * @property int $inventory_item_id
 * @property string $name
 * @property string $category
 * @property int $quantity_on_hand
 * @property int $reorder_threshold
 * @property string $unit
 * @property string|null $storage_location
 * @property bool $is_active
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class InventoryItem extends Entity
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
        'category' => true,
        'quantity_on_hand' => true,
        'reorder_threshold' => true,
        'unit' => true,
        'storage_location' => true,
        'is_active' => true,
        'created' => true,
        'modified' => true,
    ];
}
