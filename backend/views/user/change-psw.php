<?php

use core\entities\user\User;
use core\forms\user\ChangePasswordForm;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\View;

/**
 * @var View               $this
 * @var ChangePasswordForm $model
 * @var User               $user
 */

$this->title                   = 'Смена пароля: ' . $user->email;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Сменить пароль';
?>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title"><?= $this->title ?></h3>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">
        <?= $form->field($model, 'password')->passwordInput([
                                                                'maxlength'    => true,
                                                                'autocomplete' => 'off',
                                                                'autofocus'    => 'autofocus',
                                                            ]) ?>
        <?= $form->field($model, 'passwordRepeat')->passwordInput([
                                                                      'maxlength'    => true,
                                                                      'autocomplete' => 'off',
                                                                  ]) ?>
        <div class="text-right">
            <?= Html::submitButton('Изменить пароль', ['class' => 'btn btn-success']) ?>

            <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

