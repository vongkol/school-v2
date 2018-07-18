<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ProvinceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index
    public function index()
    {
        $data['provinces'] = DB::table('provinces')->orderBy('name')->get();
        return view('provinces.index', $data);
    }
    public function create()
    {
        return view('provinces.create');
    }
      public function save(Request $r)
    {
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ខេត្តក្រុងថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតខេត្តថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new province has been created successfully.";
            $sms1 = "Fail to create the new province, please check again!";
        }
        $i = DB::table('provinces')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/province/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/province/create')->withInput();
        }
    }
     public function update(Request $r)
    {
        $data = array(
            'name' => $r->name
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មានខេត្តក្រុងត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "ពត៌មានខេត្តក្រុងមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('provinces')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/province/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/province/edit/'.$r->id);
        }
    }
    public function edit($id)
    {
        $data['province'] = DB::table('provinces')->where('id', $id)->first();
        return view('provinces.edit', $data);
    }

    public function delete($id)
    {
        DB::table('provinces')->where('id', $id)->delete();
        return redirect('/province');
    }
}
