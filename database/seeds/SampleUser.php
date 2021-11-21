<?php

use Illuminate\Database\Seeder;

class SampleUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '管理者',
            'email' => 'orora_togiants@yahoo.co.jp',
            'password' => bcrypt('password'),
            'role' => 1,
        ];
        DB::table('users')->insert($param);
    }
}
