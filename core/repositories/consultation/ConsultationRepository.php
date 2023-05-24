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
        if (!$user = Consultation::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $user;
    }


    /**
     * @param string $uniqueId
     *
     * @return Consultation
     */
    public function getByUniqueId(string $uniqueId): Consultation
    {
        if (!$user = Consultation::findOne(['uniqueId' => $uniqueId])) {
            throw new \DomainException('Запись не найдена');
        }

        return $user;
    }


    public function save(Consultation $user)
    {
        if (!$user->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }
}