<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index');
    }

    public function bookings()
    {
        return view('admin.bookings');
    }

    public function customers()
    {
        return view('admin.customers');
    }

    public function staff()
    {
        return view('admin.staff');
    }
    
}
