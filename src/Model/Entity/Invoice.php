<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invoice Entity
 *
 * @property int $invoice_id
 * @property int $booking_id
 * @property int $customer_id
 * @property string $stripe_invoice_id
 * @property string|null $invoice_url
 * @property string $status
 * @property int|null $subtotal_cents
 * @property int|null $total_cents
 * @property \Cake\I18n\DateTime|null $sent_at
 * @property \Cake\I18n\DateTime|null $paid_at
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Booking $booking
 * @property \App\Model\Entity\Customer $customer
 */
class Invoice extends Entity
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
        'booking_id' => true,
        'customer_id' => true,
        'stripe_invoice_id' => true,
        'invoice_url' => true,
        'status' => true,
        'subtotal_cents' => true,
        'total_cents' => true,
        'sent_at' => true,
        'paid_at' => true,
        'created' => true,
        'modified' => true,
        'booking' => true,
        'customer' => true,
        'invoice_items' => true,
    ];
}
