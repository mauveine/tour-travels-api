<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->state([
                'email' => 'mauveine@protonmail.com',
                'name' => 'Leonard',
                'password' => Hash::make('password'),
            ])->afterCreating(function ($model) {
                /** @var User $model */
                $model->assignRole(UserRoles::Admin->value);
            })->create();

        User::factory()
            ->state([
                'email' => 'admin@domain.test',
                'name' => 'Leonard',
                'password' => Hash::make('password'),
            ])->afterCreating(function ($model) {
                /** @var User $model */
                $model->assignRole(UserRoles::Admin->value);
            })->create();
    }
}
