<?php

namespace backend\controllers;

use backend\components\BaseController;
use backend\forms\consultation\ConsultationSearch;
use core\helpers\consultation\ConsultationHelper;
use core\services\consultation\ConsultationService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class ConsultationController extends BaseController
{

    private ConsultationService $service;


    public function __construct($id, $module, ConsultationService $service, $config = [])
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
                    'set-status' => ['POST'],
                ],
            ],
        ]);
    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ConsultationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function actionSetStatus(int $id)
    {
        try {
            $this->service->setStatusConsultation($id, ConsultationHelper::STATUS_NEW);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('danger', ['msg' => $e->getMessage(), 'title' => 'Ошибка']);
        }

        return $this->redirect(['index']);
    }
}