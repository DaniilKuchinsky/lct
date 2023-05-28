<?php

namespace core\repositories\consultation;

use core\entities\consultation\ConsultationDiagnosis;
use core\entities\consultation\ConsultationDiagnosisDestination;

class ConsultationDiagnosisDestinationRepository
{

    /**
     * @param int $id
     *
     * @return ConsultationDiagnosisDestination
     */
    public function get(int $id): ConsultationDiagnosisDestination
    {
        if (!$item = ConsultationDiagnosisDestination::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $item;
    }


    public function save(ConsultationDiagnosisDestination $item)
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }


    /**
     * @param int $consultationId
     * @param int $statusStandard
     *
     * @return integer
     */
    public function countByStatusStandard(int $consultationId, int $statusStandard): int
    {
        return ConsultationDiagnosisDestination::find()
                                               ->alias('cdd')
                                               ->innerJoin(['cd' => ConsultationDiagnosis::tableName()],
                                                           'cd.id = cdd."consultationDiagnosisId"')
                                               ->where(
                                                   [
                                                       'consultationId' => $consultationId,
                                                       'statusStandard' => $statusStandard,
                                                   ]
                                               )->count();
    }
}