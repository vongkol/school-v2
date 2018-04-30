<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class TestController extends Controller
{
    public function index()
    {
        $data['students'] = DB::table('students')->get();
        return $data;
    }
}
