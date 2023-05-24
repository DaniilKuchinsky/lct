<?php

namespace core\helpers;

use Yii;

class SiteHelper
{
    public static function getUrlSite(): string
    {
        return Yii::$app->params['urlSite'] ;
    }
}