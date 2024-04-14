<?php

namespace App\Dto\User;

 readonly class UserListDto
{
    public function __construct(
        /** @var UserDto[]  */
        public array $list,
        public int $total,
        public int $currentPage,
        public int $perPage,
    ) {}
}
