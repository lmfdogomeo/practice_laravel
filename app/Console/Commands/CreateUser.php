<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user
                            {fullname : The name of the user}
                            {email : The email of the user}
                            {password : Password in plain text (will be encrypted automatically)}
                            {--unverified : Keep the user unverified. Otherwise, email verified will be set at current time.}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user to access the admin panel';

    private array $rules = [
        'fullname' => ['required', 'min:4', 'unique:users,fullname'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'min:8'],
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $validator = Validator::make([
            'fullname' => $this->argument('fullname'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
            'role' => 'admin'
        ], $this->rules);

        try {
            $userData = $validator->validated();

            $userData['password'] = bcrypt($userData['password']);
            $userData['email_verified_at'] = $this->option('unverified') ? NULL : now();

            User::create($userData);

            $this->info('User created.');

        } catch (\Exception $e) {
            $this->error("ERROR: {$e->getMessage()} [Code: {$e->getCode()}]");
            return 1;
        }

        return 0;
    }
}
