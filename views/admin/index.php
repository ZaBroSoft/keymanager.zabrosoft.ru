<?php
/* @var $this yii\web\View */

//$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js');
$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
$this->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');

?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <a href="<?= \yii\helpers\Url::to(['addguest']) ?>" class="btn btn-default btn-block btn-lg">Добавить гостя</a>
        <a href="<?= \yii\helpers\Url::to(['give-key']) ?>" class="btn btn-default btn-block btn-lg">Выдать брелок</a>
        <a href="#" class="btn btn-default btn-block btn-lg">Выдать брелок новому гостю</a>
    </div>
    <div class="col-md-3"></div>
</div>