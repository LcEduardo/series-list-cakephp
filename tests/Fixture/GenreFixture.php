<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class GenreFixture extends TestFixture
{
    public string $table = 'genre';

    public array $records = [
        ['id' => 1, 'description' => 'Drama'],
        ['id' => 2, 'description' => 'Comedy'],
    ];
}