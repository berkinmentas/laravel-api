<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement("TRUNCATE TABLE users");

        DB::table("users")->insert([
            'name' => 'admin',
            'email' => 'admin@laravelapi.test',
            'email_verified_at'=>now(),
            'password' => bcrypt(123),
            'remember_token'=> Str::random(10),
            'api_token'=> Str::random(60)

        ]);
        User::factory()->count(10)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
