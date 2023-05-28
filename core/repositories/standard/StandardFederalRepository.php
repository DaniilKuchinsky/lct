<?php

namespace core\repositories\standard;

use core\entities\standard\StandardFederal;

class StandardFederalRepository
{
    /**
     * @param int $id
     *
     * @return StandardFederal
     */
    public function get(int $id): StandardFederal
    {
        if (!$item = StandardFederal::findOne($id)) {
            throw new \DomainException('Запись не найдена');
        }

        return $item;
    }


    public function resetItems()
    {
        StandardFederal::deleteAll();
    }


    public function save(StandardFederal $item)
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения данных');
        }
    }


    /**
     * @param int $mkb10Id
     * @param int $destinationId
     *
     * @return StandardFederal
     */
    public function findItem(int $mkb10Id, int $destinationId): ?StandardFederal
    {
        return StandardFederal::findOne(['mkb10Id' => $mkb10Id, 'destinationId' => $destinationId]);
    }


    /**
     * @param int  $mkb10Id
     * @param bool $isImportant
     *
     * @return StandardFederal[]
     */
    public function listByMkb10(int $mkb10Id, bool $isImportant = null): array
    {
        return StandardFederal::find()->where(['mkb10Id' => $mkb10Id])
                              ->andFilterWhere(['isImportant' => $isImportant])->all();
    }
}