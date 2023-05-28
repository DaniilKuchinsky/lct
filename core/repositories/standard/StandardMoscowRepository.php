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


    /**
     * @param int $mkb10Id
     * @param int $destinationId
     *
     * @return StandardMoscow
     */
    public function findItem(int $mkb10Id, int $destinationId): ?StandardMoscow
    {
        return StandardMoscow::findOne(['mkb10Id' => $mkb10Id, 'destinationId' => $destinationId]);
    }


    /**
     * @param int  $mkb10Id
     * @param bool $isImportant
     *
     * @return StandardMoscow[]
     */
    public function listByMkb10(int $mkb10Id, bool $isImportant = null): array
    {
        return StandardMoscow::find()->where(['mkb10Id' => $mkb10Id])
                             ->andFilterWhere(['isImportant' => $isImportant])->all();
    }
}