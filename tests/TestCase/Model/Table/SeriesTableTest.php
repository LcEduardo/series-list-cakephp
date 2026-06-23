<?php

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class SeriesTableTest extends TestCase
{

    protected array $fixtures = ['app.Series', 'app.Users', 'app.Genre'];

    public function testTitleRequest() 
    {
        $seriesTable = $this->getTableLocator()->get('Series');

            $series = $seriesTable->newEntity([
                'user_id' => 1,
                'genre_id' => 1,
                'title' => '',
                'watched_episodes' => 0,
                'qtd_episodes' => 10,
                'rating' => 0.0,
            ]);

            $this->assertArrayHasKey('title', $series->getErrors());
    }

    public function testUserIdMustExist()
    {
        $seriesTable = $this->getTableLocator()->get('Series');

        $series = $seriesTable->newEntity([
            'user_id' => 999,          // não existe na fixture de Users
            'genre_id' => 1,
            'title' => 'Valid Title',
            'watched_episodes' => 0,
            'qtd_episodes' => 10,
            'rating' => 0.0,
        ]);

        $result = $seriesTable->save($series);

        $this->assertFalse($result);
        $this->assertArrayHasKey('user_id', $series->getErrors());
    }

    public function testGenreIdMustExist() 
    {
        $seriesTable = $this->getTableLocator()->get('Series');

        $series = $seriesTable->newEntity([
            'user_id' => 1,          
            'genre_id' => 999,// não existe na fixture de Users
            'title' => 'Valid Title',
            'watched_episodes' => 0,
            'qtd_episodes' => 10,
            'rating' => 0.0,
        ]);

        $result = $seriesTable->save($series);

        $this->assertFalse($result);
        $this->assertArrayHasKey('genre_id', $series->getErrors());
    }
}

