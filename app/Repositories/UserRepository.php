<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Dto\User\CreateUserDto;
use App\Dto\User\UserDto;
use App\Dto\User\UserListDto;
use App\Exceptions\EntityNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryContract
{
    public function existUserWithName(string $name): bool
    {
        return User::where("name", $name)->first() !== null;
    }

    public function createUser(CreateUserDto $data): UserDto
    {
        /** @var User $user */
       $user = User::create([
            "email" => $data->email,
            "name" => $data->name,
           "password" => Hash::make($data->password)
        ]);
        return $this->modelToDto($user);
    }

    public function getList(int $page, int $perPage): UserListDto
    {
        $users = User::paginate(perPage: $perPage, page: $page);
        $usersList = [];
        foreach ($users as $item) {
            $usersList[] = $this->modelToDto($item);
        }
        return new UserListDto(
            list: $usersList,
            total: $users->total(),
            currentPage: $users->currentPage(),
            perPage: $users->perPage()
        );
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getUserById(int $id): UserDto
    {
        $user = User::where("id", $id)->first();
        if (is_null($user)) {
            throw new EntityNotFoundException();
        }
        return $this->modelToDto($user);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function update(UserDto $data): UserDto
    {
        $user = User::where("id", $data->id)->first();
        if (empty($user)) {
            throw new EntityNotFoundException();
        }
        $user->name = $data->name;
        $user->email = $data->email;
        $user->save();
        return $this->modelToDto($user);
    }

    public function delete(int $id): bool
    {
        return User::where("id", $id)->delete();
    }

    private function modelToDto(User $user): UserDto {
        return new UserDto(
            name: $user->name,
            email: $user->email,
            id:  $user->id,
        );
    }
}
