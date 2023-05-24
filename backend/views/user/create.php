<?php

use backend\forms\user\UserCreateForm;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\View;

/**
 * @var View           $this
 * @var UserCreateForm $model
 */

$this->title                   = 'Добавление пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title"><?= $this->title ?></h3>
    </div>


    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'email')->textInput([
                                                         'maxlength'    => true,
                                                         'autocomplete' => 'off',
                                                     ]) ?>

        <?= $form->field($model, 'password')->textInput([
                                                         'maxlength'    => true,
                                                         'autocomplete' => 'off',
                                                     ]) ?>


        <?= $form->field($model, 'status')->dropdownList($model->statusList()) ?>

        <?= $form->field($model, 'role')->dropdownList($model->roleList(), ['id' => 'select-role']) ?>

        <div class="text-right">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

            <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>