<?php

use core\entities\consultation\Consultation;
use core\entities\consultation\ConsultationDiagnosis;
use core\helpers\user\UserHelper;
use frontend\forms\ConsultationFinishSearch;
use kartik\daterange\DateRangePicker;
use sjaakp\gcharts\PieChart;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;

/**
 * @var View              $this
 * @var ArrayDataProvider $dataProvider
 */

$this->title                 = 'Результаты анализа';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<div class="kt-portlet kt-portlet--mobile">

    <?= PieChart::widget([
                             'height'       => '600px',
                             'dataProvider' => $dataProvider,
                             'columns'      => [
                                 'name:string',
                                 'population',
                             ],
                             'options'      => [
                                 'sliceVisibilityThreshold' => 0,
                             ],
                         ]) ?>


    <?= GridView::widget([
                             'dataProvider'       => $dataProvider,
                             'floatHeader'        => true,
                             'floatHeaderOptions' => ['top' => '50', 'floatContainerClass' => 'gridview-header'],
                             'panel'              => [
                                 'type'    => GridView::TYPE_SECONDARY,
                                 'heading' => '<i class="flaticon-list-1"></i> ' . $this->title,
                             ],
                             'responsive'         => false,
                             'columns'            => [
                                 [
                                     'format'         => 'raw',
                                     'label'          => 'Статус',
                                     'attribute'      => 'name',
                                     'headerOptions'  => ['style' => 'text-align:left; '],
                                     'contentOptions' => ['style' => 'text-align:left;'],
                                     'value'          => function ($model) {

                                         return Html::a(
                                             $model['name'],
                                             [
                                                 'result-info',
                                                 'id'             => $model['consultationId'],
                                                 'statusStandard' => $model['statusId'],
                                             ],
                                             [
                                                 'class'          => 'btn btn-link',
                                                 'title'          => 'Подробнее',
                                                 'data-pjax'      => 0,
                                                 'data-placement' => 'top',
                                                 'data-toggle'    => 'tooltip',
                                             ]
                                         );
                                     },
                                 ],
                                 [
                                     'format'         => 'raw',
                                     'label'          => 'Количество совпадений',
                                     'attribute'      => 'population',
                                     'headerOptions'  => ['style' => 'text-align:center;'],
                                     'contentOptions' => ['style' => 'text-align:center;'],
                                 ],
                             ],
                         ]); ?>


</div>
