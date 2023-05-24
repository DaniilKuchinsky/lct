<?php

namespace core\widgets\grid\user;

use core\helpers\user\UserHelper;
use yii\grid\DataColumn;
use yii\helpers\Html;

class StatusColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $value = UserHelper::getStatusName($model->status);

        return $this->getLabel($model->status, $value);
    }

    private function getLabel($status, $value): string
    {
        $class = 'info';
        switch ($status) {
            case UserHelper::STATUS_ACTIVE:
                $class = "success";
                break;
            case UserHelper::STATUS_DELETED:
                $class = "danger";
                break;
        }

        return Html::tag('span', Html::encode($value), ['class' => 'badge badge-' . $class]);
    }
}