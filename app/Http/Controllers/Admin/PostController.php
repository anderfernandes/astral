<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\Reply;
use Illuminate\Http\Request;

use Session;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('sticky', false)->orderBy('updated_at', 'desc')->get();
        $sticky = Post::where('sticky', true)->orderBy('updated_at', 'desc')->get();
        return view('admin.posts.index')->withPosts($posts)->withSticky($sticky);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->pluck('name', 'id');
        return view('admin.posts.create')->withCategories($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'title'       => 'required',
          'category_id' => 'required',
          'sticky'      => 'required',
          'message'     => 'required',
        ]);

        $post = new Post;

        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->sticky = $request->sticky;
        $post->message = $request->message;
        $post->open = true;
        $post->author_id = Auth::user()->id;

        $post->save();

        Session::flash('success', 'New Post <strong>' . $post->title . '</strong> created successfully!');

        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $replies = Reply::where('post_id', $post->id)->orderBy('created_at', 'desc')->get();
        return view('admin.posts.show')->withPost($post)->withReplies($replies);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name', 'asc')->pluck('name', 'id');
        return view('admin.posts.edit')->withPost($post)->withCategories($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
