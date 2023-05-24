<?php

namespace core\widgets\grid;

use yii\grid\DataColumn;
use yii\helpers\Html;

class TimeColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $str = Html::tag('span', "Изменено: " . $model->updatedStr, ['class' => 'badge badge-secondary']);
        $str .= "<br/>" .
                Html::tag(
                    'span',
                    "Создано: " . $model->createdStr,
                    ['class' => 'badge  badge-secondary', 'style' => 'opacity:0.6']
                );

        return $str;
    }

}