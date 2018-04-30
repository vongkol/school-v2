<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class SchoolYearController extends Controller
{
    // index
    public function index()
    {
        if(!Right::check('School Year', 'l')){
            return view('permissions.no');
        }
        $data['years'] = DB::table('school_years')->get();
        return view('years.index', $data);
    }
    // load create form
    public function create()
    {
        if(!Right::check('School Year', 'i')){
            return view('permissions.no');
        }
        return view('years.create');
    }
    public function save(Request $r)
    {
        if(!Right::check('School Year', 'i')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ឆ្នាំសិក្សាថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតឆ្នាំសិក្សាថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new school year has been created successfully.";
            $sms1 = "Fail to create the new school year, please check again!";
        }
        $i = DB::table('school_years')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/school-year/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/school-year/create')->withInput();
        }
    }
    public function edit($id)
    {
        if(!Right::check('School Year', 'u')){
            return view('permissions.no');
        }
        $data['year'] = DB::table('school_years')->where('id', $id)->first();
        return view('years.edit', $data);
    }
    public function update(Request $r)
    {
        if(!Right::check('School Year', 'u')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មានឆ្នាំសិក្សាត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "ឆ្នាំសិក្សាមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('school_years')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/school-year/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/school-year/edit/'.$r->id);
        }
    }
    public function delete($id)
    {
        if(!Right::check('School Year', 'd')){
            return view('permissions.no');
        }
        DB::table('school_years')->where('id', $id)->delete();
        return redirect('/school-year');
    }
}
