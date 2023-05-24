<?php

namespace backend\forms\user;

use core\entities\user\User;
use core\helpers\user\UserHelper;
use core\rbac\rbac;
use yii\base\Model;

class UserCreateForm extends Model
{
    public ?string  $email    = null;

    public ?string  $password = null;

    public ?int     $status   = null;

    public ?string  $role     = null;




    public function attributeLabels(): array
    {
        return [
            'email'    => 'Email',
            'password' => 'Пароль',
            'status'   => 'Статус',
            'role'     => 'Роль',
        ];
    }


    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => "Пожалуйста, укажите email"],
            ['email', 'email'],
            ['email', 'string', 'min' => 2, 'max' => 250],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'message'     => 'Данный email уже занят',
            ],

            ['password', 'trim'],
            ['password', 'required', 'message' => "Пожалуйста, придумайте пароль"],
            ['password', 'string', 'min' => 2, 'max' => 10],

            ['status', 'integer'],
            ['status', 'required', 'message' => "Пожалуйста, укажите статус"],

            ['role', 'safe'],
            ['role', 'required', 'message' => "Пожалуйста, укажите роль"],
        ];
    }


    public function roleList(): array
    {
        return rbac::getRoleNames();
    }

    public function statusList(): array
    {
        return UserHelper::getStatusList();
    }

}