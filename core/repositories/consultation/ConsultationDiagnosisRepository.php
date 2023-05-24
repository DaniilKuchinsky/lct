<?php

namespace core\repositories\consultation;

use core\entities\consultation\Consultation;
use core\entities\consultation\ConsultationDiagnosis;

class ConsultationDiagnosisRepository
{

    /**
     * @param int $id
     *
     * @return ConsultationDiagnosis
     */
    public function get(int $id): ConsultationDiagnosis
    {
        if (!$user = ConsultationDiagnosis::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $user;
    }



    public function save(ConsultationDiagnosis $user)
    {
        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }
}