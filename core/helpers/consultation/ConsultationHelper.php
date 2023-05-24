<?php

namespace core\helpers\consultation;

use Yii;

class ConsultationHelper
{
    const STATUS_NEW       = 1;

    const STATUS_READ_FILE = 2;

    const STATUS_ANALYSIS  = 3;

    const STATUS_SUCCESS   = 4;

    const STATUS_ERROR     = 5;


    /**
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_NEW       => 'Новый файл',
            self::STATUS_READ_FILE => 'Чтение файла',
            self::STATUS_ANALYSIS  => 'Анализ данных',
            self::STATUS_SUCCESS   => 'Анализ успешно завершен',
            self::STATUS_ERROR     => 'Ошибка',
        ];
    }

    /**
     * @return array
     */
    public static function getStatusForUserList(): array
    {
        return [
            self::STATUS_NEW       => 'Загружен новый файл. Обработка файла начнется в ближайшее время...',
            self::STATUS_READ_FILE => 'Происходит чтение данных из файла...',
            self::STATUS_ANALYSIS  => 'Данные успешно загружены. Начинается анализ данных...',
            self::STATUS_SUCCESS   => 'Анализ данных успешно завершен. Сейчас Вы увидите результаты',
            self::STATUS_ERROR     => 'Ошибка при работе с файлом. Попробуйте загрузить файл еще раз.',
        ];
    }


    /**
     * @param int $status
     *
     * @return string
     */
    public static function getStatusName(int $status): ?string
    {
        $types = self::getStatusList();
        if (array_key_exists($status, $types)) {
            return $types[ $status ];
        }

        return null;
    }

    /**
     * @param int $status
     *
     * @return string
     */
    public static function getStatusNameForUser(int $status): ?string
    {
        $types = self::getStatusForUserList();
        if (array_key_exists($status, $types)) {
            return $types[ $status ];
        }

        return null;
    }


    /**
     * @param int $length
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public static function generateUniqueId(int $length = 60): string
    {
        return Yii::$app->security->generateRandomString($length);
    }
}