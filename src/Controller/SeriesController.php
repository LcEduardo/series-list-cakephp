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

    public function add()
    {   
        $serie = $this->Series->newEmptyEntity();

        if ($this->request->is('post')) {
            $serie = $this->Series->patchEntity($serie, $this->request->getData());
            $serie->user_id = 1;

            if ($this->Series->save($serie)) {
                return $this->redirect(['action' => 'index']);
            }
        }

        $genres = $this->Series->Genre->find('list', [
            'keyField' => 'id',
            'valueField' => 'description',
        ]);
        $this->set(compact('serie', 'genres'));
    }
}