<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class BlogController extends Controller
{
    public function index()
    {
        // Accessing data from db
        $posts = Post::where("published", 1)->orderBy("date", "desc")->limit(5)->get();

        // Returning homepage
        return view("guest.index", compact("posts"));
    }

    public function show($slug)
    {
        // Accessing data from db
        $post = Post::where("slug", $slug)->first();

        if ($post == null) {
            abort(404);
        }

        // Returning post page
        return view("guest.show", compact("post"));
    }
}