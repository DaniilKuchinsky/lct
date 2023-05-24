<?php

namespace core\helpers;

use yii\web\Cookie;

class CookieHelper
{
    /**
     * Получаем данные из cookie
     *
     * @param string $name
     * @param string $defaultValue
     *
     * @return mixed
     */
    public static function getCookieData(string $name,string $defaultValue = "0")
    {
        $cookies = \Yii::$app->request->cookies;

        return $cookies->getValue($name, $defaultValue);
    }


    /**
     * Проверяет данные из cookie
     *
     * @param string $name
     *
     * @return boolean
     */
    public static function hasCookieData(string $name)
    {
        $cookies = \Yii::$app->request->cookies;

        return $cookies->has($name);
    }


    /**
     * Сохраняем данные из cookie
     *
     * @param string  $name
     * @param  $value
     * @param integer $expire
     *
     * @return void
     */
    public static function setCookieData(string $name, $value,int $expire = null)
    {
        $cookies = \Yii::$app->response->cookies;

        $cookies->add(
            new Cookie([
                           'name'   => $name,
                           'value'  => $value,
                           'expire' => $expire ? time() + $expire : 0,
                       ])
        );
    }


    /**
     * Удаляем из cookie
     *
     * @param string $name
     *
     * @return void
     */
    public static function removeCookieData(string $name)
    {
        $cookies = \Yii::$app->request->cookies;

        $cookies->remove($name);
    }
}