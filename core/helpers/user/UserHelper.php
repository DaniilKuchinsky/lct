<?php

namespace core\helpers\user;

use core\rbac\rbac;
use Yii;
use yii\bootstrap4\Html;

class UserHelper
{
    const STATUS_DELETED = 100;

    const STATUS_ACTIVE = 10;


    const SEX_MALE  = 1;

    const SEX_WOMAN = 2;


    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE  => 'Активно',
            self::STATUS_DELETED => 'Неактивно',
        ];
    }


    /**
     * @param int $status
     *
     * @return string
     */
    public static function getStatusName(int $status): ?string
    {
        $types = self::getStatusList();
        if (array_key_exists($status, $types)) {
            return $types[ $status ];
        }

        return null;
    }


    /**
     * @param int $length
     *
     * @return string
     */
    public static function generateStr(int $length = 6): string
    {
        return Yii::$app->security->generateRandomString($length);
    }


    /**
     * @return array
     */
    public static function getSexList(): array
    {
        return [
            self::SEX_MALE  => 'Мужской',
            self::SEX_WOMAN => 'Женский',
        ];
    }


    /**
     * @param integer $value
     *
     * @return string
     */
    public static function getSexName(int $value): ?string
    {
        $types = self::getSexList();
        if (array_key_exists($value, $types)) {
            return $types[ $value ];
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return integer
     */
    public static function setSexName(string $name): int
    {
        if ($name == "муж")
        {
            return self::SEX_MALE;
        }

        return self::SEX_WOMAN;
    }


    /**
     *
     * @return boolean Администратор?
     */
    public static function isAdmin(): bool
    {
        if (Yii::$app->user->can(rbac::ROLE_ADMIN)) {
            return true;
        }

        return false;
    }


    /**
     * @param array  $roles
     * @param string $roleName
     *
     * @return bool
     */
    public static function isCheckRoleName(array $roles, string $roleName): bool
    {
        foreach ($roles as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }

        return false;
    }


}