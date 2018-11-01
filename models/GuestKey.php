<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guest_key".
 *
 * @property int $id
 * @property int $guest_id
 * @property int $key_id
 * @property string $date
 *
 * @property Guest $guest
 * @property Key $key
 */
class GuestKey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guest_key';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['guest_id', 'key_id'], 'required'],
            [['guest_id', 'key_id'], 'integer'],
            [['date'], 'safe'],
            [['guest_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guest::className(), 'targetAttribute' => ['guest_id' => 'id']],
            [['key_id'], 'exist', 'skipOnError' => true, 'targetClass' => Key::className(), 'targetAttribute' => ['key_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guest_id' => 'Guest ID',
            'key_id' => 'Key ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuest()
    {
        return $this->hasOne(Guest::className(), ['id' => 'guest_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKey()
    {
        return $this->hasOne(Key::className(), ['id' => 'key_id']);
    }
}
