<?php

namespace src\domain\event;

interface EventDispatcherInterface {
    public function dispatch(object $event): void;
}