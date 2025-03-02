<?php

namespace src\domain\event;

interface EventDispatcherInterface {
    public function dispatch(Event $event): void;
}