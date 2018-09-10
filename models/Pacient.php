<?php

namespace app\models;

/**
 * This is the model class for table "pacient".
 *
 * @property int $id
 * @property int $count
 * @property int $count_norm
 * @property int $user_fio_id
 * @property int $bio_id
 */
class Pacient extends Basic
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pacient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count', 'count_norm', 'user_fio_id', 'bio_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => 'count',
            'count_norm' => 'count_norm',
            'user_fio_id' => 'ID Пациента',
            'bio_id' => 'ID Ишщ',
        ];
    }

    public function getBio()
    {
        return $this->hasOne(Bio::className(), ['id' => 'bio_id']);
    }
}
