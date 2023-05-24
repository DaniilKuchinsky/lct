<?php

use backend\forms\user\UserSearch;
use core\widgets\grid\TimeColumn;
use core\widgets\grid\user\StatusColumn;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;
use core\widgets\grid\user\RoleColumn;
use core\helpers\user\UserHelper;

/**
 * @var View               $this
 * @var UserSearch         $searchModel
 * @var ActiveDataProvider $dataProvider
 */

$this->title                 = 'Пользователи';
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
                                 'type'    => GridView::TYPE_SECONDARY,
                                 'heading' => '<i class="flaticon-list-1"></i> ' . $this->title,
                             ],
                             'responsive'         => false,
                             'columns'            => [
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'id',
                                     'label'     => 'ID',
                                 ],
                                 [
                                     'format'    => 'raw',
                                     'attribute' => 'email',
                                     'label'     => 'Email',
                                 ],
                                 [
                                     'attribute' => 'role',
                                     'label'     => 'Роль',
                                     'class'     => RoleColumn::class,
                                     'filter'    => $searchModel->rolesList(),

                                 ],
                                 [
                                     'attribute'      => 'status',
                                     'label'          => 'Статус',
                                     'class'          => StatusColumn::class,
                                     'filter'         => UserHelper::getStatusList(),
                                     'format'         => 'raw',
                                     'headerOptions'  => ['style' => 'text-align:center;'],
                                     'contentOptions' => ['style' => 'text-align:center;'],
                                 ],
                                 [
                                     'attribute'      => '',
                                     'label'          => 'Инфо',
                                     'class'          => TimeColumn::class,
                                     'format'         => 'raw',
                                     'headerOptions'  => ['style' => 'text-align:center;'],
                                     'contentOptions' => ['style' => 'text-align:left;'],
                                 ],
                                 [
                                     'class'          => 'yii\grid\ActionColumn',
                                     'template'       => '{edit} {change-psw} {delete} {restore} {permanently}',
                                     'header'         => 'Действия',
                                     'headerOptions'  => ['class' => 'text-center'],
                                     'contentOptions' => ['class' => 'text-center btn-table-action'],
                                     'buttons'        => [
                                         'edit'        => function ($url, $model) {
                                             return Html::a(
                                                 '<i class="fas fa-pencil-alt"></i>',
                                                 $url,
                                                 [
                                                     'class'          => 'btn',
                                                     'title'          => 'Изменить данные',
                                                     'data-placement' => 'top',
                                                     'data-toggle'    => 'tooltip',
                                                 ]
                                             );
                                         },
                                         'change-psw'  => function ($url, $model) {
                                             return Html::a(
                                                 '<i class="fas fa-key"></i>',
                                                 $url,
                                                 [
                                                     'class'          => 'btn',
                                                     'title'          => 'Сбросить пароль',
                                                     'data-placement' => 'top',
                                                     'data-toggle'    => 'tooltip',
                                                 ]
                                             );
                                         },
                                         'delete'      => function ($url, $model, $key) {
                                             return !$model->isActive() ? "" : Html::a(
                                                 '<i class="far fa-trash-alt"></i>',
                                                 $url,
                                                 [
                                                     'class'          => 'btn',
                                                     'title'          => 'Удалить учетную запись',
                                                     'data-placement' => 'top',
                                                     'data-toggle'    => 'tooltip',
                                                     'data'           => [
                                                         'confirm' => 'Вы уверены?',
                                                         'method'  => 'post',
                                                     ],
                                                 ]
                                             );
                                         },
                                         'restore'     => function ($url, $model, $key) {
                                             return $model->isActive() ? "" : Html::a(
                                                 '<i class="fa fa-user-plus"></i>',
                                                 $url,
                                                 [
                                                     'class'          => 'btn',
                                                     'title'          => 'Восстановить учетную запись',
                                                     'data-placement' => 'top',
                                                     'data-toggle'    => 'tooltip',
                                                     'data'           => [
                                                         'confirm' => 'Вы уверены?',
                                                         'method'  => 'post',
                                                     ],
                                                 ]
                                             );
                                         },
                                         'permanently' => function ($url, $model, $key) {
                                             return Html::a(
                                                 '<i class="fas fa-ban"></i>',
                                                 $url,
                                                 [
                                                     'class'          => 'btn',
                                                     'title'          => 'Удалить навсегда учетную запись',
                                                     'data-placement' => 'top',
                                                     'data-toggle'    => 'tooltip',
                                                     'data'           => [
                                                         'confirm' => 'Запись будет удалена навсегда. Вы уверены?',
                                                         'method'  => 'post',
                                                     ],
                                                 ]
                                             );
                                         },
                                     ],
                                 ],
                             ],
                             'toolbar'            => [
                                 [
                                     'content' =>
                                         Html::a(
                                             '<i class="fas fa-plus"></i> пользователя',
                                             ['create'],
                                             [
                                                 'class'     => 'btn btn-success',
                                                 'title'     => 'Добавить пользователя',
                                                 'data-pjax' => 0,
                                                 'data-placement' => 'top',
                                                 'data-toggle'    => 'tooltip',
                                             ]
                                         )
                                         . ' ' .
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
