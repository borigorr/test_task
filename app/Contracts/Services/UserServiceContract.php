<?php
namespace App\Contracts\Services;

use App\Dto\User\UserDto;
use App\Dto\User\UserListDto;

interface UserServiceContract
{
    const string ADMIN_NAME = "admin";
    const string ADMIN_EMAIL = "admin@admin.admin";

    public function createAdmin(string $password);

    public function getJwtToken(string $email, string $password): string;

    public function getList(int $page): UserListDto;

    public function getById(int $id): UserDto;

    public function delete(int $id): bool;

    public function update(UserDto $user): UserDto;
}
