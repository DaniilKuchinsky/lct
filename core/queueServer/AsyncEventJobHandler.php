<?php

namespace core\queueServer;

use core\dispatchers\EventDispatcher;

class AsyncEventJobHandler
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(AsyncEventJob $job)
    {
        $this->dispatcher->dispatch($job->event);
    }
}