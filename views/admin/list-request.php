<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="list-group">
            <?php foreach ($models as $model): ?>
                <a href="<?= \yii\helpers\Url::to(['request-view', 'id' => $model->id]) ?>" class="list-group-item
                    <?= $model->status == 10 ? 'list-group-item-warning' : '' ?>
                    <?= $model->status == 40 ? 'list-group-item-success' : '' ?>
                    <?= $model->status == 50 ? 'list-group-item-danger' : '' ?>">
                    <div class="row text-center">
                        <div class="col-md-3 col-xs-1">#<?= $model->id ?></div>
                        <div class="col-md-3 col-xs-3"><?= $model->date ?></div>
                        <div class="col-md-3 col-xs-3"><?= $model->user['username'] ?></div>
                        <div class="col-md-3 col-xs-3"><?= $model->name ?></div>
                        <div class="col-md-3 col-xs-2">
                            <?php
                            switch ($model->status){
                                case 10:
                                    echo '<i class="glyphicon glyphicon-pencil"></i>';
                                    break;
                                case 20:
                                    echo '<i class="glyphicon glyphicon-cog"></i>';
                                    break;
                                case 30:
                                    echo '<i class="glyphicon glyphicon-flag"></i>';
                                    break;
                                case 40:
                                    echo '<i class="glyphicon glyphicon-check"></i>';
                                    break;
                                case 50:
                                    echo '<i class="glyphicon glyphicon-remove"></i>';
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                </a>
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

<!--
    const STATUS_SENDED = 10;
    const STATUS_ISJOB = 20;
    const STATUS_READY = 30;
    const STATUS_DONE = 40;
    const STATUS_CANCELED = 50;

    const TYPE_NONE = 0;
    const TYPE_CARD = 10;
    const TYPE_TRINKET_BLUE = 20;
    const TYPE_TRINKET_70 = 30;
    const TYPE_TRINKET_BLACK = 40;

    const BRACELET_NONE = 0;
    const BRACELET_YES = 10;

    const VIP_NONE = 0;
    const VIP_YES = 10;

    const ACCESS_MAX = 0;
    const ACCESS_MAX_WITHOUT_SHAB = 10;
    const ACCESS_MAX_WITHOUT_TRAKTOR = 20;
    const ACCESS_MAIN = 30;
    const ACCESS_MAIN_WITH_LOGI = 40;

    public function getUser()
    {
        switch (Yii::$app->user->getId()){
            case 100:
                return [
                    'id' => '100',
                    'username' => 'ucraft74',
                    'password' => 'Drakoola220289',
                    'authKey' => 'test100key',
                    'accessToken' => '100-token',
                ];
                break;
        }
    }
-->