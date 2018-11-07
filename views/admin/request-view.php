<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="text-right">
            <a href="<?= \yii\helpers\Url::to(['list-request']) ?>" class="btn btn-primary">Список заявок</a>
        </div>
        Брелок: <b><?= $request->key != null ? $request->key->number : 'Нет'?></b>
        <br>
        Гость: <b><?= $request->guest != null ? $request->guest->name : 'Нет' ?></b>
        <br>
        <?php if ($request->guest == null): ?>
            <br>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Имя</span>
            <input type="text" class="form-control" placeholder="Введите имя"
                   aria-describedby="basic-addon1" value="<?= $request->name ?>" id="txt_request_name">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="addGuest(<?= $request->id ?>)">
                    <i class="glyphicon glyphicon-plus"></i>
                </button>
            </span>
        </div>
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Должность</span>
            <input type="text" class="form-control" placeholder="Введите должность"
                   aria-describedby="basic-addon1"б value="<?= $request->post ?>" id="txt_request_post">
        </div>
        <?php endif; ?>
        <br>
        Тип ключа: <?php
        switch ($request->type){
            case \app\models\Request::TYPE_NONE:
                echo '<b>Нет</b>';
                break;
            case \app\models\Request::TYPE_CARD:
                echo '<b>Стандартная карта</b>';
                break;
            case \app\models\Request::TYPE_TRINKET_BLUE:
                echo '<b>Синий брелок</b>';
                break;
            case \app\models\Request::TYPE_TRINKET_70:
                echo '<b>Брелок 70 лет</b>';
                break;
            case \app\models\Request::TYPE_TRINKET_BLACK:
                echo '<b>Черный брелок</b>';
                break;
        }
        ?>
        <br>
        Браслет: <b><?= $request->bracelet == \app\models\Request::BRACELET_YES ? 'Да' : 'Нет' ?></b>
        <br>
        Уровень доступа: <b><?php
            if ($request->access != null){
                switch ($request->access){
                    case \app\models\Request::ACCESS_MAX:
                        echo '<b>Максимум</b>';
                        break;
                    case \app\models\Request::ACCESS_MAX_WITHOUT_SHAB:
                        echo '<b>Максимум без штаба</b>';
                        break;
                    case \app\models\Request::ACCESS_MAX_WITHOUT_TRAKTOR:
                        echo '<b>Все кроме Трактора</b>';
                        break;
                    case \app\models\Request::ACCESS_MAIN:
                        echo '<b>Основной</b>';
                        break;
                    case \app\models\Request::ACCESS_MAIN_WITH_LOGI:
                        echo '<b>Основной + ложи</b>';
                        break;
                }
            }
            ?></b>
        <br>
        VIP: <b><?= $request->vip == \app\models\Request::VIP_YES ? 'Да' : 'Нет' ?></b>
        <br>
        Статус: <?php
            switch ($request->status){
                case \app\models\Request::STATUS_SENDED:
                    echo '<b>Отправлена</b>';
                    break;
                case \app\models\Request::STATUS_ISJOB:
                    echo '<b>В работе</b>';
                    break;
                case \app\models\Request::STATUS_READY:
                    echo '<b>Готова</b>';
                    break;
                case \app\models\Request::STATUS_DONE:
                    echo '<b>Завершена</b>';
                    break;
                case \app\models\Request::STATUS_CANCELED:
                    echo '<b>Отклонена</b>';
                    break;
            }
        ?>
        <br>
        Примечание:
        <div class="well">
            <?= $request->other ?>
        </div>
    </div>
    <div class="col-md-3"></div>
</div>
<?php if ($request->status != \app\models\Request::STATUS_CANCELED && $request->status != \app\models\Request::STATUS_DONE): ?>
<br>
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="btn-group btn-group-justified" role="group">
            <a href="<?= \yii\helpers\Url::to(['change-status', 'id'=>$request->id, 'status'=> 20]) ?>"
               class="btn btn-primary">В работу</a>
            <a href="<?= \yii\helpers\Url::to(['change-status', 'id'=>$request->id, 'status'=> 30]) ?>"
               class="btn btn-warning" >Готова</a>
            <a href="<?= \yii\helpers\Url::to(['change-status', 'id'=>$request->id, 'status'=> 40]) ?>"
               class="btn btn-success">Выдать</a>
            <a href="<?= \yii\helpers\Url::to(['change-status', 'id'=>$request->id, 'status'=> 50]) ?>"
               class="btn btn-danger">Отменить</a>
        </div>
    </div>
</div>
<?php endif; ?>