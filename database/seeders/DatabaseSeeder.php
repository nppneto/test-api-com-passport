<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Populando a tabela de usuários...');
        $this->call(UserSeeder::class);
        $this->command->info('Populando a tabela de produtos...');
        $this->call(ProductSeeder::class);

        $this->command->info('Acabei!');
    }
}
