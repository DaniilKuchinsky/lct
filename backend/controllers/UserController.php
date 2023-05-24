<?php

namespace backend\controllers;

use backend\forms\user\UserCreateForm;
use backend\forms\user\UserEditForm;
use backend\forms\user\UserSearch;
use core\forms\user\ChangePasswordForm;
use core\services\user\UserService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class UserController extends Controller
{
    private UserService $service;


    public function __construct($id, $module, UserService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete'      => ['POST'],
                    'restore'     => ['POST'],
                    'permanently' => ['POST'],
                ],
            ],
        ]);
    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return mixed
     */
    public function actionReset()
    {
        $searchModel = new UserSearch();
        $searchModel->resetCookieFilter();

        return $this->redirect(['index']);
    }


    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new UserCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);

                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', [
                    'title' => "Ошибка",
                    'msg'   => $e->getMessage(),
                ]);
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }


    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionEdit(int $id)
    {
        $user = $this->service->get($id);

        $form = new UserEditForm($user);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($user->id, $form);

                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', [
                    'title' => "Ошибка",
                    'msg'   => $e->getMessage(),
                ]);
            }
        }

        return $this->render('edit', [
            'model' => $form,
            'user'  => $user,
        ]);
    }


    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionChangePsw(int $id)
    {
        $user = $this->service->get($id);

        $form = new ChangePasswordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changePsw($user->id, $form);

                Yii::$app->session->setFlash(
                    'success',
                    [
                        'msg'   => 'Пароль успешно обновлен у пользователя',
                        'title' => 'Информация',
                    ]
                );

                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', ['msg' => $e->getMessage(), 'title' => 'Ошибка']);
            }
        }

        return $this->render('change-psw', [
            'model' => $form,
            'user'  => $user,
        ]);
    }


    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        try {
            $this->service->deleteUser($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', ['msg' => $e->getMessage(), 'title' => 'Ошибка']);
        }

        return $this->redirect(['index']);
    }


    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionRestore(int $id)
    {
        try {
            $this->service->restoreUser($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', ['msg' => $e->getMessage(), 'title' => 'Ошибка']);
        }

        return $this->redirect(['index']);
    }


    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionPermanently(int $id)
    {
        try {
            $this->service->deletePermanently($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', [
                'title' => 'Ошибка',
                'msg'   => $e->getMessage(),
            ]);
        }

        return $this->redirect(['index']);
    }
}