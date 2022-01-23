<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->truncate();
        $this->createProducts();
    }

    protected function createProducts()
    {
        for ($i = 1; $i <= 10; $i++) { 
            $product = Product::create([
                'name' => 'Produto nº ' . $i,
                'description' => 'Descrição do produto nº ' . $i,
                'slug' => Str::slug("Produto nº $i"),
                'price' => rand(10, 1000) / 10,
            ]);

            $this->command->info("Produto nº $i criado com sucesso!");
        }
    }
}
