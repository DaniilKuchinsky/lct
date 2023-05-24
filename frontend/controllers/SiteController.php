<?php

namespace frontend\controllers;

use core\forms\consultation\ConsultationForm;
use core\helpers\consultation\ConsultationHelper;
use core\services\consultation\ConsultationService;
use frontend\components\BaseController;
use frontend\forms\ConsultationFinishSearch;
use Yii;
use yii\web\UploadedFile;


class SiteController extends BaseController
{
    private ConsultationService $srvConsultation;


    public function __construct($id, $module, ConsultationService $srvConsultation, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->srvConsultation = $srvConsultation;
    }


    public function actionIndex()
    {
        $form = new ConsultationForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $item = $this->srvConsultation->createConsultation(UploadedFile::getInstance($form, 'fileName'));

                return $this->redirect(['process', 'id' => $item->uniqueId]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('danger', [
                    'title' => 'Ошибка',
                    'msg'   => $e->getMessage(),
                ]);
            }
        }

        return $this->render('index', [
            'model' => $form,
        ]);
    }


    public function actionProcess(string $id): string
    {
        return $this->render('process', [
            'consultation' => $this->srvConsultation->getConsultationByUniqueId($id),
        ]);
    }


    public function actionStatus(string $id): array
    {
        $consultation = $this->srvConsultation->getConsultationByUniqueId($id);
        $rendered     = $this->renderAjax(
            '_status', [
                         'consultation' => $consultation,
                     ]
        );

        return $this->ajaxResponse(
            ['html' => $rendered, 'isRedirect' => $consultation->status == ConsultationHelper::STATUS_SUCCESS]
        );
    }


    public function actionFinish(string $id): string
    {
        $consultation = $this->srvConsultation->getConsultationByUniqueId($id);

        $searchModel = new ConsultationFinishSearch();
        $dataProvider = $searchModel->search($consultation->id, Yii::$app->request->queryParams);

        return $this->render('finish', [
            'consultation' => $consultation,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return mixed
     */
    public function actionReset(string $id)
    {
        $searchModel = new ConsultationFinishSearch();
        $searchModel->resetCookieFilter();

        return $this->redirect(['finish', 'id' => $id]);
    }


}
