<?php
/**
 * Created by PhpStorm.
 * User: ucraft74
 * Date: 01.11.18
 * Time: 10:14
 */

namespace app\models;

use Yii;
use yii\base\Model;

class NewGuestForm extends Model
{
    public $name;
    public $post;

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Это поле не может быть пустым'],
            ['name', 'string'],
            ['name', 'unique', 'targetClass' => 'app\models\Guest', 'message' => 'Такой гость уже зарегестрирован'],
            ['post', 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'post' => 'Должность',
        ];
    }

    public function addGuest()
    {
        $guest = new Guest();
        $guest->name = $this->name;
        $guest->post = $this->post;

        $guest->save();
        return $guest;
    }
}