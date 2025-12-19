<?php
namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

	public function getAccount(){
		return view('account', ['user'=>Auth::user()]);
		//return view('welcome');
	}

	public function saveAccount(Request $request){
		$user = Auth::user();
		
		$this->validate($request, [
			'name'=>'required|max:60|unique:users,name,' . $user->id,
			'display_name'=> 'required|max:40|unique:users,display_name,' . $user->id,
			'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
		]);

		$user->name = $request['name'];
		$user->display_name = $request['display_name'];
		$user->update();
		$file = $request->file('image');
		if($file && $file->isValid())
		{
			$extension = $file->getClientOriginalExtension();
			$filename = 'user-' . $user->id . '.' . $extension;
			Storage::disk('local')->put($filename, File::get($file));
		}

		return redirect()->route('account');

	}

	public function getUserImage ($filename){
		// Sanitize filename to prevent path traversal attacks
		$filename = basename($filename);
		
		// Validate filename pattern (only allow user images)
		if (!preg_match('/^user-\d+\.(jpg|jpeg|png|gif)$/', $filename)) {
			abort(404);
		}
		
		if (!Storage::disk('local')->exists($filename)) {
			abort(404);
		}
		
		$file = Storage::disk('local')->get($filename);
		return new response($file, 200);
	}

	public function getLogout(){
		Auth::logout();
		return  redirect()->route('home');

	}


}