<?php

namespace core\repositories\consultation;

use core\entities\consultation\Consultation;

class ConsultationRepository
{

    /**
     * @param int $id
     *
     * @return Consultation
     */
    public function get(int $id): Consultation
    {
        if (!$item = Consultation::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $item;
    }


    /**
     * @param string $uniqueId
     *
     * @return Consultation
     */
    public function getByUniqueId(string $uniqueId): Consultation
    {
        if (!$item = Consultation::findOne(['uniqueId' => $uniqueId])) {
            throw new \DomainException('Запись не найдена');
        }

        return $item;
    }


    public function save(Consultation $item)
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }
}