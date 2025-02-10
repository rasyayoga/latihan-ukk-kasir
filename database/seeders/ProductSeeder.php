<?php

namespace Database\Seeders;

use App\Models\products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $users = [
                [
                    'name' => 'Kipas Angin',
                    'price' => '20000',
                    'stock' => '10',
                    'image' => 'image'
                ],
                [
                    'name' => 'Kipas AC',
                    'price' => '25000',
                    'stock' => '10',
                    'image' => 'image'
                ],
            ];
    
            foreach ($users as $user) {
                products::create($user);
            }
        }
    }
}
