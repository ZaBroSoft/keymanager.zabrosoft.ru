<?php
/* @var $this yii\web\View */
?>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Введите номер брелка" id="txt_number_key">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="searchByNumberKey()">Найти</button>
            </span>
        </div><!-- /input-группа -->
        <hr>
        <div id="result">

        </div>
        <br>
    </div>
    <div class="col-md-3"></div>
</div>
