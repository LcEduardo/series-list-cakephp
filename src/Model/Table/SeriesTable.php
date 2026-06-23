<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class SeriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('series');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    public function getAllSeries()
    {
        return $this->find('all')
            ->contain(['Users'])
            ->toArray();
    }
}