<?php
/* @var $this yii\web\View */

//$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js');
$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
$this->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');

?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="btn-group btn-block btn-group-lg">
            <a href="<?= \yii\helpers\Url::to(['addguest']) ?>" class="btn btn-default btn-block">Добавить гостя</a>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>