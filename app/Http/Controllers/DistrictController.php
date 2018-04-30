<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class DistrictController extends Controller
{
    // index
    public function index()
    {
        $data['districts'] = DB::table('districts')->join('provinces', 'districts.province_id', '=', 'provinces.id')
                            ->orderBy('districts.name')->select('districts.*', 'provinces.name as province_name')
                            ->paginate(18);
        return view('districts.index', $data);
    }
    public function create()
    {
        $data['provinces'] = DB::table('provinces')->orderBy('name')->get();
        return view('districts.create', $data);
    }
    public function show($id)
    {

    }
    public function store(Request $r)
    {
        $data = [
            'name' => $r->name,
            'province_id' => $r->province_id
        ];
          $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ស្រុកខណ្ឌថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើតស្រុកខណ្ឌថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "New district has been created successfully.";
            $sms1 = "Fail to create new district, please check again!";
        }
        $i = DB::table('districts')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/district/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/district/create')->withInput();
        }
    }
    public function edit($id)
    {
        $data['district'] = DB::table('districts')->where('id', $id)->first();
        $data['provinces'] = DB::table('provinces')->orderBy('name')->get();
        return view('districts.edit', $data);
    }
    public function update(Request $r)
    {
         $data = array(
            'name' => $r->name,
            'province_id' => $r->province_id
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ព័ត៌មានស្រុកខណ្ឌត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "ព័ត៌មានស្រុកខណ្ឌមិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('districts')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/district/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/district/edit/'.$r->id);
        }
    }
    public function destroy($id)
    {
        DB::table('districts')->where('id', $id)->delete();
        return redirect('/district');
    }
    // get district by province id
    public function getDistrict($id)
    {
        $districts = DB::table('districts')->where('province_id', $id)->orderBy('name')->get();
        return $districts;
    }
}
