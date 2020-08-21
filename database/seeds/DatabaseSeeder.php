<?php

use Illuminate\Database\Eloquent\Model;
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
        // $this->call(UsersTableSeeder::class);

        // Disable all mass assignment restrictions
        Model::unguard();

        $this->call(AdminsTableSeeder::class);

        // Re enable all mass assignment restrictions
        Model::reguard();
    }
}
