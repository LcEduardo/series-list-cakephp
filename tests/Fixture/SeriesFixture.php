<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class SeriesFixture extends TestFixture
{
    public string $table = 'series';

    public array $records = [
        ['id' => 1, 'user_id' => 1, 'genre_id' => 1, 'title' => 'Alice Serie One',  'watched_episodes' => 3, 'qtd_episodes' => 10, 'rating' => 8.5],
        ['id' => 2, 'user_id' => 1, 'genre_id' => 1, 'title' => 'Alice Serie Two',  'watched_episodes' => 5, 'qtd_episodes' => 12, 'rating' => 7.0],
        ['id' => 3, 'user_id' => 2, 'genre_id' => 1, 'title' => 'Bob Secret Serie', 'watched_episodes' => 1, 'qtd_episodes' => 8,  'rating' => 6.0],
    ];
}