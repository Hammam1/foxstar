<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Mm09876543*')
        ]);
        $user->assignRole('administrator');
		$user->api_token = $user->createToken('MyApp')-> accessToken; 
		$user->save();

    }
}
