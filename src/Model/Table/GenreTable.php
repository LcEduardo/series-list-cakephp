<?php

 namespace App\Model\Table;

  use Cake\ORM\Table;

  class GenreTable extends Table
  {
      public function initialize(array $config): void
      {
          parent::initialize($config);

          $this->setTable('genre');
          $this->setPrimaryKey('id');
      }
  }