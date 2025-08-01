<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('front.index');
    }

    public function about()
    {
        return view('front.about');
    }

    public function services()
    {
        return view('front.services');
    }

    public function gallery()
    {
        return view('front.gallery');
    }   

    public function contact()
    {
        return view('front.contact');
    }

    public function book()
    {
        return view('front.book');
    }

    public function confirmation()
    {
        return view('front.confirmation');
    }
    
}
