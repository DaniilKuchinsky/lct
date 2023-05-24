<?php

namespace core\entities\log;

use core\helpers\log\LogEventHelper;
use yii\db\ActiveRecord;

/**
 * Журнал событий
 *
 * @property integer $id
 * @property integer $status
 * @property integer $dateStart
 * @property integer $dateFinish
 * @property string  $requestInfo
 * @property string  $resultInfo
 *
 */
class LogEvent extends ActiveRecord
{
    public string $dateStartStr  = '';

    public string $dateFinishStr = '';


    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'log_event';
    }


    public function afterFind()
    {
        if ($this->dateStart != 0) {
            $this->dateStartStr = date('d.m.Y H:i:s', $this->dateStart);
        }

        if ($this->dateFinish != 0) {
            $this->dateFinishStr = date('d.m.Y H:i:s', $this->dateFinish);
        }

        parent::afterFind();
    }


    /**
     * @param string $requestInfo
     *
     * @return self
     *
     */
    public static function create(string $requestInfo): LogEvent
    {
        $item = new self();

        $item->status      = LogEventHelper::STATUS_PROCESS;
        $item->requestInfo = $requestInfo;
        $item->dateStart   = time();

        return $item;
    }


    /**
     * @param integer $status
     * @param ?string $resultInfo
     *
     */
    public function edit(int $status, ?string $resultInfo)
    {
        $this->status     = $status;
        $this->resultInfo = $resultInfo;
        $this->dateFinish = time();
    }


    public function getExecutionTime(): int
    {
        return $this->dateFinish ? $this->dateFinish - $this->dateStart : 0;
    }
}