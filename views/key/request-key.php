<?php
use yii\bootstrap\ActiveForm;

$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
$this->registerCssFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');

$script = <<< JS
    $("#txt_name").autocomplete({
        source: function(request, response){
            $.post("../admin/getguests",{data:request.term}, function(data){     
                response($.map(data, function(item) {
                    return item.name;
                }));
            });     
        },
        minLength: 3,
        select: function (event, ui) {
            if ($("#post").hasClass('hidden')) {
                $.post("../site/search-by-name", {num: ui.item}, function(data) {
                    if (data == null) return;
                    $("#guest_post").html(data.guest.post);
                    $("#post").removeClass('hidden');
                });   
            }
        }   
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);

?>

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="text-center"><h3>Заявка</h3></div>

        <div>
            <div class="input-group input-group-lg">
                <span class="input-group-addon" id="basic-addon1">Ключ</span>
                <input type="text" class="form-control" value="4"
                       aria-describedby="basic-addon1" id="txt_number_key">
            </div>
            <br>
            <div class="input-group input-group-lg">
                <span class="input-group-addon" id="basic-addon1">Имя</span>
                <input type="text" class="form-control" placeholder="Введите имя"
                       aria-describedby="basic-addon1" id="txt_name" onblur="txt_name_onBlur()">
            </div>
            <br>
            <div class="hidden" id="post">
                <h4>Должность:</h4>
                <div class="well" id="guest_post"></div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-7 col-xs-7">
                    <h4>Тип ключа:</h4>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Карта ( Белая )</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Брелок (синий)</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Брелок (17/18 - 70 лет)</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Брелок (18/19 - черный)</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Браслет</label>
                    </div>
                </div>
                <div class="col-md-5 col-xs-5">
                    <h4>Доступ:</h4>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Максимум</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Основной</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">VIP вход</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Штаб</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Раздевалки</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Ложи</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="form-group">
                        <label for="comment">Примечание:</label>
                        <textarea class="form-control" rows="5" id="comment"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <button type="button" class="btn btn-primary btn-block btn-lg" onclick="btnSendRequest_Click()">Отправить</button>

    </div>
    <div class="col-md-3"></div>

    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Еще один момент...</h4>
                </div>
                <div class="modal-body">
                    <div>
                        Этого гостя еще нет в базе. Для добавления его в базу рекомендуется указать должность:
                    </div>
                    <br>
                    <input type="text" class="form-control" placeholder="Введите должность"
                           aria-describedby="basic-addon1" id="modal_txt_post">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <a href="#" type="button" class="btn btn-primary">Отправить заявку</a>
                </div>
            </div>
        </div>
    </div>

</div>