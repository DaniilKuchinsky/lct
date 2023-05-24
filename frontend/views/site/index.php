<?php

use core\forms\consultation\ConsultationForm;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\View;

/**
 * @var View             $this
 * @var ConsultationForm $model
 */

$this->title = 'Анализ консультаций';
?>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title"><?= $this->title ?></h3>
    </div>

    <div class="card-body">


        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'fileName')->widget(FileInput::classname(), [
            'language'      => 'ru',
            'options'       => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel', 'multiple' => false],
            'pluginOptions' => [
                'showUpload'  => false,
                'maxFileSize' => 10000,
            ],
        ]) ?>

        <div class="text-right">
            <?= Html::submitButton('<i class="fa fa-hiking"></i> Перейти к анализу данных', ['class' => 'btn btn-success']) ?>

        </div>
        <br/>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Требования к структуре excel файла</h4>
            <p>Максимальный размер загружаемого файла - 10 Мб. Файл должен содержать только одну страницу с данными. Должны быть следующие столбцы:</p>
            <ul>
                <li>Пол пациента</li>
                <li>Дата рождения пациента</li>
                <li>ID пациента</li>
                <li>Код МКБ-10</li>
                <li>Диагноз</li>
                <li>Дата оказания услуги</li>
                <li>Должность</li>
                <li>Назначения</li>
            </ul>
        </div>




        <?php ActiveForm::end(); ?>

    </div>

</div>
