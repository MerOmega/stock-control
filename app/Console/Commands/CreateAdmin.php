<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un nuevo usuario';

    public function handle(): void
    {
        $this->info('Creating a new admin user...');

        $name = $this->ask('Nombre de admin');
        $email = $this->ask('Email');
        $username = $this->ask('username');
        $password = $this->secret('Contraseña');

        if (User::where('email', $email)->exists()) {
            $this->error('Este usuario ya existe!');
            return;
        }

        User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin creado!');
    }
}
