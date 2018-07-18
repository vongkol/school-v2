<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index
    public function index()
    {
        $data['staffs'] = DB::table('staffs')
            ->join('positions', 'positions.id', '=', 'staffs.position_id')
            ->join('branches', 'branches.id', '=', 'staffs.branch_id')
            ->select('staffs.*', 'branches.name as branch_id', 'positions.name as position_id')
            ->where('staffs.active',1)
            ->paginate(18);
        return view('staffs.index', $data);
    }
    public function create()
    {
        return view('staffs.create');
    }
    public function save(Request $r)
    {
        $data = array(
            'first_name' => $r->first_name,
            'family_name' => $r->family_name,
            'gender' => $r->gender,
            'dob' => $r->dob,
            'pob' => $r->pob,
            'current_address' => $r->current_address,
            'email' => $r->email,
            'phone' => $r->phone,
            'position_id' => $r->position,
            'join_date' => $r->join_date,
            'nationality' => $r->nationality,
            'salary' => $r->salary,
             'branch_id' => $r->branch,
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "បុគ្គលិកថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតបុគ្គលិកថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new staff has been created successfully.";
            $sms1 = "Fail to create the new staff, please check again!";
        }
        $i = DB::table('staffs')->insertGetId($data);
        $time = date("h:i:sa");
        Right::log(Auth::user()->id,"Add Staff","insert", $i, "staffs", $time);
        if($i)
        {
             // upload photo first
            if($r->hasFile('photo'))
            {
                $file = $r->file('photo');
                $file_name = $i . "-" .$file->getClientOriginalName();
                $destinationPath = 'staffs/'; // usually in public folder
                $file->move($destinationPath, $file_name);
                DB::table('staffs')->where('id', $i)->update(['photo' => $file_name]);
            }
            $r->session()->flash('sms', $sms);
            return redirect('/staff/detail/'.$i);
        }
        else{
            $r->session()->flash('sms1', $sms1);
            return redirect('/staff/create');
        }
    }
    public function edit($id)
    {
        $data['staff'] = DB::table('staffs')->where('id', $id)->first();
        return view('staffs.edit', $data);
    }
    public function detail($id)
    {
        $data['staff'] = DB::table('staffs')->where('id', $id)->first();
        $data['documents'] = DB::table('staff_documents')
            ->where('active', 1)
            ->where('staff_id', $id)
            ->get();
        return view('staffs.detail', $data);
    }
    public function update(Request $r)
    {
        $data = array(
            'first_name' => $r->first_name,
            'family_name' => $r->family_name,
            'gender' => $r->gender,
            'dob' => $r->dob,
            'pob' => $r->pob,
            'current_address' => $r->current_address,
            'email' => $r->email,
            'phone' => $r->phone,
            'position_id' => $r->position,
            'join_date' => $r->join_date,
            'nationality' => $r->nationality,
            'salary' => $r->salary,
            'branch_id' => $r->branch,
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មានបុគ្គលិកត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "បុគ្គលិកមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
       
   
             // upload photo first
            if($r->hasFile('photo'))
            {
                $file = $r->file('photo');
                $file_name = $r->id . "-" .$file->getClientOriginalName();
                $destinationPath = 'staffs/'; // usually in public folder
                $file->move($destinationPath, $file_name);
                $data['photo'] = $file_name;
            }
            $i = DB::table('staffs')->where('id', $r->id)->update($data);
            $time = date("h:i:sa");
            Right::log(Auth::user()->id,"Update Staff","update", $r->id, "staffs", $time);
            if($i)
            {
            $r->session()->flash('sms', $sms);
            return redirect('/staff/edit/'.$r->id);
            }else{
                $r->session()->flash('sms1', $sms1);
                return redirect('/staff/edit/'.$r->id);
            }
    }
    public function delete($id)
    {
        DB::table('staffs')->where('id', $id)->update(["active"=>0]);
        $time = date("h:i:sa");
        Right::log(Auth::user()->id,"Delete Staff","delete", $id, "staffs", $time);
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/staff?page='.$page);
        }

        return redirect('/staff');
    }
}
