<?php

namespace backend\controllers;

use backend\components\BaseController;
use backend\forms\standard\StandardFederalSearch;
use backend\forms\standard\StandardFileForm;
use core\services\standard\StandardFederalService;
use Yii;
use yii\web\UploadedFile;

class StandardFederalController extends BaseController
{
    private StandardFederalService $srvStandard;


    public function __construct($id, $module, StandardFederalService $srvStandard, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->srvStandard = $srvStandard;
    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new StandardFederalSearch();
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
        $searchModel  = new StandardFederalSearch();
        $searchModel->resetCookieFilter();

        return $this->redirect('index');
    }


    public function actionLoadData()
    {
        $form = new StandardFileForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->srvStandard->loadData(UploadedFile::getInstance($form, 'fileName'));

                return $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', [
                    'title' => 'Ошибка',
                    'msg'   => $e->getMessage(),
                ]);
            }
        }

        return $this->render('load-data', [
            'model' => $form,
        ]);
    }
}