<?php

namespace core\services\auth;

use core\entities\user\User;
use core\forms\auth\EmailForm;
use core\repositories\user\UserRepository;
use core\services\TransactionManager;
use Yii;

class AuthService
{
    private UserRepository $repUser;


    public function __construct(
        UserRepository $userRepository
    ) {
        $this->repUser = $userRepository;
    }


    public function authUserWithEmail(EmailForm $form): User
    {
        $user = $this->repUser->findByEmail($form->email);
        if (!$user || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неправильный логин или пароль');
        }

        return $user;
    }

}