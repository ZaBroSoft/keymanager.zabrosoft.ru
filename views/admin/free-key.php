<?php

?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        Свободных ключей : <b><?= $keyCount ?></b>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Введите номер брелка..." id="free_key"
            value="<?= $nextKey ?>">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="add_free_key()">
                    <i class="glyphicon glyphicon-plus"></i>
                </button>
            </span>
        </div><!-- /input-группа -->
        <br>
        <div class="list-group">
            <?php foreach ($models as $model): ?>
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <h5>#<?= $model->number ?></h5>
                        </div>
                        <div class="col-md-6 col-xs-6 text-right">
                            <a href="#" class="btn btn-primary">
                                <i class="glyphicon glyphicon-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
            echo \yii\widgets\LinkPager::widget([
                'pagination' => $pages
            ]);
            ?>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>