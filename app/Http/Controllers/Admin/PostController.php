<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected $validation = [
        "date" => "required|date",
        "content" => "required|string",
        "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048"
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view("admin.posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();

        return view("admin.posts.create", compact("tags"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $this->validation;
        $validation["title"] = "required|string|max:255|unique:posts";

        // Validating
        $request->validate($validation);

        $data = $request->all();

        // Checking checkbox
        $data["published"] = !isset($data["published"]) ? 0 : 1;

        // Setting the slug starting from the title
        $data["slug"] = Str::slug($data["title"], "-");

        // Uploading file image
        if (isset($data["image"])) {
            $data["image"] = Storage::disk("public")->put("images", $data["image"]);
        }

        // Inserting
        $newPost = Post::create($data);

        // Adding tags
        if (isset($data["tags"])) {
            $newPost->tags()->attach($data["tags"]);
        }

        // Redirecting
        return redirect()->route("admin.posts.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();

        return view("admin.posts.edit", compact("post", "tags"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validation = $this->validation;
        $validation["title"] = "required|string|max:255|unique:posts,title," . $post->id;

        // Validating
        $request->validate($validation);

        $data = $request->all();

        // Checking checkbox
        $data["published"] = !isset($data["published"]) ? 0 : 1;

        // Setting the slug starting from the title
        $data["slug"] = Str::slug($data["title"], "-");

        // Uploading file image
        if (isset($data["image"])) {
            $data["image"] = Storage::disk("public")->put("images", $data["image"]);
        }

        // Update
        $post->update($data);

        // Updating tags
        if (!isset($data["tags"])) {
            $data["tags"] = [];
        }

        $post->tags()->sync($data["tags"]);

        // Redirecting
        return redirect()->route("admin.posts.show", $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route("admin.posts.index")->with("message", "The post was successfully deleted! ");
    }
}
