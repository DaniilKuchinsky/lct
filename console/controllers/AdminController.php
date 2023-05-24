<?php

namespace console\controllers;

use core\entities\consultation\ConsultationDiagnosis;
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
        $fileName  = \Yii::$app->getBasePath() . '/Dataset.xlsx';

        $data = Excel::widget([
                                                     'mode' => 'import',
                                                     'fileName' => $fileName,
                                                     //'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
                                                     //'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
                                                     //'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
                                                 ]);

        $indx = 1;
        foreach ($data as $item)
        {

            if (is_null($item['Пол пациента']))
            {
                continue;
            }

            $str = $item['Назначения'];

            $arrPurpose = [];
            $arrTemp = explode(PHP_EOL, $str);
            foreach ($arrTemp as $arr)
            {
                if (strlen($arr) == 0)
                {
                    continue;
                }

                $arrTemp2 = explode(';', $arr);
                foreach ($arrTemp2 as $arr2)
                {
                    $arrPurpose[] = mb_strtolower(trim($arr2));
                }

            }
            var_dump($arrPurpose);

            $indx++;

            if ($indx > 12)
            {
                return;
            }
        }
        //var_dump($data);
    }
}

