<?php

use core\entities\log\LogEvent;
use backend\forms\logEvent\LogEventSearch;
use core\widgets\grid\log\StatusColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;

/**
 * @var View               $this
 * @var LogEventSearch     $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title                 = 'Журнал событий';
$this->params['breadcrumbs'] = [['label' => $this->title]];

?>

<div class="kt-portlet kt-portlet--mobile">

    <?= GridView::widget([
                             'dataProvider'       => $dataProvider,
                             'filterModel'        => $searchModel,
                             'floatHeader'        => true,
                             'floatHeaderOptions' => ['top' => '50', 'floatContainerClass' => 'gridview-header'],
                             'showPageSummary'    => false,
                             'panel'              => [
                                 'type'    => GridView::TYPE_PRIMARY,
                                 'heading' => '<i class="flaticon-list-1"></i> ' . $this->title,
                             ],
                             'responsive'         => false,
                             'columns'            => [
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'id',
                                     'label'     => 'ID',
                                     'value'     => function (LogEvent $model) {
                                         $str = $model->id . '<br/>';

                                         $str .=  Html::a(
                                             'подробнее',
                                             ['view', 'id' => $model->id],
                                             [
                                                 'class' => 'btn btn-default btn-sm',
                                             ]
                                         );

                                         return $str;
                                     },
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'status',
                                     'label'     => 'Статус',
                                     'class'     => StatusColumn::class,
                                     'filter'    => $searchModel->getStatusList(),
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'requestInfo',
                                     'label'     => 'Данные запроса',
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'dateStart',
                                     'label'     => 'Дата начала',
                                     'value'     => function (LogEvent $model) {
                                         return $model->dateStartStr;
                                     },
                                 ],

                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'dateFinish',
                                     'label'     => 'Дата окончания',
                                     'value'     => function (LogEvent $model) {
                                         return $model->dateFinishStr;
                                     },
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => '',
                                     'label'     => 'Время выполнения',
                                     'value'     => function (LogEvent $model) {
                                         return $model->getExecutionTime();
                                     },
                                 ],
                             ],
                             'toolbar'            => [
                                 [
                                     'content' =>
                                         Html::a('<i class="fas fa-redo"></i>', ['index'], [
                                             'class'     => 'btn btn-outline-secondary',
                                             'title'     => 'Сбросить фильтры',
                                             'data-pjax' => 0,
                                         ]),
                                     'options' => ['class' => 'btn-group mr-2 me-2'],
                                 ],
                                 '{export}',
                                 '{toggleData}',
                             ],
                         ]); ?>


</div>