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
        DB::table('users')->insert([
            'name' => '超级管理员',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'isadmin' => '1',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
//         $this->call(UsersTableSeeder::class);
    }
}
