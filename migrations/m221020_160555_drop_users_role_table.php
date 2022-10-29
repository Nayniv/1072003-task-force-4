<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%users_role}}`.
 */
class m221020_160555_drop_users_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%users_role}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%users_role}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
