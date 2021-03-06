<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ChanelsSeeder::class);
        $this->call(BannersSeeder::class);
    }
}
