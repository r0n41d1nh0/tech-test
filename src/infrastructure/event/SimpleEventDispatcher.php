<?php

namespace src\infrastructure\event;

use src\domain\event\EventDispatcherInterface;

class SimpleEventDispatcher implements EventDispatcherInterface {
    private array $listeners = [];

    public function addListener(string $eventName, callable $listener): void {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch($event): void {
        $eventName = get_class($event);
        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $listener) {
            $listener($event);
        }
    }
}