<?php

namespace core\services\user;

use yii\rbac\ManagerInterface;

class RoleManager
{
    private $manager;


    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    public function assign($userId, $names)
    {
        $this->manager->revokeAll($userId);

        foreach ($names as $name) {
            if (!$role = $this->manager->getRole($name)) {
                throw new \DomainException('Роль "' . $name . '" не найдена.');
            }
            $this->manager->assign($role, $userId);
        }
    }


    public function assignPermission($userId, $names)
    {
        //$this->manager->revokeAll($userId);

        foreach ($names as $name) {
            if (!$permission = $this->manager->getPermission($name)) {
                throw new \DomainException('Разрешение "' . $name . '" не найдено.');
            }
            $this->manager->assign($permission, $userId);
        }
    }
}