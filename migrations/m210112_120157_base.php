<?php

use yii\db\Migration;

/**
 * Class m210112_120157_base
 */
class m210112_120157_base extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {   
        $sql = file_get_contents('./migrations/test_db_structure.sql');

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210112_120157_base cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210112_120157_base cannot be reverted.\n";

        return false;
    }
    */
}
