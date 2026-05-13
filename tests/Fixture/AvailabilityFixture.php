<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AvailabilityFixture
 */
class AvailabilityFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'availability';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'availability_id' => 1,
                'staff_id' => 1,
                'start_datetime' => 1778243783,
                'end_datetime' => 1778243783,
            ],
        ];
        parent::init();
    }
}
