<?php

namespace frontend\controllers;

use core\forms\consultation\ConsultationForm;
use core\helpers\consultation\ConsultationHelper;
use core\services\consultation\ConsultationService;
use frontend\components\BaseController;
use frontend\forms\ConsultationFinishSearch;
use Yii;
use yii\data\ArrayDataProvider;
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

        $arrData = [];

        foreach (ConsultationHelper::getStatusStandardList() as $key => $name) {
            $arrData[] = [
                'statusId'       => $key,
                'consultationId' => $consultation->uniqueId,
                'name'           => $name,
                'population'     => $this->srvConsultation->countByStatusStandard($consultation->id, $key),
            ];
        }

        return $this->render('finish', [
            'dataProvider' => new ArrayDataProvider([
                                                        'allModels'  => $arrData,
                                                        'pagination' => false,
                                                    ]),
        ]);
    }


    public function actionResultInfo(string $id, int $statusStandard): string
    {
        $consultation = $this->srvConsultation->getConsultationByUniqueId($id);

        $searchModel  = new ConsultationFinishSearch();
        $dataProvider = $searchModel->search($consultation->id, $statusStandard, Yii::$app->request->queryParams);

        return $this->render('result-info', [
            'consultation' => $consultation,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'statusStandardName' => ConsultationHelper::getStatusStandardName($statusStandard)
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
