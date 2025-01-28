<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscribedController extends Controller
{
    public function index()
    {
        return view('subscribed');
    }

    public function subscribedMiddleware()
    {
        return view('subscribed-middleware');
    }
}
