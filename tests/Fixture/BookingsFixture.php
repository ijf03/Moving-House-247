<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BookingsFixture
 */
class BookingsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'booking_id' => 1,
                'customer_id' => 1,
                'job_type_id' => 1,
                'pickup_address' => 'Lorem ipsum dolor sit amet',
                'dropoff_address' => 'Lorem ipsum dolor sit amet',
                'job_date' => '2026-04-18',
                'job_time' => '09:50:23',
                'status' => 'Lorem ipsum dolor ',
                'created' => '2026-04-18 09:50:23',
            ],
        ];
        parent::init();
    }
}
