<?php

namespace core\dispatchers;

use core\queueServer\AsyncEventJob;
use yii\queue\Queue;

class AsyncEventDispatcher implements EventDispatcher
{
    private $queue;

    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    public function dispatchAll(array $events, $delay = 0)
    {
        foreach ($events as $event) {
            $this->dispatch($event, $delay);
        }
    }

    public function dispatch($event, $delay = 0): int
    {
        return $this->queue->delay($delay)->push(new AsyncEventJob($event));
    }
}