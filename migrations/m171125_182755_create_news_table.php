<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m171125_182755_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id'      => $this->primaryKey(),
            'title'   => $this->string(100)->notNull(),
            'content' => $this->text()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('news');
    }
}
