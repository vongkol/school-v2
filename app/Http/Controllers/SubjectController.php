<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index
    public function index()
    {
        if(!Right::check('Subject', 'l')){
            return view('permissions.no');
        }
        $data['subjects'] = DB::table('subjects')->get();
        return view('subjects.index', $data);
    }
    public function create()
    {
        if(!Right::check('Subject', 'i')){
            return view('permissions.no');
        }
        return view('subjects.create');
    }
    public function save(Request $r)
    {
        if(!Right::check('Subject', 'i')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "មុខវិជ្ជាថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតមុខវិជ្ជាថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new subject has been created successfully.";
            $sms1 = "Fail to create the new subject, please check again!";
        }
        $i = DB::table('subjects')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/subject/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/subject/create')->withInput();
        }
    }
    public function edit($id)
    {
        if(!Right::check('Subject', 'u')){
            return view('permissions.no');
        }
        $data['subject'] = DB::table('subjects')->where('id', $id)->first();
        return view('subjects.edit', $data);
    }
    public function update(Request $r)
    {
        if(!Right::check('Subject', 'u')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មានមុខវិជ្ជាសិក្សាសិក្សាត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "ពត៌មានមុខវិជ្ជាសិក្សាមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('subjects')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/subject/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/subject/edit/'.$r->id);
        }
    }
    public function delete($id)
    {
        if(!Right::check('Subject', 'd')){
            return view('permissions.no');
        }
        DB::table('subjects')->where('id', $id)->delete();
        return redirect('/subject');
    }
}
