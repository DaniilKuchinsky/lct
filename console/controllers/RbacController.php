<?php

namespace console\controllers;

use yii\console\Controller;
use Yii;
use core\rbac\rbac;

class RbacController extends Controller
{
    public function actionAdmin()
    {
        $auth = Yii::$app->getAuthManager();

        $admin              = $auth->createRole(rbac::ROLE_ADMIN);
        $admin->description = 'Администратор сайта';
        $auth->add($admin);

        $this->stdout('Роль администратора создана!' . PHP_EOL);
    }
}