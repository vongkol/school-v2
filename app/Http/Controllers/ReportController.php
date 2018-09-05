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
        $data['receptionists'] = DB::table('users')->where('role_id', 2)->get();
        $data['classes'] = DB::table('classes')->orderBy('name')->get();
        $data['open_classes'] = DB::table('open_classes')->orderBy('id', 'desc')->where('active', 1)->get();
        return view("reports.index", $data);
    }
}
