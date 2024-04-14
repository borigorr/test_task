<?php

namespace App\Rules;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\UserServiceContract;
use App\Exceptions\EntityNotFoundException;
use App\Repositories\UserRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsAdminRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $userRepository = app(UserServiceContract::class);
        try {
            $user = $userRepository->getById($value);
            if ($user->id === 1 || $user->name == UserServiceContract::ADMIN_NAME) {
                $fail("validation.is_admin")->translate();
            }
        } catch (EntityNotFoundException $e) {
            $fail("validation.exists")->translate();
        }

    }
}
