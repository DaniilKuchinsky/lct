<?php

namespace backend\forms\user;

use core\entities\user\User;
use core\helpers\user\UserHelper;
use core\rbac\rbac;
use Yii;
use yii\base\Model;

class UserEditForm extends Model
{
    public string  $email;

    public int     $status;

    public string  $role;

    protected User $_user;


    public function __construct(User $user, $config = [])
    {
        $this->email              = $user->email;
        $this->status                = $user->status;

        $roles = Yii::$app->authManager->getRolesByUser($user->id);
        foreach ($roles as $role) {
            $this->role = $role->name;
        }

        $this->_user = $user;
        parent::__construct($config);
    }

    public function attributeLabels(): array
    {
        return [
            'email'    => 'Email',
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
                'filter'      => ['<>', 'id', $this->_user->id],
            ],

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