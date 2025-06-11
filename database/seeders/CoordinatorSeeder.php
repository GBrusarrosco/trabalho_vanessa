<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Coordinator;
use Illuminate\Support\Facades\Hash;

class CoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'coordenador@exemplo.com'],
            [
                'name' => 'Coordenador Master',
                'document' => '47857657808',
                'password' => Hash::make('10203040'),
                'role' => 'coordenador',
                'email_verified_at' => now(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            Coordinator::create([
                'user_id' => $user->id,
                'departamento' => 'Geral',
            ]);
        }
    }
}
