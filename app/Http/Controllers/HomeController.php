<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news = \App\News::where('status', 'PUBLISH')
            ->count();
        $banner = \App\Banner::where('status', 'PUBLISH')
            ->count();
        $user = \App\User::count();
        return view('home', ['news' => $news, 'user' => $user, 'banner' => $banner]);
    }
}
