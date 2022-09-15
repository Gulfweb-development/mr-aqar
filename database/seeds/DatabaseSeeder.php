<?php

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
        // $this->call(UserSeeder::class);
        factory(App\User::class, 5)->states('company')->create();
        factory(App\User::class, 20)->create();
        factory(App\User::class, 35)->states('company')->create();
        factory(App\Models\Advertising::class, 400)->create();
    }
}
