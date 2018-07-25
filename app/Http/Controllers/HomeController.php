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
        $data['classes'] = DB::Table('classes')
            ->where('active',1)
            ->where('status', 1)
            ->get();
        
        return view('home', $data);
    }

    public function student_by_class($id) {
        $data['class'] = DB::table('classes')
            ->where('id', $id)
            ->first();
        $data['shifts'] = DB::table('shifts')
            ->where('active',1)
            ->get();
        $data['query']= "";
            if(isset($_GET['q']))
            {
                $data['query'] = $_GET['q'];
                $data['students'] = DB::table('registrations')
                    ->join('students', 'registrations.student_id', 'students.id')
                    ->join('classes', 'registrations.class_id', 'classes.id')
                    ->select('students.*', 'students.id as student_id', 'registrations.*')
                    ->where('classes.id', $id)
                    ->where('registrations.active', 1)
                    ->where('registrations.enroll',1)
                    ->orderBy('students.english_name')
                    ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                    ->where('students.active',1)
                    ->where(function($fn){
                        $fn->where('registrations.shift_id', 'like', "%{$_GET['q']}%");
                    })
                    ->get();
                    $data['total_student_male'] = DB::table('registrations')
                        ->join('students', 'registrations.student_id', 'students.id')
                        ->join('classes', 'registrations.class_id', 'classes.id')
                        ->select('students.*', 'students.id as student_id', 'registrations.*')
                        ->where('classes.id', $id)
                        ->where('gender', 'Male')
                        ->where('registrations.active', 1)
                        ->where('registrations.enroll',1)
                        ->orderBy('students.english_name')
                        ->where('students.active',1)
                        ->where(function($fn){
                            $fn->where('registrations.shift_id', 'like', "%{$_GET['q']}%");

                        })
                        ->count();
                    $data['total_student_female'] = DB::table('registrations')
                        ->join('students', 'registrations.student_id', 'students.id')
                        ->join('classes', 'registrations.class_id', 'classes.id')
                        ->select('students.*', 'students.id as student_id', 'registrations.*')
                        ->where('classes.id', $id)
                        ->where('gender', 'Female')
                        ->where('registrations.active', 1)
                        ->where('registrations.enroll',1)
                        ->orderBy('students.english_name')
                        ->where('students.active',1)
                        ->where(function($fn){
                            $fn->where('registrations.shift_id', 'like', "%{$_GET['q']}%");

                        })
                        ->count();
                        
            } else {
                $data['students'] = DB::table('registrations')
                    ->join('students', 'registrations.student_id', 'students.id')
                    ->join('classes', 'registrations.class_id', 'classes.id')
                    ->select('students.*', 'students.id as student_id', 'registrations.*')
                    ->where('classes.id', $id)
                    ->where('registrations.active', 1)
                    ->where('registrations.enroll',1)
                    ->orderBy('students.english_name')
                    ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                    ->where('students.active',1)
                    ->get();
                $data['total_student_male'] = DB::table('registrations')
                    ->join('students', 'registrations.student_id', 'students.id')
                    ->join('classes', 'registrations.class_id', 'classes.id')
                    ->select('students.*', 'students.id as student_id', 'registrations.*')
                    ->where('classes.id', $id)
                    ->where('gender', 'Male')
                    ->where('registrations.active', 1)
                    ->where('registrations.enroll',1)
                    ->orderBy('students.english_name')
                    ->where('students.active',1)
                    ->count();
                $data['total_student_female'] = DB::table('registrations')
                    ->join('students', 'registrations.student_id', 'students.id')
                    ->join('classes', 'registrations.class_id', 'classes.id')
                    ->select('students.*', 'students.id as student_id', 'registrations.*')
                    ->where('classes.id', $id)
                    ->where('gender', 'Female')
                    ->where('registrations.active', 1)
                    ->where('registrations.enroll',1)
                    ->orderBy('students.english_name')
                    ->where('students.active',1)
                    ->count();
            }
        return view('students.student-by-class', $data);
    }
}
