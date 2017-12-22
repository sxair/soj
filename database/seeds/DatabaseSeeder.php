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
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => '80976512@qq.com',
            'password' => bcrypt('admin'),
            'locked' => 1,
            'control' => 4294967295,
        ]);
        DB::table('user_infos')->insert([
            'id' => '1',
        ]);
        DB::table('admins')->insert([
            'id' => 1,
            'password' => bcrypt('admin'),
        ]);
    }
}
