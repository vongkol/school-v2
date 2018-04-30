<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class PrintingController extends Controller
{
    // print all
    public function index()
    {
        $data['students'] = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
            ->where('students.active',1)
                ->select('students.*', 'branches.name as bname')
            ->orderBy('students.english_name')
            ->get();
        $data['total'] = DB::table('students')->where('active', 1)->count();
        $data['male'] = DB::table('students')->where('active',1)->where('gender',"Male")->count();
        $data['female'] = DB::table('students')->where('active',1)->where('gender',"Female")->count();
        return view('printings.list-all', $data);
    }
    public function by_province(Request $r)
    {
        $pro = $r->province;
        $data['students'] = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
            ->where('students.active',1)
                ->where('branches.address', 'like', "%{$pro}%")
                ->select('students.*', 'branches.name as bname')
            ->orderBy('students.english_name')
            ->get();
        $data['total'] = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
               ->where('branches.address', 'like', "%{$pro}%")
                ->where('students.active', 1)->count();
        $data['male'] = DB::table('students')
                 ->join("branches", "students.branch_id", "branches.id")
               ->where('branches.address', 'like', "%{$pro}%")
                ->where('students.active',1)->where('students.gender',"Male")->count();
        $data['female'] = DB::table('students')
                 ->join("branches", "students.branch_id", "branches.id")
               ->where('branches.address', 'like', "%{$pro}%")
                ->where('students.active',1)->where('students.gender',"Female")->count();
        $data['province'] = $pro;
        return view('printings.by-province', $data);
    }
    public function by_school(Request $r)
    {
        $bid = $r->school;
        $branch = DB::table('branches')->where('id', $bid)->first();
        $data['school'] = $branch->name;
        $data['students'] = DB::table('students')
            ->join("branches", "students.branch_id", "branches.id")
            ->where('students.active',1)
            ->where('students.branch_id', $bid)
            ->select('students.*', 'branches.name as bname')
            ->orderBy('students.english_name')
            ->get();
        $data['total'] = DB::table('students')
            ->where('active', 1)
            ->where('branch_id', $bid)->count();
        $data['male'] = DB::table('students')
            ->where('active', 1)
            ->where('gender', "Male")
            ->where('branch_id', $bid)->count();
        $data['female'] = DB::table('students')
            ->where('active', 1)
            ->where('gender', "Female")
            ->where('branch_id', $bid)->count();
        return view('printings.by-school', $data);
    }
}
