<?php

namespace core\rbac;

class rbac
{
    const ROLE_ADMIN = 'admin';


    public static function getRoleNames(): array
    {
        return [
            self::ROLE_ADMIN => 'Администратор',
        ];
    }


}