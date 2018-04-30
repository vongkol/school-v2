<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class BranchController extends Controller
{
    // index
    public function index()
    {
        if(!Right::check('Branch', 'l')){
            return view('permissions.no');
        }
        $data['branches'] = DB::table('branches')->get();
        return view('branches.index', $data);
    }
    // load create form
    public function create()
    {
        if(!Right::check('Branch', 'i')){
            return view('permissions.no');
        }
        return view('branches.create');
    }
    // save new branch
    public function save(Request $r)
    {
        if(!Right::check('Branch', 'i')){
            return view('permissions.no');
        }

        $data = array(
            'name' => $r->name,
            'address' => $r->address
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "សាខាថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតសាខាថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new branch has been created successfully.";
            $sms1 = "Fail to create the new branch, please check again!";
        }
        $i = DB::table('branches')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/branch/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/branch/create')->withInput();
        }
    }
    // delete
    public function delete($id)
    {
        if(!Right::check('Branch', 'd')){
            return view('permissions.no');
        }
        DB::table('branches')->where('id', $id)->delete();
        return redirect('/branch');
    }
    public function edit($id)
    {
        if(!Right::check('Branch', 'u')){
            return view('permissions.no');
        }
        $data['branch'] = DB::table('branches')->where('id', $id)->first();
        return view('branches.edit', $data);
    }
    public function update(Request $r)
    {
        if(!Right::check('Branch', 'u')){
            return view('permissions.no');
        }
        $data = array(
            'name' => $r->name,
            'address' => $r->address
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មានសាខាត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "សាខាមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('branches')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/branch/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/branch/edit/'.$r->id);
        }
    }
    public function test()
    {
        
    }
}
