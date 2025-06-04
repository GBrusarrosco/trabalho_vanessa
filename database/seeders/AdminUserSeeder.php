<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'gabriel.brusarrosco@fatec.sp.gov.br'], // Chave para verificar se já existe
            [
                'name' => 'Administrador Master',
                'document' => '47857657808', // Ou um documento válido se necessário
                'password' => Hash::make('10203040'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
