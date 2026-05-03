<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceItemPreset Entity
 *
 * @property int $invoice_item_preset_id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property int $unit_price_cents
 * @property bool $is_active
 * @property int $sort_order
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class InvoiceItemPreset extends Entity
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
        'code' => true,
        'name' => true,
        'description' => true,
        'unit_price_cents' => true,
        'is_active' => true,
        'sort_order' => true,
        'created' => true,
        'modified' => true,
    ];
}
