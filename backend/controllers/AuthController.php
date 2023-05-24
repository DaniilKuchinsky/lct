<?php

namespace backend\controllers;

use common\auth\Identity;
use core\forms\auth\EmailForm;
use core\services\auth\AuthService;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public $layout = 'login';

    private $service;

    public function __construct($id, $module, AuthService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new EmailForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->authUserWithEmail($form);
                Yii::$app->user->login(new Identity($user), $form->rememberMe ? Yii::$app->params['user.rememberMeDuration'] : 0);
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', ['msg' => $e->getMessage(), 'title' => 'Ошибка']);
            }
        }

        return $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}