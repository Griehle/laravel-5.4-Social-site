<?php
namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{
	public function postSignUp(Request $request){
		$this->validate($request, [
			'email'=>'required|email|unique:users',
			'name'=>'required|max:60',
			'display_name'=>'required|max:40|unique:users',
			'password'=>'required|min:8|max:120'
		]);

		$email = $request['email'];
		$name = $request['name'];
		$display_name = $request['display_name'];
		$password = bcrypt($request['password']);

		$user = new User();
		$user->email = $email;
		$user->name = $name;
		$user->display_name = $display_name;
		$user->password = $password;
		$user->save();
		$user->roles()->attach(Role::where('name','User' )->first());
		Auth::login($user);

		return redirect()->route('dashboard');
	}
	public function postSignin(Request $request){

		$this->validate($request, [
			'email'=>'required',
			'password'=>'required'
		]);

		if (Auth::attempt(['email'=> $request['email'],'password'=> ($request['password'])])){
			return redirect()->route('dashboard');
		}
			return redirect()->back();
	}

}