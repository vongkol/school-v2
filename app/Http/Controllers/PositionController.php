<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class PositionController extends Controller
{
    // index
    public function index()
    {
        $data['positions'] = DB::table('positions')->where('active',1)
        ->paginate(20);
        return view('positions.index', $data);
    }
    public function create()
    {
        return view('positions.create');
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
            $sms = "តួនាទីថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតតួនាទីថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new position has been created successfully.";
            $sms1 = "Fail to create the new position, please check again!";
        }
        $i = DB::table('positions')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/position/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/position/create')->withInput();
        }
    }
    public function edit($id)
    {
        $data['position'] = DB::table('positions')->where('id', $id)->first();
        return view('positions.edit', $data);
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
            $sms = "ពត៌មានតួនាទីត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "តួនាទីមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('positions')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/position/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/position/edit/'.$r->id);
        }
    }
    public function delete($id)
    {
        DB::table('positions')->where('id', $id)->update(["active"=>0]);
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/position?page='.$page);
        }

        return redirect('/position');
    }
}
