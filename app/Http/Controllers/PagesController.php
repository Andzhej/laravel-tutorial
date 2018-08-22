<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $title = 'Welcome. To Travel Website!';
        //return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    public function about() {
        $title = 'About';
        return view('pages.about')->with('title', $title);
    }

    public function services() {
        $data = array(
            'title' => 'Our services!',
            'services' => ['Blog post about city', 'Rating', 'User profile']
        );
        return view('pages.services')->with($data);
    }
}
