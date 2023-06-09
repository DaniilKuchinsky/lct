<?php

namespace core\services\consultation;

use core\dispatchers\EventDispatcher;
use core\entities\consultation\Consultation;
use core\entities\consultation\ConsultationDiagnosis;
use core\entities\consultation\ConsultationDiagnosisDestination;
use core\events\ConsultationUploadFileEvent;
use core\helpers\consultation\ConsultationHelper;
use core\helpers\user\UserHelper;
use core\repositories\consultation\ConsultationDiagnosisDestinationRepository;
use core\repositories\consultation\ConsultationDiagnosisRepository;
use core\repositories\consultation\ConsultationRepository;
use core\repositories\dictionary\DestinationRepository;
use core\repositories\dictionary\Mkb10Repository;
use core\repositories\standard\StandardFederalRepository;
use core\repositories\standard\StandardMoscowRepository;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ConsultationService
{
    protected ConsultationRepository                     $repConsultation;

    protected ConsultationDiagnosisRepository            $repConsultationDiagnosis;

    protected ConsultationDiagnosisDestinationRepository $repConsultationDiagnosisDestination;

    protected EventDispatcher                            $dispatcher;

    protected Mkb10Repository                            $repMkb10;

    protected DestinationRepository                      $repDestination;

    protected StandardMoscowRepository                   $repStandardMoscow;

    protected StandardFederalRepository                  $repStandardFederal;


    public function __construct(
        ConsultationRepository                     $repConsultation,
        ConsultationDiagnosisRepository            $repConsultationDiagnosis,
        ConsultationDiagnosisDestinationRepository $repConsultationDiagnosisDestination,
        Mkb10Repository                            $repMkb10,
        DestinationRepository                      $repDestination,
        StandardMoscowRepository                   $repStandardMoscow,
        StandardFederalRepository                  $repStandardFederal,
        EventDispatcher                            $dispatcher
    ) {
        $this->repConsultation                     = $repConsultation;
        $this->repConsultationDiagnosis            = $repConsultationDiagnosis;
        $this->repConsultationDiagnosisDestination = $repConsultationDiagnosisDestination;
        $this->repMkb10                            = $repMkb10;
        $this->repDestination                      = $repDestination;
        $this->repStandardMoscow                   = $repStandardMoscow;
        $this->repStandardFederal                  = $repStandardFederal;
        $this->dispatcher                          = $dispatcher;
    }


    /**
     * @param integer $id
     *
     * @return Consultation
     */
    public function getConsultationById(int $id): Consultation
    {
        return $this->repConsultation->get($id);
    }


    /**
     * @param string $uniqueId
     *
     * @return Consultation
     */
    public function getConsultationByUniqueId(string $uniqueId): Consultation
    {
        return $this->repConsultation->getByUniqueId($uniqueId);
    }


    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    private function uploadFile(UploadedFile $file): string
    {
        $fileName = uniqid() . '.' . $file->extension;

        $path = "/consultation";
        FileHelper::createDirectory(\Yii::getAlias("@frontend") . '/web' . $path);
        $file->saveAs(\Yii::getAlias("@frontend") . "/web{$path}/{$fileName}");

        return "{$path}/{$fileName}";
    }


    /**
     * @param UploadedFile $fileConsultation
     *
     * @return Consultation
     */
    public function createConsultation(UploadedFile $fileConsultation): Consultation
    {
        $item = Consultation::create($this->uploadFile($fileConsultation));

        $this->repConsultation->save($item);

        $this->dispatcher->dispatch(new ConsultationUploadFileEvent($item));

        return $item;
    }


    /**
     * @param integer $id
     * @param integer $newStatus
     *
     * @return void
     */
    public function setStatusConsultation(int $id, int $newStatus): void
    {
        $item = $this->repConsultation->get($id);
        $item->setStatus($newStatus);
        $this->repConsultation->save($item);

        if ($item->status == ConsultationHelper::STATUS_NEW) {
            $this->dispatcher->dispatch(new ConsultationUploadFileEvent($item));
        }
    }


    /**
     * @param Consultation $consultation
     * @param array        $data
     *
     * @return void
     */
    public function readFile(Consultation $consultation, array $data): void
    {
        $this->setStatusConsultation($consultation->id, ConsultationHelper::STATUS_READ_FILE);


        foreach ($data as $item) {
            if (is_null($item['Пол пациента'])) {
                continue;
            }

            $itemDiagnosis = ConsultationDiagnosis::create(
                $consultation->id,
                UserHelper::setSexName(mb_strtolower($item['Пол пациента'])),
                strtotime($item['Дата рождения пациента']),
                mb_strtolower($item['ID пациента']),
                mb_strtolower($item['Код МКБ-10']),
                mb_strtolower($item['Диагноз']),
                strtotime($item['Дата оказания услуги']),
                mb_strtolower($item['Должность']),
            );

            $this->repConsultationDiagnosis->save($itemDiagnosis);

            $arrDestinations = explode(PHP_EOL, $item['Назначения']);
            foreach ($arrDestinations as $destination) {
                if (strlen($destination) == 0) {
                    continue;
                }

                $arrDest = explode(';', $destination);
                foreach ($arrDest as $dest) {
                    $itemDest =
                        ConsultationDiagnosisDestination::create($itemDiagnosis->id, mb_strtolower(trim($dest)));
                    $this->repConsultationDiagnosisDestination->save($itemDest);
                }
            }
        }
    }


    /**
     * @param Consultation $consultation
     *
     * @return void
     */
    public function analysis(Consultation $consultation): void
    {
        $this->setStatusConsultation($consultation->id, ConsultationHelper::STATUS_ANALYSIS);

        foreach ($consultation->consultationDiagnoses as $consultationDiagnosis) {
            $mkb10 = $this->repMkb10->findItem($consultationDiagnosis->codeMkb);

            foreach ($consultationDiagnosis->consultationDiagnosisDestinations as $consultationDiagnosisDestination) {
                $status            = ConsultationHelper::STATUS_STANDARD_5;
                $standardMoscowId  = null;
                $standardFederalId = null;

                $destination = $this->repDestination->findItem($consultationDiagnosisDestination->name);

                if ($mkb10 != null && $destination != null) {
                    $standardMoscow = $this->repStandardMoscow->findItem($mkb10->id, $destination->id);

                    if ($standardMoscow) {
                        $status = $standardMoscow->isImportant ?
                            ConsultationHelper::STATUS_STANDARD_1 :
                            ConsultationHelper::STATUS_STANDARD_2;

                        $standardMoscowId = $standardMoscow->id;
                    }

                    $standardFederal = $this->repStandardFederal->findItem($mkb10->id, $destination->id);

                    if ($standardFederal) {
                        $status = $standardFederal->isImportant ?
                            ConsultationHelper::STATUS_STANDARD_3 :
                            ConsultationHelper::STATUS_STANDARD_4;

                        $standardFederalId = $standardFederal->id;
                    }
                }

                $consultationDiagnosisDestination->setStatusStandard($status, $standardMoscowId, $standardFederalId);
                $this->repConsultationDiagnosisDestination->save($consultationDiagnosisDestination);
            }
        }

        $this->setStatusConsultation($consultation->id, ConsultationHelper::STATUS_SUCCESS);
    }


    /**
     * @param int $consultationId
     * @param int $statusStandard
     *
     * @return integer
     */
    public function countByStatusStandard(int $consultationId, int $statusStandard): int
    {
        return $this->repConsultationDiagnosisDestination->countByStatusStandard($consultationId, $statusStandard);
    }
}