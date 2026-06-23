<?php

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class SeriesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    public array $fixtures = [
        'app.Series', 'app.Users', 'app.Genre'
    ];

    public function testIndex()
    {
        $this->get('/series'); // Fiz um método GET para a rota /series
        $this->assertResponseOk();
    }


    public function testAddPersistsSeries()
    {
        $data = [
            'user_id' => 1,
            'genre_id' => 1,
            'title' => 'New Series',
            'watched_episodes' => 0,
            'qtd_episodes' => 10,
            'rating' => 0.0
        ];

        $this->enableCsrfToken();
        $this->post('/series/add', $data);

        $this->assertResponseSuccess();

        $series = $this->getTableLocator()->get('Series');
        $this->assertSame(1, $series->find()->where(['title' => 'New Series'])->count());   
    }


}