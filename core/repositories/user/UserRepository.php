<?php

namespace core\repositories\user;

use core\entities\user\User;
use core\helpers\user\UserHelper;

class UserRepository
{

    /**
     * @param int $id
     *
     * @return User
     */
    public function get(int $id): User
    {
        if (!$user = User::findOne($id)) {
            throw new \DomainException('Пользователь не найден');
        }

        return $user;
    }


    public function save(User $user)
    {
        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }


    /**
     * @param string  $email
     * @param integer $status
     *
     * @return User | null
     */
    public function findByEmail(string $email, int $status = UserHelper::STATUS_ACTIVE): ?User
    {
        return
            User::findOne(['email' => $email, 'status' => $status]);
    }


    /**
     * @param integer $id
     * @param integer $status
     *
     * @return User | null
     */
    public function findById(int $id, int $status = UserHelper::STATUS_ACTIVE)
    {
        return User::findOne(['id' => $id, 'status' => $status]);
    }

}