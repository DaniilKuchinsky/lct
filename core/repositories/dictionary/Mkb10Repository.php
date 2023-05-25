<?php

namespace core\repositories\dictionary;

use core\entities\dictionary\Mkb10;

class Mkb10Repository
{

    /**
     * @param int $id
     *
     * @return Mkb10
     */
    public function get(int $id): Mkb10
    {
        if (!$item = Mkb10::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $item;
    }


    /**
     * @param string $name
     *
     * @return Mkb10
     */
    public function findItem(string $name): ?Mkb10
    {
        return Mkb10::findOne(['name' => $name]);
    }


    /**
     * @return Mkb10[]
     */
    public function listItems(): array
    {
        return Mkb10::find()->orderBy(['name' => SORT_ASC])->all();
    }


    public function save(Mkb10 $item)
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }
}