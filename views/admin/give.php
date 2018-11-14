<?php
use yii\bootstrap\ActiveForm;

$script = <<< JS
    $("#txt_name").autocomplete({
        source: function(request, response){
            $.post("getguests",{data:request.term}, function(data){     
                response($.map(data, function(item) {
                    return item.name;
                }));
            });     
        },
        minLength: 3,   
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
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Ключ</span>
            <input type="text" class="form-control" placeholder="Введите номер ключа"
                   aria-describedby="basic-addon1" id="txt_number_key">
        </div>
        <br>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Имя</span>
            <input type="text" class="form-control" placeholder="Введите имя"
                   aria-describedby="basic-addon1" id="txt_name">
        </div>
        <br>
        <h4>Должность:</h4>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">
                <input type="checkbox" aria-label="" id="ch_newGuest">
            </span>
            <input type="textarea" class="form-control" placeholder="Введите должность"
                   aria-describedby="basic-addon1" id="txt_post">
        </div>
        <br>
        <button type="button" class="btn btn-primary btn-block" onclick="giveKey()">Выдать</button>
    </div>
    <div class="col-md-3"></div>
</div>