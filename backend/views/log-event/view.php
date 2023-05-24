<?php

use core\entities\log\LogEvent;
use core\helpers\log\LogEventHelper;
use yii\web\View;

/**
 * @var View     $this
 * @var LogEvent $model
 */


$this->title                   = 'Информация по событию ';
$this->params['breadcrumbs'][] = ['label' => 'Журнал событий', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Просмотр';
?>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">ID = <?= $model->id ?></h3>
    </div>
    <div class="card-body">
        <p><b>Статус:</b> <?= LogEventHelper::getStatusName($model->status) ?></p>
        <p><b>Дата:</b> <?= $model->dateStartStr ?> - <?= $model->dateFinishStr ?>, <?= $model->getExecutionTime() ?>
        </p>
        <p><b>Данные запроса:</b> <?= $model->requestInfo ?></p>
        <p><b>Результат:</b> <?= $model->resultInfo ?></p>
    </div>

</div>