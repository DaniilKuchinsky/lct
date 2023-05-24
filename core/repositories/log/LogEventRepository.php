<?php

namespace core\repositories\log;

use core\entities\log\LogEvent;

class LogEventRepository
{
    /**
     * @param integer $id
     *
     * @return LogEvent
     * @throws
     */
    public function get(int $id): LogEvent
    {
        if (!$item = LogEvent::findOne($id)) {
            throw new \DomainException('Лог не найден.');
        }

        return $item;
    }


    /**
     * @param LogEvent $item
     *
     * @return void
     * @throws
     */
    public function save(LogEvent $item)
    {
        if (!$item->save()) {
            throw new \RuntimeException('Ошибка сохранения');
        }
    }
}