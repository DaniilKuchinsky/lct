<?php

namespace core\helpers\log;

class LogEventHelper
{
    const STATUS_PROCESS            = 1;

    const STATUS_SUCCESS            = 2;

    const STATUS_ERROR              = 3;



    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_PROCESS => 'Выполняется...',
            self::STATUS_SUCCESS => 'Успешно выполнен',
            self::STATUS_ERROR   => 'Ошибка',
        ];
    }


    /**
     * @param int $status
     *
     * @return string
     */
    public static function getStatusName(int $status): ?string
    {
        $statusList = self::getStatusList();
        if (array_key_exists($status, $statusList)) {
            return $statusList[ $status ];
        }

        return null;
    }
}