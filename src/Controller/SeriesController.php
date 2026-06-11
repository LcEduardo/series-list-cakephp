<?php

namespace App\Controller;

use App\Controller\AppController;

// AppController is the base controller class that all other controllers will inherit from.
// You can add common functionality to AppController that you want to be available in all controllers.
class SeriesController extends AppController
{
    public function index()
    {
        $series = [
            ['id' => 1, 'name' => 'Breaking Bad'],
            ['id' => 2, 'name' => 'Game of Thrones'],
            ['id' => 3, 'name' => 'Stranger Things'],
        ];

        $this->set(compact('series'));
    }
}