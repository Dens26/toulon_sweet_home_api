<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: "lexik_jwt_authentication.on_jwt_created", method: 'onJWTCreated')]
final class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $payload = $event->getData();
        /** @var \App\Entity\User */
        $user = $event->getUser();

        $payload['email'] = $user->getUserIdentifier();
        $payload['firstName'] = $user->getFirstName();
        $payload['lastName'] = $user->getLastName();
        $payload['userName'] = $user->getUserName();
        $payload['phoneNumber'] = $user->getPhoneNumber();
        $payload['picture'] = $user->getPicture();


        $event->setData($payload);
    }
}
