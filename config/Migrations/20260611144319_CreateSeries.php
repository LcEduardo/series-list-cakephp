<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateSeries extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/guides/writing-migrations/migration-methods.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('series');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('genre_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('title', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('watched_episodes', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('qtd_episodes', 'integer', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('rating', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addCheckConstraint('rating >= 0.0 AND rating <= 10.0', [
            'name' => 'CHECK_SERIES_RATING_RANGE',
        ]);
        $table->addForeignKey('user_id', 'users', 'id', [
            'delete' => 'CASCADE',
            'update' => 'NO_ACTION',
        ]);
        $table->addForeignKey('genre_id', 'genre', 'id', [
            'delete' => 'NO_ACTION',
            'update' => 'NO_ACTION',
        ]);
        $table->create();
    }
}
