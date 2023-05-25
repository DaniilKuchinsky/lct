<?php

namespace core\repositories\consultation;

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
}