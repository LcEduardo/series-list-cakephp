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
    }

    public function getAllSeries()
    {
        return $this->find('all')->toArray();
    }
}