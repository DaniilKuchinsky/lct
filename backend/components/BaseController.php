<?php

namespace backend\components;

use core\entities\user\User;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{
    /**
     * Залогиненный юзер
     *
     * @var User
     */
    public $user = null;


    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!\Yii::$app->user->isGuest) {
            /** @var User $user */
            $this->user = \Yii::$app->user->identity;
        }

        parent::init();
    }


    /**
     * Ответ для ajax
     *
     * @param array $data
     *
     * @return array
     */
    protected function ajaxResponse($data = []): array
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
    protected function ajaxError($errorString, $errorType = null):array
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