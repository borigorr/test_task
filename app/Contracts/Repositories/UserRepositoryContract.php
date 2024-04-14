<?php

namespace App\Contracts\Repositories;

use App\Dto\User\CreateUserDto;
use App\Dto\User\UserDto;
use App\Dto\User\UserListDto;

interface UserRepositoryContract
{
    public function existUserWithName(string $name): bool;

    public function createUser(CreateUserDto $data): UserDto;

    public function getList(int $page, int $perPage): UserListDto;

    public function getUserById(int $id): UserDto;

    public function delete(int $id): bool;

    public function update(UserDto $user): UserDto;
}
