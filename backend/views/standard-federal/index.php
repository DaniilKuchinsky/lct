<?php

use backend\forms\standard\StandardFederalSearch;
use core\entities\standard\StandardFederal;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;

/**
 * @var View                  $this
 * @var StandardFederalSearch $searchModel
 * @var ActiveDataProvider    $dataProvider
 */

$this->title                 = 'Стандарт Федеральный';
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
                                     'attribute' => 'code',
                                     'label'     => 'Код медицинской услуги',
                                 ],
                                 [
                                     'format'              => 'raw',
                                     'attribute'           => 'mkb10',
                                     'label'               => 'МКБ-10',
                                     'value'               => function (StandardFederal $model) {
                                         return $model->mkb10->name;
                                     },
                                     'filter'              => $searchModel->mkb10List(),
                                     'filterType'          => GridView::FILTER_SELECT2,
                                     'filterWidgetOptions' => [
                                         'language'      => 'ru',
                                         'options'       => ['prompt' => 'укажите МКБ-10'],
                                         'pluginOptions' => [
                                             'allowClear' => true,
                                         ],
                                     ],
                                 ],
                                 [
                                     'format'              => 'raw',
                                     'attribute'           => 'destination',
                                     'label'               => 'Назначения',
                                     'value'               => function (StandardFederal $model) {
                                         return $model->destination->name;
                                     },
                                     'filter'              => $searchModel->destinationList(),
                                     'filterType'          => GridView::FILTER_SELECT2,
                                     'filterWidgetOptions' => [
                                         'language'      => 'ru',
                                         'options'       => ['prompt' => 'укажите назначения'],
                                         'pluginOptions' => [
                                             'allowClear' => true,
                                         ],
                                     ],
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'isImportant',
                                     'label'     => 'Обязательность',
                                     'filter'    => $searchModel->importantList(),
                                     'value'     => function (StandardFederal $model) {
                                         return $model->isImportant ? "Да" : "Нет";
                                     },
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'value',
                                     'label'     => 'Усредненный показатель кратности применения',
                                 ],
                             ],
                             'toolbar'            => [
                                 [
                                     'content' =>
                                         Html::a('загрузить данные', ['load-data'], [
                                             'class'          => 'btn btn-success',
                                             'title'          => 'Загрузить новый файл',
                                             'data-pjax'      => 0,
                                             'data-placement' => 'top',
                                             'data-toggle'    => 'tooltip',
                                         ]) . ' ' .
                                         Html::a('<i class="fas fa-redo"></i>', ['reset'], [
                                             'class'          => 'btn btn-outline-secondary',
                                             'title'          => 'Сбросить фильтры',
                                             'data-pjax'      => 0,
                                             'data-placement' => 'top',
                                             'data-toggle'    => 'tooltip',
                                         ]),
                                     'options' => ['class' => 'btn-group mr-2 me-2'],
                                 ],
                                 '{export}',
                                 '{toggleData}',
                             ],
                         ]); ?>


</div>