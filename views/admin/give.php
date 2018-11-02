<?php
use yii\bootstrap\ActiveForm;

$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
$this->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');

$script = <<< JS
    $("#txt_name").autocomplete({
        source: function(request, response){
            $.post("getguests",{data:request.term}, function(data){     
                response($.map(data, function(item) {
                    return item.name;
                }));
            });     
        }   
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);

?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <h3 class="text-center">Выдать брелок</h3>
        <br>
        <div id="result"></div>
        <br>
        <div class="input-group input-group-lg">
            <span class="input-group-addon" id="basic-addon1">Ключ</span>
            <input type="text" class="form-control" placeholder="Введите номер ключа"
                   aria-describedby="basic-addon1" id="txt_number_key">
        </div>
        <br>
        <div class="input-group input-group-lg">
            <span class="input-group-addon" id="basic-addon1">Имя</span>
            <input type="text" class="form-control" placeholder="Введите имя"
                   aria-describedby="basic-addon1" id="txt_name">
        </div>
        <br>
        <button type="button" class="btn btn-primary btn-block btn-lg" onclick="giveKey()">Выдать</button>
    </div>
    <div class="col-md-3"></div>
</div>