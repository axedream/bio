<?php

use yii\db\Migration;


class m180907_074649_change_achitecture extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%bio%}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->defaultValue(''),
            'tax_name'=>$this->string()->defaultValue(''),
            'tax_rank'=>$this->string()->defaultValue(''),
            'taxon'=>$this->integer(),
            'parent'=>$this->integer(),
            'about'=>$this->text()
        ], $tableOptions);

        $this->createTable('{{%pacient%}}', [
            'id' => $this->primaryKey(),
            'count' => $this->integer(),
            'count_norm'=>$this->integer(),
            'user_fio_id'=>$this->integer(),
            'bio_id'=>$this->integer(),
        ], $tableOptions);

        $this->dropTable('{{%user_excel%}}');
    }

    public function safeDown()
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


        $this->dropTable('{{%bio%}}');
        $this->dropTable('{{%pacient%}}');
    }


}
