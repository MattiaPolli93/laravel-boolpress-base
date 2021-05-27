<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Comment;
use App\Tag;

class BlogController extends Controller
{
    public function index()
    {
        // Accessing data from db
        $posts = Post::where("published", 1)->orderBy("date", "desc")->get();
        $tags = Tag::all();

        // Returning homepage
        return view("guest.index", compact("posts", "tags"));
    }

    public function show($slug)
    {
        // Accessing data from db
        $post = Post::where("slug", $slug)->first();
        $tags = Tag::all();

        if ($post == null) {
            abort(404);
        }

        // Returning post page
        return view("guest.show", compact("post", "tags"));
    }

    public function filterTag($slug)
    {
        $tags = Tag::all();

        $tag = Tag::where("slug", $slug)->first();
        if ($tag == null) {
            abort(404);
        }

        $posts = $tag->posts()->where("published", 1)->get();

        // Returning homepage
        return view("guest.index", compact("posts", "tags"));
    }

    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            "name" => "nullable|string|max:100",
            "content" => "required|string",
        ]);

        $newComment = new Comment();
        $newComment->name = $request->name;
        $newComment->content = $request->content;
        $newComment->post_id = $post->id;

        $newComment->save();

        return back();
    }
}