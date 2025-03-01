<?php

namespace src\domain\repository;

use src\domain\entity\User;
use src\domain\entity\valueObject\UserId;

interface UserRepositoryInterface {
    public function findById(UserId $id): ?User;
    public function save(User $user): void;
    public function delete(User $user): void;
}