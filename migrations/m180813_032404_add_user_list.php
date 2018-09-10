<?php

use yii\db\Migration;

/**
 * Class m180813_032404_add_user_list
 */
class m180813_032404_add_user_list extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_fio%}}', [
            'id' => $this->primaryKey(),
            'user_f' => $this->string(),    //Фамилия
            'user_i' => $this->string(),    //Имя
            'user_o' => $this->string(),    //Отчество
            'date_add'=>$this->date(),      //Дата создания
            'date_update' => $this->date(), //Дата обновления
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_fio%}}');
    }

}
