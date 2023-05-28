<?php

namespace console\controllers;

use core\helpers\user\UserHelper;
use moonland\phpexcel\Excel;
use yii\console\Controller;
use Yii;
use core\rbac\rbac;
use core\entities\user\User;

//yii migrate --migrationPath=@yii/rbac/migrations/
class AdminController extends Controller
{

    public function actionCreate()
    {
        $email    = $this->prompt('Email:', ['required' => true]);
        $password = $this->prompt('Password:', ['required' => true]);

        $user = User::create($email, $password, UserHelper::STATUS_ACTIVE);
        if (!$user->save()) {
            $this->stderr('Администратор не был создан' . PHP_EOL);

            return;
        } else {
            $this->stdout('Администратор создан' . PHP_EOL);
        }

        $authManager = Yii::$app->getAuthManager();
        $role        = $authManager->getRole(rbac::ROLE_ADMIN);
        $authManager->assign($role, $user->id);

        $this->stdout('Роль добавлена администратору' . PHP_EOL);
    }


    public function actionExcel()
    {
        $fileName = \Yii::$app->getBasePath() . '/fed.xlsx';

        $data = Excel::widget([
                                  'mode'     => 'import',
                                  'fileName' => $fileName,
                                  'getOnlySheet' => 'Федеральный стандарт'
                              ]);

        $indx = 1;
        foreach ($data as $item) {
            if ($indx > 1) {
                continue;
            }
            var_dump($item);
            $indx++;


        }
        //var_dump($data);
    }
}

