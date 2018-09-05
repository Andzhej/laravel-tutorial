<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use App\Post;
use App\Continent;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'get_user_posts']);
    }

    public function index()
    {
        $user = User::find(auth()->user()->id);
        return view('pages.user-profile')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'profile_picture' => 'image|nullable|max:1999'
        ]);

        $user = User::find($id);
        //handle file upload
        if($request->hasFile('profile_picture')) {

            //delete old image if exists
            if($user->profile_picture) {
                Storage::delete('public/profile_pictures/'.$user->profile_picture);
            }

            //get filename with extension
            $filename_with_ext = $request->file('profile_picture')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filename_with_ext, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('profile_picture')->getClientOriginalExtension();
            //filename to store
            $filename_to_store = $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('profile_picture')->storeAs('public/profile_pictures', $filename_to_store);
        }

        //update user profile
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        if($request->hasFile('profile_picture')) {
            $user->profile_picture = $filename_to_store;
        }
        $user->birthday = $request->input('birthday');
        $user->save();

        return redirect('user/user-profile')->with('success', 'User information updated');
    }

    public function get_user_posts($id) {
        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->paginate(6);
        //get continents
        $continents = Continent::orderBy('name', 'asc')->get();

        //get most popular posts
        $popular = Post::where('rating', 5)->orderBy('created_at', 'desc')->limit(5)->get();

        foreach($posts as $post) {
            //limit by words
            $post['post_excerpt'] = Str::words(strip_tags($post->body), 40);
            //limit by characters
            //$post['post_excerpt'] = Str::limit(strip_tags($post->body), 150); 

            //explode tags to array from string
            $post['tags'] = explode(',', $post->tags);
        }

        //get authors and their post count
        $author_posts = User::get();

        $data = [
            'posts' => $posts,
            'continents' => $continents,
            'popular_posts' => $popular,
            'author_posts' => $author_posts
        ];
        return view('posts.index')->with($data);
    }
}
