<?php

namespace core\models;

use core\helpers\CookieHelper;
use yii\base\Model;

class CookieModel extends Model
{
    public string $className   = "";

    public array $cookiesList = [];

    public function __construct($config = [])
    {
        foreach ($this->cookiesList as $item) {
            if (CookieHelper::hasCookieData("{$this->className}_{$item}")) {
                $this->$item = CookieHelper::getCookieData("{$this->className}_{$item}");
            }
        }

        parent::__construct($config);
    }


    /**
     * @param integer $time
     */
    protected function setDataForCookies($time = 60 * 60)
    {
        foreach ($this->cookiesList as $item) {
            if (isset($this->$item)) {
                CookieHelper::setCookieData("{$this->className}_{$item}", $this->$item, $time);
            }
        }
    }

    protected function resetDataFromCookies()
    {
        foreach ($this->cookiesList as $item) {
            if (isset($this->$item)) {
                CookieHelper::setCookieData("{$this->className}_{$item}", 0, -20);
            }
        }
    }

}