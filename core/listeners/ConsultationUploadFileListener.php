<?php

namespace core\listeners;

use core\events\ConsultationUploadFileEvent;
use core\helpers\consultation\ConsultationHelper;
use core\services\consultation\ConsultationService;
use core\services\log\LogEventService;
use moonland\phpexcel\Excel;
use yii\base\ErrorHandler;

class ConsultationUploadFileListener
{
    private ConsultationService $srvConsultation;

    private LogEventService     $serviceLog;

    private ErrorHandler        $errorHandler;


    public function __construct(
        ConsultationService $srvConsultation,
        LogEventService     $serviceLog,
        ErrorHandler        $errorHandler
    ) {
        $this->srvConsultation = $srvConsultation;
        $this->serviceLog      = $serviceLog;
        $this->errorHandler    = $errorHandler;
    }


    public function handle(ConsultationUploadFileEvent $event)
    {
        $log = $this->serviceLog->create(
            "Загрузка нового файла для анализа. Id консультации°={$event->id}"
        );

        $consultation = $this->srvConsultation->getConsultationById($event->id);

        try {
            if ($consultation->status != ConsultationHelper::STATUS_NEW) {
                $this->serviceLog->error(
                    $log->id,
                    "Ошибка! Статус консультации не верен для начала загрузки. Id консультации°={$event->id}"
                );

                return;
            }

            $this->srvConsultation->readFile(
                $consultation,
                Excel::widget([
                                  'mode'     => 'import',
                                  'fileName' => \Yii::getAlias("@frontend") . '/web/' . $consultation->fileName,
                              ])
            );

            $this->srvConsultation->analysis($consultation);

            $this->serviceLog->success($log->id);
        } catch (\Exception $exception) {
            $this->errorHandler->logException($exception);

            $this->srvConsultation->setStatusConsultation($event->id, ConsultationHelper::STATUS_ERROR);
            $this->serviceLog->error($log->id, $exception);
        }
    }
}