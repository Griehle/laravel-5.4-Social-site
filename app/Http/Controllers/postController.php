<?php

namespace App\Http\Controllers;

use App\likes;
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
		if (!$post) {
			return redirect()->route('dashboard')->with(['message'=>'Post not found']);
		}
		if (Auth::user()->id != $post->user->id){
			return redirect()->back();
		}
		$post->delete();
		return redirect()->route('dashboard')->with(['message'=>'Successfully deleted']);
	}

	public function postEditPost(Request $request){
		$this->validate($request,[
			'body'=>'required|max:1000',
			'postId'=>'required|integer|exists:posts,id'
		]);
		$post = Post::find($request['postId']);
		if (!$post) {
			return response()->json(['error' => 'Post not found'], 404);
		}
		if (Auth::user()->id != $post->user->id){
			return response()->json(['error' => 'Unauthorized'], 403);
		}

		$post->body = $request['body'];
		$post->update();
		return response()->json(['new_body' => $post->body], 200);
	}

	public function postLikePost(Request $request){
		$this->validate($request,[
			'postId'=>'required|integer|exists:posts,id',
			'isLike'=>'required|in:true,false'
		]);
		
		$post_id = $request['postId'];
		$is_like = $request['isLike'] === 'true' ? true: false;
		$update = false;
		$post = Post::find($post_id);
		if(!$post){
			return response()->json(['error' => 'Post not found'], 404);
		}

		$user = Auth::user();
		$like = $user->likes()->where('post_id', $post_id )->first();

		if ($like){
			$like_value = $like->likes;
			$update = true;
			if($like_value == $is_like) {
				$like->delete();
				return response()->json(['status' => 'removed'], 200);
			}
		}else{
			$like = new likes();
		}
		$like->likes = $is_like;
		$like->user_id = $user->id;
		$like->post_id = $post->id;
		if($update){
			$like->update();
		}else{
			$like->save();
		}
		return response()->json(['status' => 'success'], 200);
	}
}