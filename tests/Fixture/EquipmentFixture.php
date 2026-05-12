<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentFixture
 */
class EquipmentFixture extends TestFixture
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
                'equipment_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'category' => 'Lorem ipsum dolor sit amet',
                'quantity_available' => 1,
                'status' => 'Lorem ipsum dolor sit amet',
                'storage_location' => 'Lorem ipsum dolor sit amet',
                'condition_notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'is_active' => 1,
                'created' => '2026-05-03 09:00:47',
                'modified' => '2026-05-03 09:00:47',
            ],
        ];
        parent::init();
    }
}
