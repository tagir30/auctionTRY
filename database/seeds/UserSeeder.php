<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create();

        $user1 = new User();
        $user1->name = 'Tagir';
        $user1->email = 'tagir@tag.ru';
        $user1->password = bcrypt('secret');
        $user1->save();

    }
}
