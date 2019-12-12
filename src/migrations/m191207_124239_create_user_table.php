<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m191207_124239_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%user}}',
            [
                'id' => $this->primaryKey(),
                'email' => $this->string()->notNull()->unique(),
                'phone' => $this->string()->notNull()->unique(),
                'name' => $this->string()->notNull(),
                'sex' => $this->boolean(),

                'year_of_birth' => $this->integer()->notNull(),
                'month_of_birth' => $this->integer()->notNull(),
                'day_of_birth' => $this->integer()->notNull(),

                'lastname' => $this->string()->notNull(),
                'password_hash' => $this->string()->notNull(),

                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
