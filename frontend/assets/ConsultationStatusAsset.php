<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ConsultationStatusAsset extends AssetBundle
{
    public $js      = [
        'js/consultation/status.js',
    ];

    public $css     = [
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}