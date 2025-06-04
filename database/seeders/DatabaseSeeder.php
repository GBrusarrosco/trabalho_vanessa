<?php

namespace Database\Seeders;

use App\Models\User; // Se você tiver o factory aqui, mantenha
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            // Você pode adicionar outras seeders aqui no futuro
        ]);
    }
}
