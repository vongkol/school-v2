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
                ->select('students.*', 'invoices.*', 'invoices.id as id')
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
                ->join('invoice_detials', 'invoice_detials.invoice_id', 'invoices.id')
                ->select('invoices.*', 'invoice_detials.discount', 'students.english_name', 'students.code')
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
        $invoice = json_encode($r->data);
        $invoice = json_decode($invoice);
        $invoices = array();
        for($i=0;$i<count($inovice);$i++)
        {
                $x = array(
                    "invoice_date" => $inovice[$i]->invoice_date,
                    "due_date" => $inovice[$i]->due_date,
                    "inovice_by" => Auth::user()->id,
                    "invoice_ref" => $inovice[$i]->invoice_ref,
                    "customer_id" =>  $inovice[$i]->customer_id,
                );
                $invoices[] = $x;
            
        }
        $i = DB::table('inovices')->insertGetId($invoices);

        $inovic_detail = json_encode($r->data);
        $inovic_detail = json_decode($inovic_detail);
        $invoice_details = array();
        for($i=0;$i<count($inovic_detail); $i++)
        {
                $x = array(
                    'item_id' =>$inovic_detail[$i]->itemid,
                    'discount' => $inovic_detail[$i]->discount,
                    'subtotal' => $inovic_detail[$i]->sub_total,
                    'unit_price' => $inovic_detail[$i]->unit_price,
                    'qty' => $inovic_detail[$i]->qty,
                    "invoice_id" => $i,
                );
                $invoice_details[] = $x;
          
           
        }

        if($i>0)
        {
            // insert edu
            if(count($invoice_detail)>0)
            {
                DB::table("nvoice_detials")->insert($invoice_details);
            }
        }


        return $i;
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
        ->join('invoice_detials', 'invoice_detials.invoice_id', 'invoices.id')
        ->select('invoices.*', 'students.english_name',  'students.code', 'invoice_detials.*')
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

    public function get_item($id) {
        $item  = DB::table('items')->where('id', $id)->first();

        return json_encode($item);
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
