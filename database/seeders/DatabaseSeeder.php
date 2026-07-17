<?php

namespace Database\Seeders;

use Database\Seeders\GejalaSeeder;
use Database\Seeders\PenyakitSeeder;
use Database\Seeders\RulesSeeder;
use Database\Seeders\RuleDetailSeeder;
use Doctrine\Inflector\Rules\English\Rules;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            GejalaSeeder::class,
            PenyakitSeeder::class,
            RulesSeeder::class,
            UserSeeder::class,
            RuleDetailSeeder::class,
        ]);
    }
}
