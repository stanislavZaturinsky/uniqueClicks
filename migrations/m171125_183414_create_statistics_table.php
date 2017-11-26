<?php

use yii\db\Migration;

/**
 * Handles the creation of table `statistics`.
 */
class m171125_183414_create_statistics_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('statistics', [
            'id'            => $this->primaryKey(),
            'news_id'       => $this->integer(11)->notNull(),
            'hash_code'     => $this->string(32)->notNull(),
            'count_clicks'  => $this->integer(11)->notNull(),
            'client_ip'     => $this->string(20)->notNull(),
            'country_code'  => $this->string(2)->notNull(),
            'date'          => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'news_id_fk',
            'statistics',
            'news_id',
            'news',
            'id',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('statistics');
    }
}
