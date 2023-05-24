<?php

namespace core\forms\user;

use yii\base\Model;

class ChangePasswordForm extends Model
{
    public ?string $password = null;

    public ?string $passwordRepeat = null;


    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'password'       => 'Новый пароль',
            'passwordRepeat' => 'Пароль еще раз',
        ];
    }


    public function rules():array
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['passwordRepeat', 'required'],
            ['passwordRepeat', 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают" ],
        ];
    }
}