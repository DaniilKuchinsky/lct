<?php

use backend\forms\consultation\ConsultationSearch;
use core\entities\consultation\Consultation;
use core\helpers\SiteHelper;
use core\widgets\grid\consultation\StatusColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;

/**
 * @var View               $this
 * @var ConsultationSearch $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title                 = 'Журнал консультаций';
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
                                     'value'     => function (Consultation $model) {
                                         return Html::a(
                                             $model->id,
                                             SiteHelper::getUrlSite() . '/site/finish?id=' . $model->uniqueId,
                                             [
                                                 'class'  => 'btn btn-link',
                                                 'target' => '_blank',
                                             ]
                                         ) . ' ' .
                                                Html::a(
                                                    'Еще раз обработать',
                                                    ['set-status', 'id' => $model->id],
                                                    [
                                                        'class'  => 'btn btn-default btn-xs',
                                                        'target' => '_blank',
                                                        'data'           => [
                                                            'confirm' => 'Вы уверены?',
                                                            'method'  => 'post',
                                                        ],
                                                    ]
                                                );
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
                                     'attribute' => 'uniqueId',
                                     'label'     => 'Уникальный код',
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'fileName',
                                     'label'     => 'Файл',
                                     'value'     => function (Consultation $model) {
                                         return Html::a(
                                             'скачать',
                                             SiteHelper::getUrlSite() . $model->fileName,
                                             [
                                                 'class'  => 'btn btn-link',
                                                 'target' => '_blank',
                                             ]
                                         );
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