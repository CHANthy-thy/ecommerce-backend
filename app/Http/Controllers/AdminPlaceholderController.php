<?php

namespace App\Http\Controllers;

class AdminPlaceholderController extends Controller
{
    public function products()
    {
        return view('admin.products.index');
    }

    public function orders()
    {
        return view('admin.orders.index');
    }

    public function users()
    {
        return view('admin.users.index');
    }
}

