<?php

use yii\db\Migration;

/**
 * Class m171125_190113_insert_news
 */
class m171125_190113_insert_news extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $text =
           "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt 
            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in 
            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat 
            non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. The text №";

        for ($i = 1; $i <= 12; $i++) {
            $this->insert('news', [
                'title'   => 'News №' . $i,
                'content' => $text . $i,
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m171125_190113_insert_news cannot be reverted.\n";

        return false;
    }
}
