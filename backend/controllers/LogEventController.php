<?php

namespace backend\controllers;

use backend\components\BaseController;
use backend\forms\logEvent\LogEventSearch;
use core\services\log\LogEventService;
use Yii;

class LogEventController extends BaseController
{

    private LogEventService $service;


    public function __construct($id, $module, LogEventService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new LogEventSearch();
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
    public function actionView(int $id)
    {
        $item = $this->service->get($id);

        return $this->render('view', [
            'model'  => $item,
        ]);
    }
}