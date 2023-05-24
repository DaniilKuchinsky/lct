<?php

namespace core\queueServer;

use core\queueServer\redis\Job;

class AsyncEventJob extends Job
{
    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }
}