<?php

use yii\db\Migration;
use yii\db\pgsql\Schema;

class m170204_044320_db_init extends Migration {
    public function up() {
        $this->createTable('parts', [
            'part_id' => Schema::TYPE_PK,
            'good_id' => $this->integer()->unsigned()->notNull(),
            'quantity' => $this->integer()->unsigned()->notNull(),
            'timestamp' => $this->bigInteger()->unsigned()->notNull()
        ]);
    }

    public function down() {
        $this->dropTable('parts');
    }
}
