<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class InvoiceController extends Controller
{
    // index
    public function index()
    { 
        $data['query']= "";
        if(isset($_GET['q']))
        {
            $data['query'] = $_GET['q'];
            $data['invoices'] = DB::table('invoices')
                ->join('students', 'students.id', 'invoices.invoice_by')
                ->select('students.*', 'invoices.*')
                ->where('invoices.active',1)
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->orderBy('invoices.id', 'desc')
                ->where(function($fn){
                    $fn->where('invoices.invoice_ref', 'like', "%{$_GET['q']}%")
                    ->orWhere('invoices.invoice_by', 'like', "%{$_GET['q']}%")
                    ->orWhere('invoices.invoice_date', 'like', "%{$_GET['q']}%")
                    ->orWhere('students.code', 'like', "%{$_GET['q']}%")
                    ->orWhere('invoices.due_date', 'like', "%{$_GET['q']}%");
                })
                ->paginate(18);
        } else {
            $data['invoices'] = DB::table('invoices')
                ->join('students', 'students.id', 'invoices.invoice_by')
                ->select('invoices.*', 'students.english_name', 'students.code')
                ->where('invoices.active',1)
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->orderBy('invoices.id', 'desc')
                ->paginate(18);
        }
        return view('invoices.index', $data);
    }
    public function create()
    {
        return view('invoices.create');
    }
    public function save(Request $r)
    {
        $data = array(
            'invoice_date' => $r->invoice_date,
            'invoice_by' => $r->invoice_by,
            'total_amount' => $r->total_amount,
            'due_amount' => $r->due_amount,
            'due_date' => $r->due_date,
            'invoice_ref' => $r->invoice_ref,
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "Invoice ថ្មីត្រូវបានបង្កើតដោយជោគជ័យ។";
            $sms1 = "មិនអាចបង្កើត Invoice ថ្មីបានទេ សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "The new invoice has been created successfully.";
            $sms1 = "Fail to create the new invoice, please check again!";
        }
        $i = DB::table('invoices')->insertGetId($data);
        $time = date("h:i:sa");
        Right::log(Auth::user()->id,"Add Invoice","insert", $i, "invoices", $time);
        if($i)
        {
            $r->session()->flash('sms', $sms);
            return redirect('/invoice/create');
        }
        else{
            $r->session()->flash('sms1', $sms1);
            return redirect('/invoice/create');
        }
    }
    public function edit($id)
    {
        $data['invoice'] = DB::table('invoices')
            ->where('id', $id)->whereIn('students.branch_id', Right::branch(Auth::user()->id))->first();
        return view('invoices.edit', $data);
    }
    public function detail($id)
    {
        $data['invoice'] = DB::table('invoices')
        ->join('students', 'students.id', 'invoices.invoice_by')
        ->select('invoices.*', 'students.english_name', 'students.code')
        ->where('invoices.active',1)
        ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
        ->where('invoices.id', $id)
        ->first();
        return view('invoices.detail', $data);
    }
    public function update(Request $r)
    {
        $data = array(
            'invoice_date' => $r->invoice_date,
            'invoice_by' => $r->invoice_by,
            'total_amount' => $r->total_amount,
            'due_amount' => $r->due_amount,
            'due_date' => $r->due_date,
            'invoice_ref' => $r->invoice_ref,
        );
        $sms ="";
        $sms1="";
        if(Auth::user()->language=='kh')
        {
            $sms = "ពត៌មាន វិក័យប័ត្រ ត្រូវបានផ្លាស់ប្តូរដោយជោគជ័យ។";
            $sms1 = "វិក័យប័ត្រ មិនអាចផ្លាស់ប្តូរបានទេ, សូមពិនិត្យម្តងទៀត!";
        }
        else
        {
            $sms = "All changes have been saved successfully.";
            $sms1 = "Fail to to save changes, please check again!";
        }
       
            $i = DB::table('invoices')->where('id', $r->id)->update($data);
            $time = date("h:i:sa");
            Right::log(Auth::user()->id,"Update Invoice","update", $r->id, "invoices", $time);
            if($i)
            {
                $r->session()->flash('sms', $sms);
                return redirect('/invoice/edit/'.$r->id);
            }else{
                $r->session()->flash('sms1', $sms1);
                return redirect('/invoice/edit/'.$r->id);
            }
    }
    public function delete($id)
    {
        DB::table('invoices')->where('id', $id)->update(["active"=>0]);
        $time = date("h:i:sa");
        Right::log(Auth::user()->id,"Delete Invoice","delete", $id, "invoices", $time);
        $page = @$_GET['page'];
        if ($page>0)
        {
            return redirect('/invoice?page='.$page);
        }

        return redirect('/invoice');
    }
}
