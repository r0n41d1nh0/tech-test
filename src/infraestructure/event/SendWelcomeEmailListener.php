<?php

namespace src\infraestructure\event;

use src\domain\event\UserRegisteredEvent;

class SendWelcomeEmailListener {
    public function handle(UserRegisteredEvent $event): void {
        echo "Enviar email de bienvenida para:" . $event->getEmail()->getValue()."\n";
    }
}