<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class StudentEnrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index
    public function index()
    { 
        if(!Right::check('Student Enroll', 'l')){
            return view('permissions.no');
        }
        $data['query']= "";
        if(isset($_GET['q']))
        {
            $data['query'] = $_GET['q'];
            $data['student_enrolls'] = DB::table('registrations')
                ->join('students', 'students.id', 'registrations.student_id')
                ->join('classes','registrations.class_id', "=", "classes.id")
                ->join('school_years', "registrations.year_id", "=", "school_years.id")
                ->join('shifts', 'shifts.id', 'registrations.shift_id')
                ->where("registrations.active", 1)
                ->where('students.active',1)
                ->orderBy('registrations.id', 'desc')
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->where(function($fn){
                    $fn->where('students.code', 'like', "%{$_GET['q']}%")
                    ->orWhere('students.english_name', 'like', "%{$_GET['q']}%")
                    ->orWhere('students.khmer_name', 'like', "%{$_GET['q']}%");
                })
                ->select("students.*", "registrations.id as registration_id", "students.id as student_id","registrations.*", "registrations.id as registration_id", "shifts.*", "shifts.name as shift_name", "classes.name as class_name", "school_years.name as year_name")
                ->paginate(18);
        } else {
        $data['student_enrolls'] = DB::table('registrations')
            ->join('students', 'students.id', 'registrations.student_id')
            ->join('classes','registrations.class_id', "=", "classes.id")
            ->join('school_years', "registrations.year_id", "=", "school_years.id")
            ->join('shifts', 'shifts.id', 'registrations.shift_id')
            ->where("registrations.active", 1)
            ->where('students.active',1)
            ->orderBy('registrations.id', 'desc')
            ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
            ->select("students.*", "registrations.id as registration_id","students.id as student_id","registrations.*", "registrations.id as registration_id", "shifts.*", "shifts.name as shift_name", "classes.name as class_name", "school_years.name as year_name")
            ->paginate(18);
        }
        return view('student-enrolls.index', $data);
    }
    public function create(Request $r)
    {
        if(!Right::check('Student Enroll', 'i')){
            return view('permissions.no');
        }
        $data['classes'] = DB::table('classes')
            ->orderBy('name')
            ->where('active', 1)
            ->get();
        $data['shift'] = DB::table('shifts')
            ->orderBy('id', 'asc')
            ->where('active', 1)
            ->get();
        $data['years'] = DB::table('school_years')
            ->orderBy('id', 'desc')
            ->get();
        $data['students'] = DB::table('students')
            ->orderBy('create_at', 'desc')
            ->where('active', 1)
            ->get();
        return view('student-enrolls.create', $data);
    }
    public function save(Request $r)
    {
        $data = [
            "registration_date" => $r->registration_date,
            'start_date' => $r->start_date,
            'end_date' => $r->end_date,
            'student_id' => $r->student_id,
            'class_id' => $r->class_id,
            'shift_id' => $r->shift_id,
            'study_time' => $r->study_time,
            'year_id' => $r->year_id
        ];
      
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ចុះឈ្មោះសិក្សាថ្នាក់ថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតចុះឈ្មោះថ្នាក់សិក្សាថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The enroll new class has been created successfully.";
            $sms1 = "Fail to create the enroll new class, please check again!";
        }
        $i = DB::table('registrations')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('student-enroll/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('student-enroll/create')->withInput();
        }
    }

    public function delete_student_enroll($id)
    {
        if(!Right::check('Student Enroll', 'd')){
            return view('permissions.no');
        }
        if(Auth::user()==null)
    	{
    		return redirect('/login');
    	}
        DB::table('registrations')->where('id', $id)->update(['active' => 0]);
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/student-enroll?page='.$page);
        }
        return redirect('/student-enroll');
    }
}
