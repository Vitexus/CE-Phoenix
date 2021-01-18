<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Segmenets extends AbstractMigration {

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void {
        $users = $this->table('segments');
        $users->addColumn('name', 'string', ['limit' => 100])
                ->addColumn('hall', 'integer')
                ->addColumn('rows', 'integer')
                ->addColumn('cols', 'integer')
                ->addIndex(['hall'])
//                ->addForeignKey('hall', 'halls', 'id')
                ->create();
    }

}
