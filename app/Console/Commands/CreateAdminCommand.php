<?php

namespace App\Console\Commands;

use App\Contracts\Services\UserServiceContract;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command create admin';

    /**
     * Execute the console command.
     */
    public function handle(UserServiceContract $userService)
    {
        $userService->createAdmin($this->argument('password'));
    }
}
