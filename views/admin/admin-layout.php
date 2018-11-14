<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Менеджер ключей</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?= \yii\helpers\Url::to(['index']) ?>">Админка </a>
                <button type="button" class="navbar-toggle offcanvas-toggle pull-right" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas" style="float:left;">
                    <span class="sr-only">Toggle navigation</span>
                    <span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </span>
                </button>
            </div>
            <div class="navbar-offcanvas navbar-offcanvas-touch" id="js-bootstrap-offcanvas">
                <ul class="nav navbar-nav">
                    <li>
                    <a href="<?= \yii\helpers\Url::to(['addguest']) ?>" class=""> Добавить гостя </a>
                    </li>
                    <li>
                    <a href="<?= \yii\helpers\Url::to(['give-key']) ?>" class=""> Выдать брелок </a>
                    </li>
                    <li>
                    <a href="<?= \yii\helpers\Url::to(['action-key']) ?>" class=""> Операции с брелками </a>
                    </li>
                    <li>
                    <a href="<?= \yii\helpers\Url::to(['free-key']) ?>" class=""> Свободные брелки </a>
                    </li>
                    <li>
                    <a href="<?= \yii\helpers\Url::to(['list-request']) ?>" class=""> Заявки </a>
                    </li>
                    <li>
                        <a href="<?= \yii\helpers\Url::to(['../site/index']) ?>" class=""> На главную </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        <?= $content ?>

    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ИП Заикин Н.В. <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

