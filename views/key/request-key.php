<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

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
    <div class="col-md-6" id="request_content">
        <div class="text-center"><h3>Заявка</h3></div>

        <div>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Ключ</span>
                <input type="text" class="form-control" value="<?= $key != null ? Html::encode($key->number) : '' ?>" placeholder="Введите номер брелка"
                       aria-describedby="basic-addon1" id="txt_number_key">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" onclick="getFreeKey()">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                </span>
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Имя</span>
                <input type="text" class="form-control"
                       value="<?= $guest == null ? Html::encode($requestName) : Html::encode($guest->name) ?>"
                       placeholder="Введите имя"
                       aria-describedby="basic-addon1" id="txt_name" onblur="txt_name_onBlur()">
            </div>
            <br>
            <div class="<?= $guest == null ? 'hidden' : '' ?>" id="post">
                <h4>Должность:</h4>
                <div class="well" id="guest_post">
                    <?= $guest == null ? '' : Html::encode($guest->post)?>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-7 col-xs-7">
                    <h4>Тип ключа:</h4>
                    <div class="radio">
                        <label><input type="radio" name="optradio"  id="type_0">Нет</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio"  id="type_1">Карта ( Белая )</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio"  id="type_2">Брелок (синий)</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio"
                            <?php if ($key != null) {
                                if ($key->number >= 1 && $key->number <=1200){
                                    echo 'checked';
                                }
                            }
                            ?>
                            id="type_3">Брелок (17/18 - 70 лет)</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio"
                            <?php if ($key != null) {
                                if ($key->number > 1200 && $key->number <=1900){
                                    echo 'checked';
                                }
                            }
                            ?>
                            id="type_4">Брелок (18/19 - черный)</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="" id="ch_bracelet">Браслет</label>
                    </div>
                </div>
                <div class="col-md-5 col-xs-5">
                    <h4>Доступ:</h4>
                        <div class="radio">
                            <label><input type="radio" name="optradio1" id="access_0">Максимум</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio1" id="access_1">М - штаб</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio1" id="access_2">М - Трактор</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio1" id="access_3">Осн.</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio1" id="access_4">Осн. + ложи</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" id="ch_vip">VIP</label>
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
                    <button type="button" class="btn btn-primary" onclick="modal_sendRequest()">Отправить заявку</button>
                </div>
            </div>
        </div>
    </div>

</div>