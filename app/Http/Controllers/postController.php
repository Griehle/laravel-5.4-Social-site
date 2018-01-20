<?php

namespace App\Http\Controllers;

use App\Post;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Session;

class postController extends Controller {

	public function getDashboard(){
		$posts = Post::all();
		return view('dashboard', ['posts'=>$posts]);
	}

	public function postCreatePost( Request $request ) {
		$this->validate( $request, [
			'new-post' => 'required|max:1000'
		] );
		$post       = new Post();
		$post->body = $request['new-post'];
		$message    = 'There was an error';
		if ( $request->user()->posts()->save( $post ) ) {
			$message = 'Post successfully created!';
		}

		return redirect()->route( 'dashboard' )->with( [ 'message' => $message ] );
	}

	public function getPostDelete($post_id){
		$post = Post::where('id', $post_id)->first();
		$post->delete();
		return redirect()->route('dashbaord');
	}
}