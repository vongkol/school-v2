<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ItemController extends Controller
{
    // index
    public function index()
    {
        $data['items'] = DB::table('items')
            ->join('branches', 'branches.id', '=', 'items.branch_id')
            ->select('items.*', 'branches.name as branch_id')
            ->where('items.active',1)
            ->orderBy('id', 'desc')
            ->paginate(18);
        return view('items.index', $data);
    }
    public function create()
    {
        return view('items.create');
    }
    public function save(Request $r)
    {
        $data = array(
            'name' => $r->name,
            'item_category_id' => $r->item_category,
            'price' => $r->price,
            'description' => $r->description,
            'tax' => $r->tax,
            'branch_id' => $r->branch,
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "Item ថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើត Item ថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new item has been created successfully.";
            $sms1 = "Fail to create the new item, please check again!";
        }
        $i = DB::table('items')->insertGetId($data);
        $time = date("h:i:sa");
        Right::log(Auth::user()->id,"Add Item","insert", $i, "items", $time);
        if($i)
        {
             // upload photo first
            if($r->hasFile('photo'))
            {
                $file = $r->file('photo');
                $file_name = $i . "-" .$file->getClientOriginalName();
                $destinationPath = 'uploads/items/'; // usually in public folder
                $file->move($destinationPath, $file_name);
                DB::table('items')->where('id', $i)->update(['photo' => $file_name]);
            }
            $r->session()->flash('sms', $sms);
            return redirect('/item/create');
        }
        else{
            $r->session()->flash('sms1', $sms1);
            return redirect('/item/create');
        }
    }
    public function edit($id)
    {
        $data['item'] = DB::table('items')->where('id', $id)->first();
        return view('items.edit', $data);
    }
    public function detail($id)
    {
        $data['item'] = DB::table('items')
            ->leftJoin('item_categories', 'item_categories.id', '=', 'items.item_category_id')
            ->join('branches', 'branches.id', '=', 'items.branch_id')
            ->select('items.*', 'branches.name as branch_id' ,'item_categories.name as item_category')
            ->where('items.id', $id)->first();
        return view('items.detail', $data);
    }
    public function update(Request $r)
    {
        $data = array(
            'name' => $r->name,
            'item_category_id' => $r->item_category,
            'price' => $r->price,
            'description' => $r->description,
            'tax' => $r->tax,
            'branch_id' => $r->branch,
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មាន Item ត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "Item មិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
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
                $destinationPath = 'uploads/items/'; // usually in public folder
                $file->move($destinationPath, $file_name);
                $data['photo'] = $file_name;
            }
            $i = DB::table('items')->where('id', $r->id)->update($data);
            $time = date("h:i:sa");
            Right::log(Auth::user()->id,"Update Items","update", $r->id, "items", $time);
            if($i)
            {
            $r->session()->flash('sms', $sms);
            return redirect('/item/edit/'.$r->id);
            }else{
                $r->session()->flash('sms1', $sms1);
                return redirect('/item/edit/'.$r->id);
            }
    }
    public function delete($id)
    {
        DB::table('items')->where('id', $id)->update(["active"=>0]);
        $time = date("h:i:sa");
        Right::log(Auth::user()->id,"Delete Item","delete", $id, "items", $time);
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/item?page='.$page);
        }

        return redirect('/item');
    }
}
