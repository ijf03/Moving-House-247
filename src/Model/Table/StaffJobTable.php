<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class StaffJobTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('staff_job');
        $this->setPrimaryKey('allocation_id');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id',
        ]);
    }
}
