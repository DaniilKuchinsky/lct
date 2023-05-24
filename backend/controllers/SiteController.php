<?php

namespace backend\controllers;

use backend\components\BaseController;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
