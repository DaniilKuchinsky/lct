<?php

namespace core\repositories\standard;

use core\entities\standard\StandardMoscow;

class StandardMoscowRepository
{
    /**
     * @param int $id
     *
     * @return StandardMoscow
     */
    public function get(int $id): StandardMoscow
    {
        if (!$item = StandardMoscow::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $item;
    }


    public function resetItems()
    {
        StandardMoscow::deleteAll();
    }


    public function save(StandardMoscow $item)
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }
}