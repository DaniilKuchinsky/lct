<?php

namespace common\auth;

use core\entities\user\User;
use core\repositories\user\UserRepository;
use core\repositories\user\UserTokenRepository;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface
{
    private User $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public static function findIdentity($id): ?Identity
    {
        $user = self::getRepository()->findById($id);

        return $user ? new self($user) : null;
    }


    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return self::getUserTokenRepository()->findIdentityByToken($token);
    }


    public function getId(): int
    {
        return $this->user->id;
    }


    public function getUser(): User
    {
        return $this->user;
    }


    public function getAuthKey(): string
    {
        return $this->user->authKey;
    }


    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }


    private static function getRepository()
    {
        return \Yii::$container->get(UserRepository::class);
    }

    private static function getUserTokenRepository()
    {
        return \Yii::$container->get(UserTokenRepository::class);
    }
}