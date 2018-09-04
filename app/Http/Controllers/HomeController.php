<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id)->posts()->latest()->paginate(8);
        $data = [
            'posts' => $user
        ];
        return view('home')->with($data);
    }

    public function search(Request $request) {
        if($request->has('title')) {
            $user_id = auth()->user()->id;
            $user = User::find($user_id)->posts()->where('title', 'like', '%'.$request->input('title').'%')->latest()->paginate(8);
        }

        $data = [
            'posts' => $user,
            'search_title' => $request->input('title')
        ];

        return view('home')->with($data);
    }

}
