<?php

use Illuminate\Database\Seeder;

use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	    $role_user = Role::where('name', 'User')->first();
	    $role_author = Role::where('name', 'Author')->first();
	    $role_admin = Role::where('name', 'Admin')->first();

	    $user = new User();
	    $user->name = 'Gary';
	    $user->display_name = 'Techno-hippie';
	    $user->email = 'briahsdad@yahoo.com';
	    $user->password = bcrypt('Beast616!');
	    $user->save();
	    $user->roles()->attach($role_user);

	    $author = new User();
	    $author->name = 'Jesse';
	    $author->display_name = 'STOI2M';
	    $author->email = 'stoi2m@yahoo.com';
	    $author->password = bcrypt('password');
	    $author->save();
	    $author->roles()->attach($role_author);

	    $admin = new User();
	    $admin->name = 'JeshL';
	    $admin->display_name = 'JeshL';
	    $admin->email = 'test@test.com';
	    $admin->password = bcrypt('password');
	    $admin->save();
	    $admin->roles()->attach($role_admin);
    }
}
