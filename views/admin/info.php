<?php
use yii\bootstrap\Alert;
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <?php if ($info == 'add guest'): ?>
            <?php
            echo Alert::widget([
                'options' => [
                    'class' => 'alert-success'
                ],
                'body' => '<b>'. $guest->name .'</b> успешно добавлен.'
            ]);
            ?>
            <br>
            <?= \yii\helpers\Html::a('Добавить еще...',\yii\helpers\Url::to(['addguest']), ['class'=> 'btn btn-default btn-lg btn-block']); ?>
        <?php endif; ?>
    </div>



    <div class="col-md-3"></div>
</div>