<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'      => 'Автор не известен',
                'email'     => 'autor_unknow@g.g',
                'password'  => bcrypt(str_random(16)),
            ],
            [
                'name'      => 'Автор',
                'email'     => 'author@g.g',
                'password'  => bcrypt('123123'),
            ],
        ];

        \Illuminate\Support\Facades\DB::table('users') -> insert($data);
    }
}
