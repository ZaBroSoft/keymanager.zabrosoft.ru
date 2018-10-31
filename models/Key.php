<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "key".
 *
 * @property int $id
 * @property int $number
 * @property int $status
 */
class Key extends \yii\db\ActiveRecord
{
    const STATUS_FREE = 10;
    const STATUS_ISSUED = 20;
    const RESULT_RESERVE = 30;
    const RESULT_STOCK = 40;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number'], 'required'],
            [['number', 'status'], 'integer'],
            [['number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'status' => 'Status',
        ];
    }

    public function getKeyByNumber($number)
    {
        return Key::find()->where(['number'=>$number])->one();
    }
}
