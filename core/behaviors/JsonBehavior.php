<?php

namespace core\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class JsonBehavior extends Behavior
{
    public $attribute = 'fieldIds';
    public $jsonAttribute = 'fieldIds_json';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind($event)
    {
        $model = $event->sender;
        $model->{$this->attribute} = Json::decode($model->getAttribute($this->jsonAttribute));
    }

    public function onBeforeSave($event)
    {
        $model = $event->sender;
        $model->setAttribute($this->jsonAttribute, Json::encode($model->{$this->attribute}));
    }
}