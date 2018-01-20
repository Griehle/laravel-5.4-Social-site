<?php

use Illuminate\Database\Seeder;
use App\Role;


class roleUsersTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new role();
		    $role_user->name = 'User';
		    $role_user->description = 'A Normal User';
		    $role_user->save();

	    $role_author = new role();
		    $role_author->name = 'Author';
		    $role_author->description = 'A Author';
		    $role_author->save();

	    $role_admin = new role();
		    $role_admin->name = 'Admin';
		    $role_admin->description = 'A Admin';
		    $role_admin->save();
    }
}
