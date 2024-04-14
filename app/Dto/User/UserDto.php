<?php

namespace App\Dto\User;

readonly class UserDto {
    public function __construct(
        public string $name,
        public string $email,
        public int $id
    ) {}
}
