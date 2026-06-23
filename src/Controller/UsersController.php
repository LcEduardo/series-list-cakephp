<?php

namespace App\Controller;

use App\Controller\AppController;

// AppController is the base controller class that all other controllers will inherit from.
// You can add common functionality to AppController that you want to be available in all controllers.
class UsersController extends AppController
{
    public function index()
    {
        $users = $this->Users->find('all')->toArray();

        $this->set(compact('users'));
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('User has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add user. Please try again.'));
        }

        $this->set(compact('user'));
    }
}
