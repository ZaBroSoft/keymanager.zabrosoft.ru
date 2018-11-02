<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "guest".
 *
 * @property int $id
 * @property string $name
 * @property string $post
 */
class Guest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'guest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'post'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'post' => 'Post',
        ];
    }

    public function getGuestByName($name)
    {
        return Guest::find()->where(['name'=>$name])->one();
    }

    public function getKeysArray()
    {
        $guestKeys = GuestKey::find()->where(['guest_id' => $this->id])->all();
        $keys = [];
        $i = 0;
        foreach ($guestKeys as $guestKey){
            $keys[$i++] = $guestKey->key;
        }
        return $keys;
    }
}
