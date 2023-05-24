<?php

namespace core\dispatchers;

use yii\di\Container;

class SimpleEventDispatcher implements EventDispatcher
{
    private $container;
    private $listeners;

    public function __construct(Container $container, array $listeners)
    {
        $this->container = $container;
        $this->listeners = $listeners;
    }

    public function dispatchAll(array $events, $delay = 0)
    {
        foreach ($events as $event) {
            $this->dispatch($event, $delay);
        }
    }

    public function dispatch($event, $delay = 0): int
    {
        $eventName = get_class($event);
        if (array_key_exists($eventName, $this->listeners)) {
            foreach ($this->listeners[$eventName] as $listenerClass) {
                $listener = $this->resolveListener($listenerClass);
                $listener($event);
            }
        }

        return 0;
    }

    private function resolveListener($listenerClass)
    {
        return [$this->container->get($listenerClass), 'handle'];
    }
}