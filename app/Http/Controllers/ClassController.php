<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index
    public function index()
    {
        if(!Right::check('Class', 'l')){
            return view('permissions.no');
        }
        $data['classes'] = DB::table('classes')
            ->where('active', 1)
            ->orderBy('name')
            ->get();
        return view('classes.index', $data);
    }
    public function create()
    {
        if(!Right::check('Class', 'i')){
            return view('permissions.no');
        }
        return view('classes.create');
    }
    public function save(Request $r)
    {
        if(!Right::check('Class', 'i')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "វគ្គសិក្សាថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតវគ្គសិក្សាថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new class has been created successfully.";
            $sms1 = "Fail to create the new class, please check again!";
        }
        $i = DB::table('classes')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/class/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/class/create')->withInput();
        }
    }
    public function edit($id)
    {
        if(!Right::check('Class', 'u')){
            return view('permissions.no');
        }
        $data['class'] = DB::table('classes')->where('id', $id)->first();
        return view('classes.edit', $data);
    }

    public function detail($id)
    {
        if(!Right::check('Class', 'l')){
            return view('permissions.no');
        }
        $data['class'] = DB::table('classes')->where('id', $id)->first();

        $data['open_classes'] = DB::table('open_classes')->where('class_id' , $id)
            ->where('active', 1)
            ->orderBy('id', 'desc')
            ->paginate(18);

        return view('open-classes.detail', $data);
    }

    public function update(Request $r)
    {
        if(!Right::check('Class', 'u')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មានវគ្គសិក្សាត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "វគ្គសិក្សាមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('classes')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/class/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/class/edit/'.$r->id);
        }
    }
    public function delete($id)
    {
        if(!Right::check('Class', 'd')){
            return view('permissions.no');
        }
        DB::table('classes')->where('id', $id)->update(["active"=>0]);
        return redirect('/class');
    }

    public function get_class($id) {

        $date = DB::table('open_classes')->where('class_id', $id)
            ->orderBy('id', 'desc')
            ->where('active', 1)
            ->get();
        return $date;
    }

    public function get_student_in_class(Request $r) {
            $data['class'] = DB::table('classes')
                ->where('id', $r->class_id)
                ->first();
            $data['students'] = DB::table('registrations')
                ->join('students', 'registrations.student_id', 'students.id')
                ->join('classes', 'registrations.class_id', 'classes.id')
                ->select('students.*', 'students.id as student_id', 'registrations.*')
                ->where('students.active', 1)
                ->whereDate('registrations.start_date' ,'>=' ,$r->start_date)
                ->whereDate('registrations.end_date' ,'<=' ,$r->end_date)
                ->where('registrations.active',1)
                ->where('classes.id', $r->class_id)
                ->where('registrations.active', 1)
                ->orderBy('students.english_name')
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->where('students.active',1)
                ->get();
            $data['total_student_male'] = DB::table('registrations')
                ->join('students', 'registrations.student_id', 'students.id')
                ->join('classes', 'registrations.class_id', 'classes.id')
                ->select('students.*', 'students.id as student_id', 'registrations.*')
                ->where('classes.id', $r->class_id)
                ->where('gender', 'Male')
                ->where('registrations.active', 1)
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->where('students.active', 1)
                ->whereDate('registrations.start_date' ,'>=' ,$r->start_date)
                ->whereDate('registrations.end_date' ,'<=' ,$r->end_date)
                ->orderBy('students.english_name')
                ->where('students.active',1)
                ->count();
            $data['total_student_female'] = DB::table('registrations')
                ->join('students', 'registrations.student_id', 'students.id')
                ->join('classes', 'registrations.class_id', 'classes.id')
                ->select('students.*', 'students.id as student_id', 'registrations.*')
                ->where('classes.id', $r->class_id)
                ->where('gender', 'Female')
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->where('registrations.active', 1)
                ->where('students.active', 1)
                ->whereDate('registrations.start_date' ,'>=' ,$r->start_date)
                ->whereDate('registrations.end_date' ,'<=' ,$r->end_date)
                ->orderBy('students.english_name')
                ->where('students.active',1)
                ->count();
        return view('students.student-in-class', $data);
    }
}
