<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class JobTrucksTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('job_trucks');
        $this->setPrimaryKey('job_truck_id');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id',
        ]);

        $this->belongsTo('Trucks', [
            'foreignKey' => 'truck_id',
        ]);
    }
}
