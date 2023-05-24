<?php

namespace frontend\components;


use common\auth\Identity;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{
    /**
     * Ответ для ajax
     *
     * @param array $data
     *
     * @return array
     */
    protected function ajaxResponse($data = [])
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return array_merge(['result' => 'ok'], $data);
    }


    /**
     * Ответ ошибкой для AJAX
     *
     * @param      $errorString
     * @param null $errorType
     *
     * @return array
     */
    protected function ajaxError($errorString, $errorType = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $data = [
            'result' => 'error',
            'error'  => $errorString,
        ];

        if (!is_null($errorType)) {
            $data['errorType'] = $errorType;
        }

        return $data;
    }
}