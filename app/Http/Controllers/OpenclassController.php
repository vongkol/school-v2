<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class OpenclassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $r)
    {
        if(!Right::check('Class', 'i')){
            return view('permissions.no');
        }
        $data = array(
            'class_id' => $r->id,
            'start_date' => $r->start_date,
            'end_date' => $r->end_date
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
            $sms = "The open new class has been created successfully.";
            $sms1 = "Fail to create the open new class, please check again!";
        }
        $i = DB::table('open_classes')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/class/detail/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/class/detail/'.$r->id)->withInput();
        }
    }
    public function edit($id)
    {
        if(!Right::check('Class', 'u')){
            return view('permissions.no');
        }

        $data['open_class'] = DB::table('open_classes')->where('id', $id)->first();
        $data['class'] = DB::table('classes')->where('id', $data['open_class']->class_id)->first();
        return view('open-classes.edit', $data);
    }

    public function update(Request $r)
    {
        if(!Right::check('Class', 'u')){
            return view('permissions.no');
        }
        $data = array(
            'start_date' => $r->start_date,
            'end_date' => $r->end_date
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
        $i = DB::table('open_classes')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/open-class/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/open-class/edit/'.$r->id);
        }
    }
    public function delete($id)
    {
        if(!Right::check('Class', 'd')){
            return view('permissions.no');
        }
       
        DB::table('open_classes')->where('id', $id)->update(["active"=>0]);
        $class_id = DB::table('open_classes')->select('class_id')->where('id', $id)->first();
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/class/detail/'.$class_id->class_id.'?page='.$page);
        }
        return redirect('/class/detail/'.$class_id->class_id);
    }

}
