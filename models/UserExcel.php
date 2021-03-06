<?php

namespace app\models;

use Yii;
use app\models\user\User;

/**
 * This is the model class for table "user_excel".
 *
 * @property int $id
 * @property int $user_fio_id
 * @property string $tax_name
 * @property string $tax_rank
 * @property int $count
 * @property int $count_norm
 * @property int $taxon
 * @property int $parent
 * @property string $tax_group_name
 * @property string $superkingdom
 * @property string $date_add
 * @property string $date_update
 */
class UserExcel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_excel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_fio_id', 'count', 'count_norm', 'taxon', 'parent'], 'integer'],
            [['date_add', 'date_update'], 'safe'],
            [['tax_name', 'tax_rank', 'tax_group_name', 'superkingdom'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_fio_id' => 'User Fio ID',
            'tax_name' => 'Tax Name',
            'tax_rank' => 'Tax Rank',
            'count' => 'Count',
            'count_norm' => 'Count Norm',
            'taxon' => 'Taxon',
            'parent' => 'Parent',
            'tax_group_name' => 'Tax Group Name',
            'superkingdom' => 'Superkingdom',
            'date_add' => 'Date Add',
            'date_update' => 'Date Update',
        ];
    }

    public function beforeSave($insert)
    {

        if($this->isNewRecord){
            $this->date_add = User::getNowDate();
        } else {
            $this->date_update = User::getNowDate();
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

}
