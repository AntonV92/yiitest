<?php

use yii\db\Migration;

/**
 * Class m210112_125957_data
 */
class m210112_125957_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents('./migrations/test_db_data.sql');

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210112_125957_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210112_125957_data cannot be reverted.\n";

        return false;
    }
    */
}
