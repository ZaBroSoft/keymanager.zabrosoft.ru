<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "key".
 *
 * @property int $id
 * @property int $number
 * @property int $status
 * @property int $old_status
 *
 * @property GuestKey[] $guestKeys
 * @property Request[] $requests
 */
class Key extends \yii\db\ActiveRecord
{
    const STATUS_FREE = 10; // у техника
    const STATUS_ISSUED = 20; // выдан гостю
    const STATUS_RESERVE = 30;  // в резерве
    const STATUS_STOCK = 40; // у маркетолога
    const STATUS_INREQUEST = 50; // в запросе
    const STATUS_LOSS = 60; // Утрачен
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
            [['number', 'status', 'old_status'], 'integer'],
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
            'old_status' => 'Old Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGuestKeys()
    {
        return $this->hasMany(GuestKey::className(), ['key_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['key_id' => 'id']);
    }

    public function getKeyByNumber($number)
    {
        return Key::findOne(['number' => $number]);
    }

    public function getGuest()
    {
        $guestKey = GuestKey::findOne(['key_id'=>$this->id]);
        if ($guestKey == null) return null;
        return Guest::findOne($guestKey->guest_id);
    }

    public function getStatusName()
    {
        switch ($this->status){
            case Key::STATUS_FREE:
                return 'У техника';
                break;
            case Key::STATUS_ISSUED:
                return 'Выдан';
                break;
            case Key::STATUS_RESERVE:
                return 'В резерве';
                break;
            case Key::STATUS_STOCK:
                return 'У маркетолога';
                break;
            case Key::STATUS_INREQUEST:
                return 'В запросе';
                break;
            case Key::STATUS_LOSS:
                return 'Утрачен';
                break;
            default:
                return 'Неизвестно';
                break;
        }
    }
}
