<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
class StudentController extends Controller
{
    // index load student list
    public function index()
    {
    	if(Auth::user()==null)
    	{
    		return redirect('/login');
    	}
        if(!Right::check('Student', 'l')){
            return view('permissions.no');
        }
        $data['query']= "";
        if(isset($_GET['q']))
        {
            $data['query'] = $_GET['q'];
            $data['students'] = DB::table('students')
                ->join('branches', 'students.branch_id', '=', 'branches.id')
                ->select('students.*', 'branches.name as branch_name')
                ->where('active',1)
                ->orderBy('id', 'desc')
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->where(function($fn){
                    $fn->where('students.code', 'like', "%{$_GET['q']}%")
                    ->orWhere('students.english_name', 'like', "%{$_GET['q']}%")
                    ->orWhere('students.khmer_name', 'like', "%{$_GET['q']}%");
                })
                ->paginate(18);
        }
        else{
            $data['students'] = DB::table('students')
                ->join('branches', 'students.branch_id', '=', 'branches.id')
                ->select('students.*', 'branches.name as branch_name')
                ->where('active',1)
                ->orderBy('id', 'desc')
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->paginate(18); 
        }
      
        return view('students.index', $data);
    }
    public function create()
    {
    	if(Auth::user()==null)
    	{
    		return redirect('/login');
    	}
        if(!Right::check('Student', 'i')){
            return view('permissions.no');
        }
        $data['branches'] = DB::table('branches')->whereIn('id', Right::branch(Auth::user()->id))->orderBy('name')->get();
        return view('students.create', $data);
    }
    public function save(Request $r)
    {
    	if(Auth::user()==null)
    	{
    		return redirect('/login');
    	}
        if(!Right::check('Student', 'i')){
            return view('permissions.no');
        }
        $data = [
            'code' => $r->code,
            'english_name' => $r->english_name,
            'khmer_name' => $r->khmer_name,
            'gender' => $r->gender,
            'pob' => $r->pob,
            'dob' => $r->dob,
            'phone' => $r->phone,
            'address' => $r->current_address,
            'email' => $r->email,
            'branch_id' => $r->branch
        ];
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms1 = "មិនអាចបង្កើតសិស្សថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
            
        }
        else
        {
            $sms1 = "Fail to create the new student, please check again!";
        }
        $time = date("h:i:sa");
        $i = DB::table('students')->insertGetId($data);
        Right::log(Auth::user()->id,"Add Student","insert", $i, "students",$time);
        if($i)
        {
             // upload photo first
            if($r->hasFile('photo'))
            {
                $file = $r->file('photo');
                $file_name = $i . "-" .$file->getClientOriginalName();
                $destinationPath = 'photo/'; // usually in public folder
                $file->move($destinationPath, $file_name);
                DB::table('students')->where('id', $i)->update(['photo' => $file_name]);
            }
            return redirect('/student/detail/'.$i);
        }
        else{
            $r->session()->flash('sms1', $sms1);
            return redirect('/student/create');
        }
    }
    public function update(Request $r)
    {
    	if(Auth::user()==null)
    	{
    		return redirect('/login');
    	}
        $data = [
            'code' => $r->code,
            'english_name' => $r->english_name,
            'khmer_name' => $r->khmer_name,
            'gender' => $r->gender,
            'pob' => $r->pob,
            'dob' => $r->dob,
            'phone' => $r->phone,
            'email' => $r->email,
            'address' => $r->address,
            'branch_id' => $r->branch_id
        ];
        // upload photo first
        if($r->hasFile('photo'))
        {
            $file = $r->file('photo');
            $file_name = $r->student_id . "-" .$file->getClientOriginalName();
            $destinationPath = 'photo/'; // usually in public folder
            $file->move($destinationPath, $file_name);
            $data['photo'] = $file_name;
        }

        $time = date("h:i:sa");
        $i = DB::table('students')->where('id', $r->student_id)->update($data);
        Right::log(Auth::user()->id,"Update Student","update", $r->student_id, "students", $time);
        if($i)
        {
            return 'ok';
        }
        else{
            return 'no';
        }
    }
    public function detail($id)
    {
    	if(Auth::user()==null)
    	{
    		return redirect('/login');
    	}
        if(!Right::check('Student', 'l')){
            return view('permissions.no');
        }
        $data['branches'] = DB::table('branches')
                            ->whereIn('id', Right::branch(Auth::user()->id))
                            ->orderBy('name')
                            ->get();
        $data['student'] = DB::table('students')
                            ->where('id', $id)
                            ->first();
        $data['families'] = DB::table('families')
                            ->where('active', 1)
                            ->where('student_id', $id)
                            ->get();
        $data['documents'] = DB::table('documents')
                            ->where('active', 1)
                            ->where('student_id', $id)
                            ->get();
        $data['healths'] = DB::table('healths')->where('student_id', $id)
                            ->where('active', 1)
                            ->get();
        $data['classes'] = DB::table('classes')
                            ->orderBy('name')
                            ->get();
        $data['years'] = DB::table('school_years')
                            ->orderBy('name')
                            ->get();
        $data['registrations'] = DB::table('registrations')
                                ->join('classes','registrations.class_id', "=", "classes.id")
                                ->join('school_years', "registrations.year_id", "=", "school_years.id")
                                ->where("registrations.active", 1)
                                ->where("registrations.student_id", $id)
                                ->select("registrations.*", "classes.name as class_name", "school_years.name as year_name")
                                ->get();
        return view('students.detail', $data);
    }
    public function delete($id)
    {
        if(Auth::user()==null)
    	{
    		return redirect('/login');
    	}
        if(!Right::check('Student', 'd')){
            return view('permissions.no');
        }
        $data = ['active'=>0];
        $time = date("h:i:sa");
        DB::table('students')->where('id', $id)->update($data);
        Right::log(Auth::user()->id,"Delete Student","delete", $id, "students", $time);
        return redirect('/student');
        
    }
}
