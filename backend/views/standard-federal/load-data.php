<?php

use backend\forms\standard\StandardFileForm;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\View;

/**
 * @var View             $this
 * @var StandardFileForm $model
 */

$this->title                   = 'Загрузка файла';
$this->params['breadcrumbs'][] = ['label' => 'Стандарт Федеральный', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Загрузка файла';
?>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title"><?= $this->title ?></h3>
    </div>

    <div class="card-body">


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'fileName')->widget(FileInput::classname(), [
            'language'      => 'ru',
            'options'       => [
                'accept'   => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'showUpload'  => false,
                'maxFileSize' => 10000,
            ],
        ]) ?>

        <div class="text-right">
            <?= Html::submitButton('<i class="fa fa-hiking"></i> Загрузить данные', ['class' => 'btn btn-success']) ?>

        </div>


        <?php ActiveForm::end(); ?>

    </div>

</div>
