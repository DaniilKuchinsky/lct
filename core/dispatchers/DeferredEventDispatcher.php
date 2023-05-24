<?php

namespace core\dispatchers;

class DeferredEventDispatcher implements EventDispatcher
{
    private $defer = false;
    private $queue = [];
    private $next;

    public function __construct(EventDispatcher $next)
    {
        $this->next = $next;
    }

    public function dispatchAll(array $events, $delay = 0)
    {
        foreach ($events as $event) {
            $this->dispatch($event, $delay);
        }
    }

    public function dispatch($event, $delay = 0): int
    {
        if ($this->defer) {
            $this->queue[] = $event;
        } else {
            return $this->next->dispatch($event, $delay);
        }

        return 0;
    }

    public function defer()
    {
        $this->defer = true;
    }

    public function clean()
    {
        $this->queue = [];
        $this->defer = false;
    }

    public function release()
    {
        foreach ($this->queue as $i => $event) {
            $this->next->dispatch($event);
            unset($this->queue[$i]);
        }
        $this->defer = false;
    }
}