<?php

namespace app\models;

/**
 * This is the model class for table "bio".
 *
 * @property int $id
 * @property string $name
 * @property string $tax_name
 * @property string $tax_rank
 * @property int $taxon
 * @property int $parent
 * @property string $about
 */
class Bio extends Basic
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taxon', 'parent'], 'integer'],
            [['about'], 'string'],
            [['name', 'tax_name', 'tax_rank'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя записи в базе данных',
            'tax_name' => 'Tax Name',
            'tax_rank' => 'Tax Rank',
            'taxon' => 'Taxon',
            'parent' => 'Parent',
            'about' => 'Описание',
        ];
    }
}
