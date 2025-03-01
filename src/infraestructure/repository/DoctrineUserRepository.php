<?php

namespace src\infraestructure\repository;

use Doctrine\ORM\EntityManagerInterface;
use src\domain\entity\User;
use src\domain\entity\valueObject\UserId;
use src\domain\repository\UserRepositoryInterface;
use src\infraestructure\doctrine\UserMapping;

class DoctrineUserRepository implements UserRepositoryInterface {
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function findById(UserId $id): ?User {
        $userMapping = $this->entityManager->find(UserMapping::class, $id->getValue());
        if ($userMapping === null) {
            return null;
        }
        return $userMapping->toDomain();
    }

    public function save(User $user): void {
        $userMapping = new UserMapping($user);
        $this->entityManager->persist($userMapping);
        $this->entityManager->flush();
    }

    public function delete(User $user): void {
        $user = $this->entityManager->find(UserMapping::class, $user->getId()->getValue());

        if ($user === null) {
            throw new \Exception("User not found.");
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}