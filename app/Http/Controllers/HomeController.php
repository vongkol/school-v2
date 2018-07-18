<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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
        $data['students'] = DB::Table('students')
            ->where('active',1)
            ->count();
        $data['staffs'] = DB::Table('staffs')
            ->where('active', 1)
            ->count();
        $data['invoices'] = DB::Table('invoices')
            ->where('active', 1)
            ->count();
        $data['items'] = DB::Table('items')
            ->where('active', 1)
            ->count();
        return view('home', $data);
    }
}
