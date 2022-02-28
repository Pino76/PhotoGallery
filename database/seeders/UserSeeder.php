<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=30; $i++){
            DB::table('users')->insert([
                "name"=>"Pippob_$i",
                "email"=>"pippob_$i@email.it",
                "email_verified_at"=>Carbon::now(),
                "password"=>Hash::make("pippob_$i"),
                "created_at"=>Carbon::now()
            ]);
        }


    }
}
