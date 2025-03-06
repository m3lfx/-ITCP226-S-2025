<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Customer;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 100; $i++) {
            $fname = $faker->firstName();
            $lname = $faker->lastName();
            $user = new User();
            $user->name = $fname . ' ' . $lname;
            $user->email = $faker->freeEmail();

            $user->password = bcrypt('password');
            $user->save();

            $customer = new Customer();
            $customer->title = $faker->randomElement($array = array('ms.', 'mr.', 'miss', 'dr.'));
            $customer->fname = $fname;
            $customer->lname = $lname;
            $customer->addressline = $faker->randomElement($array = array('taguig', 'makati', 'las pinas', 'pasay','muntinlupa', 'pateros'));;
            $customer->town = $faker->city();
            $customer->zipcode = '0000';
            $customer->phone = '091800000';
            $customer->user_id = $user->id;
            $customer->save();
        }
    }
}
