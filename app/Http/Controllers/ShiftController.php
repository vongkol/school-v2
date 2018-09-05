<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // index
    public function index()
    {
        if(!Right::check('Shift', 'l')){
            return view('permissions.no');
        }
        $data['shifts'] = DB::table('shifts')->where('active',1)->get();
        return view('shifts.index', $data);
    }
    public function create()
    {
        if(!Right::check('Shift', 'i')){
            return view('permissions.no');
        }
        return view('shifts.create');
    }
    public function save(Request $r)
    {
        if(!Right::check('Shift', 'i')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "វេនថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតវេនថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new shift has been created successfully.";
            $sms1 = "Fail to create the new shift, please check again!";
        }
        $i = DB::table('shifts')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/shift/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/shifts/create')->withInput();
        }
    }
    public function edit($id)
    {
        if(!Right::check('Shift', 'u')){
            return view('permissions.no');
        }
        $data['shift'] = DB::table('shifts')->where('id', $id)->first();
        return view('shifts.edit', $data);
    }
    public function update(Request $r)
    {
        if(!Right::check('Shift', 'u')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មានវេនត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "វេនមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('shifts')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/shift/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/shift/edit/'.$r->id);
        }
    }
    public function delete($id)
    {
        if(!Right::check('Shift', 'd')){
            return view('permissions.no');
        }
        DB::table('shifts')->where('id', $id)->update(["active"=>0]);
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/shift?page='.$page);
        }

        return redirect('/shift');
    }
}
