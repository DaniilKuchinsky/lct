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
        if (!$user = ConsultationDiagnosisDestination::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $user;
    }


    public function save(ConsultationDiagnosisDestination $user)
    {
        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }
}