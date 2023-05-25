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
        if (!$item = ConsultationDiagnosis::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $item;
    }



    public function save(ConsultationDiagnosis $item)
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }
}