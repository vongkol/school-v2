<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // load report form for student list
    public function index()
    {
        $data['provinces'] = DB::table('branches')->distinct()->get(['address']);
        $data['schools'] = DB::table('branches')->orderBy('name')->get();
        return view("reports.index", $data);
    }
}
