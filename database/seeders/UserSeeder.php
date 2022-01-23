<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        $this->createUser();
    }

    protected function createUser()
    {
        $user = User::create([
            'name' => 'Fábio Parada',
            'email' => 'fabio.198@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $this->command->info("Usuário '$user->email' criado com sucesso!");
    }
}
