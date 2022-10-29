<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%executor_categories}}`.
 */
class m221020_171155_create_executor_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%executor_categories}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'category_id' => $this->integer()
        ]);

        $this->addForeignKey('fk-executor_categories-user_id', 'executor_categories', 'user_id', 'users', 'id');
        $this->addForeignKey('fk-executor_categories-category_id', 'executor_categories','category_id', 'categories', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%executor_categories}}');
    }
}
