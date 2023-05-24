<?php

namespace core\widgets\grid\consultation;

use core\helpers\consultation\ConsultationHelper;
use yii\grid\DataColumn;
use yii\helpers\Html;

class StatusColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $value = ConsultationHelper::getStatusName($model->status);

        return $this->getLabel($model->status, $value);
    }

    private function getLabel($type, $value): string
    {
        $class = 'info';

        switch ($type) {
            case ConsultationHelper::STATUS_ANALYSIS:
                $class = "warning";
                break;
            case ConsultationHelper::STATUS_ERROR:
                $class = "danger";
                break;
            case ConsultationHelper::STATUS_SUCCESS:
                $class = "success";
                break;
        }

        return Html::tag('span', Html::encode($value), ['class' => 'badge badge-' . $class]);
    }
}