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
        $user1 = new User();
        $user1->name = 'Jhon Deo';
        $user1->email = 'tagir@tag.ru';
        $user1->password = bcrypt('secret');
        $user1->save();



        $user2 = new User();
        $user2->name = 'Mike Thomas';
        $user2->email = 'mike@thomas.com';
        $user2->password = bcrypt('secret');
        $user2->save();


        $user3 = new User();
        $user3->name = 'Mike Thomas';
        $user3->email = 'mik1e@thomas.com';
        $user3->password = bcrypt('secret');
        $user3->save();
    }
}
