<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TrucksFixture
 */
class TrucksFixture extends TestFixture
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
                'truck_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'rego' => 'Lorem ipsum dolor ',
                'truck_size' => 'Lorem ipsum dolor sit amet',
                'capacity_m3' => 1.5,
                'max_payload_kg' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'current_location' => 'Lorem ipsum dolor sit amet',
                'next_service_date' => '2026-05-03',
                'is_active' => 1,
                'created' => '2026-05-03 09:01:27',
                'modified' => '2026-05-03 09:01:27',
            ],
        ];
        parent::init();
    }
}
