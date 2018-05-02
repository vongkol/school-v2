<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ItemCategoryController extends Controller
{
    // index
    public function index()
    {
        $data['item_categories'] = DB::table('item_categories')->where('active',1)->paginate(18);
        return view('item-categories.index', $data);
    }
    public function create()
    {
        return view('item-categories.create');
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
            $sms = "Item Category ថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើត Item Category ថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new item categoy has been created successfully.";
            $sms1 = "Fail to create the new item category, please check again!";
        }
        $i = DB::table('item_categories')->insert($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/item-category/create');
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/item-category/create')->withInput();
        }
    }
    public function edit($id)
    {
        $data['item_category'] = DB::table('item_categories')->where('id', $id)->first();
        return view('item-categories.edit', $data);
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
            $sms = "ពត៌មាន Item Category ត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "Item Category មិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
        $i = DB::table('item_categories')->where('id', $r->id)->update($data);
        if ($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/item-category/edit/'.$r->id);
        }
        else
        {
            $r->session()->flash('sms1', $sms1);
            return redirect('/item-category/edit/'.$r->id);
        }
    }
    public function delete($id)
    {
        DB::table('item_categories')->where('id', $id)->update(["active"=>0]);
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/item-category?page='.$page);
        }

        return redirect('/item-category');
    }
}
