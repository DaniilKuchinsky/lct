<?php

namespace core\dispatchers;

interface EventDispatcher
{
    public function dispatchAll(array $events, $delay = 0);
    public function dispatch($event, $delay = 0): int;
}