<?php

use backend\forms\standard\StandardMoscowSearch;
use core\entities\standard\StandardMoscow;
use kartik\grid\BooleanColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;

/**
 * @var View                 $this
 * @var StandardMoscowSearch $searchModel
 * @var ActiveDataProvider   $dataProvider
 */

$this->title                 = 'Стандарт Москвы';
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
                                     'attribute' => 'categoryName',
                                     'label'     => 'Категория',
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'name',
                                     'label'     => 'Название нозологии',
                                 ],
                                 [
                                     'format'              => 'raw',
                                     'attribute'           => 'mkb10',
                                     'label'               => 'МКБ-10',
                                     'value'               => function (StandardMoscow $model) {
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
                                     'format'    => 'raw',
                                     'attribute' => 'type',
                                     'label'     => 'Тип назначений',
                                 ],
                                 [
                                     'format'              => 'raw',
                                     'attribute'           => 'destination',
                                     'label'               => 'Назначения',
                                     'value'               => function (StandardMoscow $model) {
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
                                     'value'     => function (StandardMoscow $model) {
                                         return $model->isImportant ? "Да" : "Нет";
                                     },
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'criterion',
                                     'label'     => 'Критерии исследований/консультаций',
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