<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{

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
        if(Auth::user() !== null){
            $time = date("h:i:sa");
            Right::log(Auth::user()->id,"User Login","login", Auth::user()->id, "users", $time);
        }
        return view('home');
    }
}
