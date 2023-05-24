<?php

namespace core\widgets\grid\user;

use yii\grid\DataColumn;
use Yii;
use yii\helpers\Html;
use yii\rbac\Item;
use core\rbac\Rbac;

class RoleColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $roles = Yii::$app->authManager->getRolesByUser($model->id);
        $list = $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(function (Item $role) {
            return $this->getRoleLabel($role);
        }, $roles));


        return $list;
    }

    private function getRoleLabel(Item $role): string
    {
        $class = "";
        switch ($role->name) {
            case Rbac::ROLE_ADMIN:
                $class = "danger";
                break;
        }

        return Html::tag('span', Html::encode($role->description), ['class' => 'label label-' . $class]);
    }
}