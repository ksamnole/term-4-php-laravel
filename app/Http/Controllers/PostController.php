<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    function addPost(Request $req)
    {
        $this->validate($req, [
            'text' => 'required|min:5'
        ]);

        $post = new Post();
        $post->text = $req->input('text');
        $post->author = Auth::user()->getUsername();
        $post->save();

        return back();
    }

    function addComment(Request $req)
    {
        $this->validate($req, [
            'text' => 'required|min:5'
        ]);

        $comment = new Comment();
        $comment->text = $req->input('text');
        $comment->author = Auth::user()->getUsername();
        $comment->id_post = $req->input('id_post');;
        $comment->save();

        return back();
    }

    function allPosts()
    {
        $user = Auth::user();
        return view('profile', ['user' => $user, 'posts' => Post::all()->reverse(), 'comments' => Comment::all()]);
    }

    public function like($id)
    {
        $likes_post = Like::all()->where('user', Auth::user()->getUsername())->where('id_post', $id)->where('is_like', 1);;
        $post = Post::all()->find($id);
        if (count($likes_post) == 0) {
            $like = new Like();
            $like->id_post = $id;
            $like->user = Auth::user()->getUsername();
            $like->is_like = 1;
            $like->save();

            $post->likes += 1;
            $post->save();
        } else {
            $likes_post->first()->delete();
            $post->likes -= 1;
            $post->save();
        }


        return back();
    }

    public function dislike($id)
    {
        $dislikes_post = Like::all()->where('user', Auth::user()->getUsername())->where('id_post', $id)->where('is_like', 0);
        $post = Post::all()->find($id);
        if (count($dislikes_post) == 0) {
            $like = new Like();
            $like->id_post = $id;
            $like->user = Auth::user()->getUsername();
            $like->is_like = 0;
            $like->save();

            $post->dislikes += 1;
            $post->save();
        } else {
            $dislikes_post->first()->delete();
            $post->dislikes -= 1;
            $post->save();
        }
        return back();
    }
}