<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Auth;
use http\Env\Response;
use Illuminate\Http\Request;


//use Illuminate\Support\Facades\Session;


class postController extends Controller {


	public function getDashboard(){
		$posts = Post::orderBy('created_at', 'desc')->get();
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
		if (Auth::user() != $post->user){
			return redirect()->back();
		}
		$post->delete();
		return redirect()->route('dashboard')->with(['message'=>'Successfully deleted']);
	}

	public function postEditPost(Request $request){
		$this->validate($request,[
			'body'=>'required'
		]);
		$post = Post::find($request['postId']);
		if (Auth::user() != $post->user){
			return redirect()->back();
		}

		$post->body = $request['body'];
		$post->update();
		return response()->json(['new_body' => $post->body], 200);
	}
}