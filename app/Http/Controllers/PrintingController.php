<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class PrintingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // print all
    public function index()
    {
        $data['user_brand'] = Right::branch(Auth::user()->id);
        $data['students'] = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->where('students.active',1)
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->select('students.*', 'branches.name as bname')
            ->orderBy('students.english_name')
            ->get();
        $data['total'] = DB::table('students')
        ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
        ->where('active', 1)->count();
        $data['male'] = DB::table('students')
        ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
        ->where('active',1)->where('gender',"Male")->count();
        $data['female'] = DB::table('students')
        ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
        ->where('active',1)->where('gender',"Female")->count();
        return view('printings.list-all', $data);
    }
    public function by_receptionist(Request $r)
    {
        $data['user_brand'] = Right::branch(Auth::user()->id);
        $data['receptionist'] = $r->receptionist;   
        $data['start_date'] = $r->start_date;
        $data['end_date'] = $r->end_date;
        if($r->receptionist !== null ){
            $data['recept'] = DB::table('users')
            ->where('id', $r->receptionist)
            ->first();
        } else {
            $data['recept'] = DB::table('users')
            ->where('role_id', 2)
            ->where('id', $r->class)
            ->first();
        }
      
        return view('printings.by-receptionist', $data);
    }
    public function by_class(Request $r)
    {
        $data['class'] = $r->class;   
        $data['start_date'] = $r->start_date;
        $data['end_date'] = $r->end_date;
        if($r->class !== null ){
            $data['classes'] = DB::table('classes')
            ->where('id', $r->class)
            ->first();
        } else {
            $data['classes'] = DB::table('classes')
                ->where('id', $r->class)
                ->first();
        }
        return view('printings.by-class', $data);
    }
}
