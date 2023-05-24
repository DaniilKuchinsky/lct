<?php

namespace core\widgets\grid\log;

use core\helpers\log\LogEventHelper;
use yii\grid\DataColumn;
use yii\helpers\Html;

class StatusColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $value = LogEventHelper::getStatusName($model->status);

        return $this->getLabel($model->status, $value);
    }

    private function getLabel($type, $value): string
    {
        $class = 'info';

        switch ($type) {
            case LogEventHelper::STATUS_PROCESS:
                $class = "warning";
                break;
            case LogEventHelper::STATUS_ERROR:
                $class = "danger";
                break;
            case LogEventHelper::STATUS_SUCCESS:
                $class = "success";
                break;
        }

        return Html::tag('span', Html::encode($value), ['class' => 'badge badge-' . $class]);
    }
}