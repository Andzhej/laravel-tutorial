<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Post;
use App\Continent;
use Purifier;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
   
        //filters
        if(request()->has('rating')) {
            $posts = Post::orderBy('rating', 'desc')->paginate(6)->appends('rating', request('rating'));
        } else if(request()->has('title')) {
            $posts = Post::orderBy('title', 'asc')->paginate(6)->appends('title', request('title'));
        } else {
            $posts = Post::orderBy('created_at', 'desc')->paginate(6);
        }

        foreach($posts as $post) {
            //limit by words
            $post['post_excerpt'] = Str::words(strip_tags($post->body), 40);
            //limit by characters
            //$post['post_excerpt'] = Str::limit(strip_tags($post->body), 150); 

            //explode tags to array from string
            $post['tags'] = explode(',', $post->tags);
        }

        //get continents
        $continents = Continent::orderBy('name', 'asc')->get();

        $data = [
            'posts' => $posts,
            'continents' => $continents
        ];

        
        return view('posts.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get continents
        //$continents = Continent::orderBy('name', 'asc')->get();

        $continents = Continent::pluck('name','id')->toArray();
    
        return view('posts.create')->with('continents', $continents);
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
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999',
            'continent' => 'required'
        ]);

        //handle file upload
        if($request->hasFile('cover_image')) {
            //get filename with extension
            $filename_with_ext = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filename_with_ext, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $filename_to_store = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filename_to_store);
        }

        //create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = Purifier::clean($request->input('body'));
        $post->user_id = auth()->user()->id;
        if($request->hasFile('cover_image')) {
            $post->cover_image = $filename_to_store;
        }
        $post->rating = $request->input('rating');
        $post->continent_id = $request->input('continent');
        $post->tags = $request->input('tags');
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        //get next post
        $next = Post::where('id', '>', $id)->first();
        //get prev post
        $prev = Post::where('id', '<', $id)->orderBy('id', 'desc')->first();
        //get random post
        do {
            $random_post = Post::inRandomOrder()->get()->first();
        } while ($random_post->id == $id);

        //get tags
        //explode tags to array from string
        $post['tags'] = explode(',', $post->tags);

        $data = [
            'post' => $post,
            'next' => $next,
            'prev' => $prev,
            'random' => $random_post
        ];
        return view('posts.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //check for correct user
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //get post information
        $post = Post::find($id);

        //handle file upload
        if($request->hasFile('cover_image')) {

            //delete old image
            if($post->cover_image) {
                Storage::delete('public/cover_images/'.$post->cover_image);
            }
  
            //get filename with extension
            $filename_with_ext = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filename_with_ext, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            //filename to store
            $filename_to_store = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $filename_to_store);
        }
        
        //update post
        $post->title = $request->input('title');
        $post->body = Purifier::clean($request->input('body'));
        if($request->hasFile('cover_image')) {
            $post->cover_image = $filename_to_store;
        }
        $post->rating = $request->input('rating');
        $post->tags = $request->input('tags');
        $post->save();

        return redirect('/posts/'.$id)->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        //check for correct user
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized page');
        }

        //delete the image
        if($post->cover_image) {
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted');
    }

    public function continent($id) {
        //query log
        //\DB::enableQueryLog();
        //Continent::find($id)->posts()->latest()->paginate(6)->render();
        //dd(\DB::getQueryLog());

        if(request()->has('rating')) {
            $posts = Continent::find($id)->posts()->orderBy('rating', 'desc')->paginate(6)->appends('rating', request('rating'));
        } else if(request()->has('title')) {
            $posts = Continent::find($id)->posts()->orderBy('title', 'asc')->paginate(6)->appends('title', request('title'));
        } else {
            $posts = Continent::find($id)->posts()->latest()->paginate(6);
        }

        //get continent name
        $selected_continent = Continent::find($id);

        foreach($posts as $post) {
            //limit by words
            $post['post_excerpt'] = Str::words(strip_tags($post->body), 40);
            //limit by characters
            //$post['post_excerpt'] = Str::limit(strip_tags($post->body), 150); 

            //explode tags to array from string
            $post['tags'] = explode(',', $post->tags);
        }

        //get continents
        $continents = Continent::orderBy('name', 'asc')->get();

        $data = [
            'posts' => $posts,
            'continents' => $continents,
            'selected_continent' => $selected_continent,
        ];

        return view('posts.continent')->with($data);
    }
}
