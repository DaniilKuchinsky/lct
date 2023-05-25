<?php

namespace core\repositories\dictionary;

use core\entities\dictionary\Destination;

class DestinationRepository
{
    /**
     * @param int $id
     *
     * @return Destination
     */
    public function get(int $id): Destination
    {
        if (!$item = Destination::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $item;
    }


    /**
     * @param string $name
     *
     * @return Destination
     */
    public function findItem(string $name): ?Destination
    {
        return Destination::findOne(['name' => $name]);
    }


    public function save(Destination $item)
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }
}