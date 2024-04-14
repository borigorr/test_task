<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Dto\User\CreateUserDto;
use App\Dto\User\UserDto;
use App\Dto\User\UserListDto;
use App\Exceptions\AdminExistException;
use App\Rules\IsAdminRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class UserService implements UserServiceContract
{
    public function __construct(
        private UserRepositoryContract $userRepository
    ) {}

    public function createAdmin(string $password): int
    {
        $userExist = $this->userRepository->existUserWithName(self::ADMIN_NAME);
        if ($userExist) {
            throw new AdminExistException();
        }
        return $this->userRepository->createUser(new CreateUserDto(
            name: self::ADMIN_NAME,
            email: self::ADMIN_EMAIL,
            password: $password
        ))->id;
    }

    public function getJwtToken(string $email, string $password): string
    {
        $validator = Validator::make([
            'email' => $email,
            "password" => $password
        ], [
            'email' => ['email', "required"],
            "password" => ["required"]
        ]);
        $validator->validated();
        $token = auth()->attempt([
            'email' => $email,
            'password' => $password
        ]);
        if (!$token) {
            $validator->errors()->add("error", "Invalid email or password");
            throw new \Illuminate\Validation\ValidationException($validator);
        }
        return $token;
    }

    public function getList(int $page): UserListDto
    {
        return $this->userRepository->getList($page, 10);
    }

    /**
     * @throws ValidationException
     */
    public function getById(int $id): UserDto
    {
        Validator::make([
            "id" => $id
        ], [
            "id" => ["exists:users,id"]
        ])->validate();
        return $this->userRepository->getUserById($id);
    }

    /**
     * @throws ValidationException
     */
    public function delete(int $id): bool
    {
        Validator::make([
            "id" => $id
        ], [
            "id" => [new IsAdminRule()]
        ])->validate();
        return $this->userRepository->delete($id);
    }

    /**
     * @throws ValidationException
     */
    public function update(UserDto $user): UserDto
    {
        Validator::make([
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
        ], [
            "id" => [new IsAdminRule()],
            "name" => ["required"],
            "email" => ["required", "email", Rule::unique('users', 'email')->ignore($user->id)],
        ])->validate();

        return $this->userRepository->update($user);

    }
}
