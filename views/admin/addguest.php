<?php
use yii\bootstrap\ActiveForm;
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'post')->textarea(['rows' => 5]) ?>

            <?= \yii\helpers\Html::submitButton('Добавить', ['class' => 'btn btn-success btn-block']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="col-md-3"></div>
</div>