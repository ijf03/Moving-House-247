<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StorageUnitsFixture
 */
class StorageUnitsFixture extends TestFixture
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
                'storage_unit_id' => 1,
                'unit_code' => 'Lorem ipsum dolor sit amet',
                'facility_name' => 'Lorem ipsum dolor sit amet',
                'unit_size_m3' => 1.5,
                'status' => 'Lorem ipsum dolor sit amet',
                'security_level' => 'Lorem ipsum dolor sit amet',
                'is_climate_controlled' => 1,
                'is_active' => 1,
                'created' => '2026-05-03 09:01:25',
                'modified' => '2026-05-03 09:01:25',
            ],
        ];
        parent::init();
    }
}
