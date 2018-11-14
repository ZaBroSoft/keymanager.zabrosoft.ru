<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $user_id
 * @property int $key_id
 * @property int $guest_id
 * @property string $name
 * @property string $post
 * @property int $type
 * @property int $access
 * @property int $bracelet
 * @property int $vip
 * @property string $other
 * @property int $status
 * @property string $date
 *
 * @property Guest $guest
 * @property Key $key
 */
class Request extends \yii\db\ActiveRecord
{

    const STATUS_SENDED = 10;
    const STATUS_ISJOB = 20;
    const STATUS_READY = 30;
    const STATUS_DONE = 40;
    const STATUS_CANCELED = 50;

    const TYPE_NONE = 0;
    const TYPE_CARD = 10;
    const TYPE_TRINKET_BLUE = 20;
    const TYPE_TRINKET_70 = 30;
    const TYPE_TRINKET_BLACK = 40;

    const BRACELET_NONE = 0;
    const BRACELET_YES = 10;

    const VIP_NONE = 0;
    const VIP_YES = 10;

    const ACCESS_MAX = 0;
    const ACCESS_MAX_WITHOUT_SHAB = 10;
    const ACCESS_MAX_WITHOUT_TRAKTOR = 20;
    const ACCESS_MAIN = 30;
    const ACCESS_MAIN_WITH_LOGI = 40;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'key_id', 'guest_id', 'type', 'access', 'bracelet', 'vip', 'status'], 'integer'],
            [['other'], 'string'],
            [['date'], 'safe'],
            [['name', 'post'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'key_id' => 'Key ID',
            'guest_id' => 'Guest ID',
            'name' => 'Name',
            'post' => 'Post',
            'type' => 'Type',
            'access' => 'Access',
            'bracelet' => 'Bracelet',
            'vip' => 'Vip',
            'other' => 'Other',
            'status' => 'Status',
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

    public function getUser()
    {
        switch ($this->user_id){
            case 100:
                return [
                    'id' => '100',
                    'username' => 'ucraft74',
                    'password' => 'Drakoola220289',
                    'authKey' => 'test100key',
                    'accessToken' => '100-token',
                ];
                break;
            case 101:
                return [
                    'id' => '101',
                    'username' => 'mshkola',
                    'password' => 'traktor74',
                    'authKey' => 'test101key',
                    'accessToken' => '101-token',
                ];
                break;
            case 102:
                return [
                    'id' => '102',
                    'username' => 'director',
                    'password' => 'arena74',
                    'authKey' => 'test102key',
                    'accessToken' => '102-token',
                ];
                break;
        }
    }

    public function getStatusName()
    {
        switch ($this->status){
            case Request::STATUS_SENDED:
                return 'Отправлено';
                break;
            case Request::STATUS_ISJOB:
                return 'В работе';
                break;
            case Request::STATUS_READY:
                return 'Готово к выдаче';
                break;
            case Request::STATUS_DONE:
                return 'Выполнено';
                break;
            case Request::STATUS_CANCELED:
                return 'Отменено';
                break;
        }
    }

    public function getTypeName()
    {
        switch ($this->type){
            case Request::TYPE_NONE:
                if ($this->bracelet == Request::BRACELET_YES){
                    return 'Браслет';
                }else{
                    return 'Не указан';
                }
                break;
            case Request::TYPE_CARD:
                return 'Карта';
                break;
            case Request::TYPE_TRINKET_BLUE:
                return 'Синий брелок';
                break;
            case Request::TYPE_TRINKET_70:
                return 'Брелок 70 лет';
                break;
            case Request::TYPE_TRINKET_BLACK:
                return 'Черный брелок';
                break;
        }
    }
}
