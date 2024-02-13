<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Piano',
                'price' => 60000.00,
                'description' => 'The piano is a versatile keyboard instrument that produces sound by striking strings with hammers, widely used in classical, jazz, and contemporary music.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guitar',
                'price' => 40000.00,
                'description' => 'The guitar is a stringed musical instrument played by plucking or strumming its strings, used in various genres including rock, blues, folk, and classical music.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Acoustic Guitar',
                'price' => 10000.00,
                'description' => 'The guitar is a stringed musical instrument played by plucking or strumming its strings, used in various genres including rock, blues, folk, and classical music.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bass',
                'price' => 29000.00,
                'description' => 'The bass guitar is a stringed instrument with a longer scale length and lower pitch range, providing the foundational rhythm and harmony in many styles of music, including rock, funk, jazz, and reggae.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Drums',
                'price' => 90000.00,
                'description' => 'Drums are percussion instruments consisting of a set of shells or hollow objects, typically covered with a membrane, played by striking with sticks or hands, crucial for providing rhythm and dynamics in various musical genres.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more sample data as needed
        ]);
    }
}
