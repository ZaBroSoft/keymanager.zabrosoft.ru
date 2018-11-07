<?php
/* @var $this yii\web\View */

//$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js');
$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
$this->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');

?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="list-group">
            <a href="<?= \yii\helpers\Url::to(['addguest']) ?>" class="btn btn-default list-group-item">
                <div class="row">
                    <dic class="col-md-10 col-xs-10">
                        Добавить гостя
                    </dic>
                    <dic class="col-md-2 col-xs-2 text-right"></dic>
                </div>
            </a>
            <a href="<?= \yii\helpers\Url::to(['give-key']) ?>" class="btn btn-default list-group-item">
                <div class="row">
                    <dic class="col-md-10 col-xs-10">
                        Выдать брелок
                    </dic>
                    <dic class="col-md-2 col-xs-2 text-right"></dic>
                </div>
            </a>
            <a href="<?= \yii\helpers\Url::to(['free-key']) ?>" class="btn btn-default list-group-item">
                <div class="row">
                    <dic class="col-md-10 col-xs-10">
                        Свободные брелки
                    </dic>
                    <dic class="col-md-2 col-xs-2 text-right">
                        <div class="badge"><?= $freeKeys ?></div>
                    </dic>
                </div>
            </a>
            <a href="<?= \yii\helpers\Url::to(['list-request']) ?>" class="btn btn-default list-group-item <?= $requestCount > 0 ? 'list-group-item-danger' : '' ?>">
                <div class="row">
                    <dic class="col-md-10 col-xs-10">
                        Заявки
                    </dic>
                    <dic class="col-md-2 col-xs-2 text-right">
                        <div class="badge"><?= $requestCount ?></div>
                    </dic>
                </div>
            </a>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>