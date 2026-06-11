<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateGenre extends BaseMigration
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
        $table = $this->table('genre');
        $table->addColumn('description', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addIndex(['description'], [
            'name' => 'UNIQUE_GENRE_DESCRIPTION',
            'unique' => true,
        ]);
        $table->create();
    }
}
