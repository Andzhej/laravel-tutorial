<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContinentsController extends Controller
{
    public function get_continents() {
        return view('posts.index');
    }
}
