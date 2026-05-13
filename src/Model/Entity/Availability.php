<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Availability Entity
 *
 * @property int $availability_id
 * @property int $staff_id
 * @property \Cake\I18n\DateTime $start_datetime
 * @property \Cake\I18n\DateTime $end_datetime
 */
class Availability extends Entity
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
        'staff_id' => true,
        'start_datetime' => true,
        'end_datetime' => true,
    ];
}
