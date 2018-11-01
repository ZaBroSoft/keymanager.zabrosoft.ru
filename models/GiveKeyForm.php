<?php
/**
 * Created by PhpStorm.
 * User: ucraft74
 * Date: 01.11.18
 * Time: 16:08
 */

namespace app\models;


use yii\base\Model;

class GiveKeyForm extends Model
{
    public $key;
    public $guest;
    public $date;

    public function rules()
    {
        return [
            [['key', 'guest'], 'required'],
            ['key', 'integer' ],
            []
        ];
    }
}