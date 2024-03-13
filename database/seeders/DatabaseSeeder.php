<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Bank;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Bank::create([
            'name' => 'Kaspi',
            'code' => 'CASPKZKA'
        ]);

        Bank::create([
            'name' => 'Halyk',
            'code' => 'HSBKKZKX'
        ]);

        Bank::create([
            'name' => 'Jusan',
            'code' => 'TSESKZKA'
        ]);
    }
}
