<?php

namespace core\queueServer\redis;

use yii\queue\JobInterface;

abstract class Job implements JobInterface
{
    public function execute($queue)
    {
        $listener = $this->resolveHandler();
        $listener($this, $queue);
    }

    private function resolveHandler()
    {
        return [\Yii::createObject(static::class . 'Handler'), 'handle'];
    }
}