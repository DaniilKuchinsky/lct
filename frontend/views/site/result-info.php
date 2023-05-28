<?php

use core\entities\consultation\Consultation;
use core\entities\consultation\ConsultationDiagnosis;
use core\entities\consultation\ConsultationDiagnosisDestination;
use core\helpers\user\UserHelper;
use frontend\forms\ConsultationFinishSearch;
use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;

/**
 * @var View                     $this
 * @var ConsultationFinishSearch $searchModel
 * @var ActiveDataProvider       $dataProvider
 * @var Consultation             $consultation
 * @var string                   $statusStandardName
 */

$this->title                   = 'Подробные данные';
$this->params['breadcrumbs'][] =
    ['label' => 'Результаты анализа', 'url' => ['finish', 'id' => $consultation->uniqueId]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="kt-portlet kt-portlet--mobile">

    <?= GridView::widget([
                             'dataProvider'       => $dataProvider,
                             'filterModel'        => $searchModel,
                             'floatHeader'        => true,
                             'floatHeaderOptions' => ['top' => '50', 'floatContainerClass' => 'gridview-header'],
                             'showPageSummary'    => false,
                             'panel'              => [
                                 'type'    => GridView::TYPE_SECONDARY,
                                 'heading' => '<i class="flaticon-list-1"></i> ' .
                                              $statusStandardName,
                             ],
                             'responsive'         => false,
                             'columns'            => [
                                 [
                                     'format'         => 'raw',
                                     'attribute'      => 'sex',
                                     'label'          => 'Пол<br/>пациента',
                                     'encodeLabel'    => false,
                                     'headerOptions'  => ['style' => 'text-align:center;'],
                                     'contentOptions' => ['style' => 'text-align:center;'],
                                     'value'          => function (ConsultationDiagnosisDestination $model) {
                                         return UserHelper::getSexName($model->consultationDiagnosis->sex);
                                     },
                                     'filter'         => $searchModel->sexList(),
                                 ],
                                 [
                                     'format'         => 'raw',
                                     'attribute'      => 'dateBirth',
                                     'label'          => 'Дата<br/>рождения<br/>пациента',
                                     'encodeLabel'    => false,
                                     'value'          => function (ConsultationDiagnosisDestination $model) {
                                         return $model->consultationDiagnosis->dateOfBirthStr;
                                     },
                                     'headerOptions'  => ['style' => 'text-align:center;'],
                                     'contentOptions' => ['style' => 'text-align:center;'],
                                     'filter'         => DateRangePicker::widget(
                                         [
                                             'model'         => $searchModel,
                                             'language'      => 'ru-Ru',
                                             'attribute'     => 'dateBirth',
                                             'convertFormat' => true,
                                             'pluginOptions' => [
                                                 'locale' => [
                                                     'format' => 'd.m.Y',
                                                 ],
                                             ],
                                             'pluginEvents'  => [
                                                 "cancel.daterangepicker" => "function() { $('#consultationfinishsearch-datebirth').val(''); }",
                                             ],
                                         ]
                                     ),
                                 ],
                                 [
                                     'format'         => 'raw',
                                     'attribute'      => 'patientId',
                                     'label'          => 'ID<br/>пациента',
                                     'encodeLabel'    => false,
                                     'headerOptions'  => ['style' => 'text-align:center;'],
                                     'contentOptions' => ['style' => 'text-align:center;'],
                                     'value'          => function (ConsultationDiagnosisDestination $model) {
                                         return $model->consultationDiagnosis->patientId;
                                     },
                                 ],
                                 [
                                     'format'         => 'raw',
                                     'attribute'      => 'codeMkb',
                                     'label'          => 'Код<br/>МКБ-10',
                                     'encodeLabel'    => false,
                                     'headerOptions'  => ['style' => 'text-align:center;'],
                                     'contentOptions' => ['style' => 'text-align:center;'],
                                     'value'          => function (ConsultationDiagnosisDestination $model) {
                                         return $model->consultationDiagnosis->codeMkb;
                                     },
                                 ],
                                 [
                                     'format'        => 'raw',
                                     'attribute'     => 'diagnosis',
                                     'label'         => 'Диагноз',
                                     'headerOptions' => ['style' => 'text-align:center;'],
                                     'value'         => function (ConsultationDiagnosisDestination $model) {
                                         return $model->consultationDiagnosis->diagnosis;
                                     },
                                 ],
                                 [
                                     'format'         => 'raw',
                                     'attribute'      => 'dateService',
                                     'label'          => 'Дата<br/>оказания<br/>услуг',
                                     'encodeLabel'    => false,
                                     'headerOptions'  => ['style' => 'text-align:center;'],
                                     'contentOptions' => ['style' => 'text-align:center;'],
                                     'value'          => function (ConsultationDiagnosisDestination $model) {
                                         return $model->consultationDiagnosis->dateServiceStr;
                                     },
                                     'filter'         => DateRangePicker::widget(
                                         [
                                             'model'         => $searchModel,
                                             'language'      => 'ru-Ru',
                                             'attribute'     => 'dateService',
                                             'convertFormat' => true,
                                             'pluginOptions' => [
                                                 'locale' => [
                                                     'format' => 'd.m.Y',
                                                 ],
                                             ],
                                             'pluginEvents'  => [
                                                 "cancel.daterangepicker" => "function() { $('#consultationfinishsearch-dateservice').val(''); }",
                                             ],
                                         ]
                                     ),
                                 ],
                                 [
                                     'format'        => 'raw',
                                     'attribute'     => 'jobName',
                                     'label'         => 'Должность',
                                     'headerOptions' => ['style' => 'text-align:center;'],
                                     'value'         => function (ConsultationDiagnosisDestination $model) {
                                         return $model->consultationDiagnosis->jobName;
                                     },
                                 ],
                                 [
                                     'format'        => 'raw',
                                     'attribute'     => 'destination',
                                     'headerOptions' => ['style' => 'text-align:center;'],
                                     'label'         => 'Назначения',
                                     'value'         => function (ConsultationDiagnosisDestination $model) {
                                         return $model->name;
                                     },
                                 ],

                             ],
                             'toolbar'            => [
                                 [
                                     'content' =>
                                         Html::a(
                                             'Сбросить фильтр',
                                             ['reset', 'id' => $consultation->uniqueId],
                                             [
                                                 'class'          => 'btn btn-outline-secondary',
                                                 'title'          => 'Сбросить фильтры',
                                                 'data-pjax'      => 0,
                                                 'data-placement' => 'top',
                                                 'data-toggle'    => 'tooltip',
                                             ]
                                         ),
                                     'options' => ['class' => 'btn-group mr-2 me-2'],
                                 ],
                                 '{export}',
                                 '{toggleData}',
                             ],
                         ]); ?>


</div>
