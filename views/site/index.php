<?php

$script = <<< JS
    $("#txt_number_key").autocomplete({
        source: function(request, response){
            $.post("site/getguests",{data:request.term}, function(data){     
                response($.map(data, function(item) {
                    return item;
                }));
            });     
        },
        minLength: 3,
        close: function(){
            searchByNumberKey();
        }        
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-btn">
                <a href="<?= \yii\helpers\Url::to(['../key/request-key', 'number'=>'NaN', 'name'=>'']) ?>" class="btn btn-default" type="button">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </span>
            <input type="text" class="form-control" placeholder="Введите номер брелка или фамилию" id="txt_number_key">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="searchByNumberKey()">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </span>
        </div><!-- /input-группа -->
        <br>
        <div id="result"></div>

        <br>
        Мои заявки:<br>
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <td>ID</td>
                <td>Дата</td>
                <td>Гость</td>
                <td>Тип ключа</td>
                <td>Статус</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($requests as $request): ?>
                <?php
                    if ($request->status == \app\models\Request::STATUS_DONE || $request->status == \app\models\Request::STATUS_CANCELED){
                        continue;
                    }
                ?>
                <tr class="<?php
                    switch ($request->status){
                        case \app\models\Request::STATUS_SENDED:
                            echo 'info';
                            break;
                        case \app\models\Request::STATUS_DONE:
                            echo 'success';
                            break;
                        case \app\models\Request::STATUS_CANCELED:
                            echo 'danger';
                            break;
                        default:
                            echo 'active';
                            break;
                    }
                ?>">
                <td><?= $request->id ?></td>
                <td><?= $request->date ?></td>
                <td><?= $request->name ?></td>
                <td><?= $request->typeName ?></td>
                <td><?= $request->statusName ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages
        ]);
        ?>
    </div>
    <div class="col-md-3"></div>
</div>