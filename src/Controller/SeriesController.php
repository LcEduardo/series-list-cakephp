<?php

namespace App\Controller;

use App\Controller\AppController;

// AppController is the base controller class that all other controllers will inherit from.
// You can add common functionality to AppController that you want to be available in all controllers.
class SeriesController extends AppController
{
    public function index()
    {
        $series = $this->Series->getAllSeries();

        $this->set(compact('series'));
    }
}