<?php

use yii\db\Migration;

/**
 * Class m180814_045736_add_excel_table
 */
class m180814_045736_add_excel_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_excel%}}', [
            'id' => $this->primaryKey(),
            'user_fio_id'=>$this->integer(),
            'tax_name'=>$this->string(255)->defaultValue(''),
            'tax_rank'=>$this->string(255)->defaultValue(''),
            'count'=>$this->integer()->defaultValue(0),
            'count_norm'=>$this->integer()->defaultValue(0),
            'taxon'=>$this->integer()->defaultValue(0),
            'parent'=>$this->integer()->defaultValue(0),
            'tax_group_name'=>$this->string(255)->defaultValue(''),
            'superkingdom'=>$this->string(255)->defaultValue(''),
            'date_add'=>$this->date(),      //Дата создания
            'date_update' => $this->date(), //Дата обновления
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_excel%}}');
    }
}
