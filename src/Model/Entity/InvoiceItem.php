<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvoiceItem Entity
 *
 * @property int $invoice_item_id
 * @property int $invoice_id
 * @property string $description
 * @property string $quantity
 * @property int $unit_price_cents
 * @property int $line_total_cents
 * @property int $sort_order
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Invoice $invoice
 */
class InvoiceItem extends Entity
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
        'invoice_id' => true,
        'description' => true,
        'quantity' => true,
        'unit_price_cents' => true,
        'line_total_cents' => true,
        'sort_order' => true,
        'created' => true,
        'modified' => true,
        'invoice' => true,
    ];
}
