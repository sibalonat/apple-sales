<?php

namespace Database\Seeders;

use App\Models\User;
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
        // User::factory(10)->create([
        //     'is_admin' => 0
        // ]);
        $this->call([
            VendorSeeder::class,
            ProductSeeder::class,
            LinkSeeder::class,
            OrderSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
