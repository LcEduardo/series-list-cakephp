<?php

namespace App\Test\Fixture;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public function init(): void
    {
        $hasher = new DefaultPasswordHasher();

        $this->records = [
            [
                'id' => 1,
                'name' => 'Alice',
                'age' => 30,
                'email' => 'alice@example.com',
                'password' => $hasher->hash('password123'),
            ],
            [
                'id' => 2,
                'name' => 'Bob',
                'age' => 25,
                'email' => 'bob@example.com',
                'password' => $hasher->hash('password123'),
            ],
        ];

        parent::init();
    }
}