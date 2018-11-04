<?php

$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
$this->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');

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
        <h3>Поиск:</h3>
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="getFreeKey()">
                    <i class="glyphicon glyphicon-plus"></i>
                </button>
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
    </div>
    <div class="col-md-3"></div>
</div>