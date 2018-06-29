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
                ->join('students', 'students.id', 'invoices.customer_id')
                ->select('students.*', 'invoices.*', 'invoices.id as id')
                ->where('invoices.active',1)
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->orderBy('invoices.id', 'desc')
                ->where(function($fn){
                    $fn->where('invoices.invoice_ref', 'like', "%{$_GET['q']}%")
                    ->orWhere('invoices.customer_id', 'like', "%{$_GET['q']}%")
                    ->orWhere('invoices.invoice_date', 'like', "%{$_GET['q']}%")
                    ->orWhere('students.code', 'like', "%{$_GET['q']}%")
                    ->orWhere('invoices.due_date', 'like', "%{$_GET['q']}%");
                })
                ->paginate(18);
        } else {
            
            $data['invoices'] = DB::table('invoices')
                ->join('students', 'students.id', 'invoices.customer_id')
                ->select('invoices.*', 'students.english_name', 'students.code')
                ->where('invoices.active',1)
                ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
                ->orderBy('invoices.id', 'desc')
                ->paginate(18);
        }
        return view('invoices.index', $data);
    }
    public function create(Request $r)
    {
        $customer_id = $r->query('customer_id');
        $data['customer'] = DB::table('students')
            ->where('id',  $customer_id)
            ->first();
        return view('invoices.create', $data);
    }
    public function save(Request $r)
    {
        $master = json_encode($r->master);
        $master = json_decode($master);
        $items = json_encode($r->items);
        $items = json_decode($items);
        $data = [
            'invoice_date' => $master->invoice_date,
            'due_date' => $master->due_date,
            'invoice_ref' => $master->invoice_ref,
            'customer_id' => $master->customer_id,
            'invoice_by' => Auth::user()->id,
            'note' => $master->note,
        ];
      $i = DB::table('invoices')->insertGetId($data);
      if($i) {
        $time = date("h:i:sa");
        Right::log(Auth::user()->id,"Add Invoice","insert", $i, "invoices", $time);
    }
      if($i)
      {
            $total_amount = 0;
            $total_due_amount = 0;
            foreach($items as $item)
            {
                DB::table('invoice_detials')
                ->insert(array(
                    'item_id' => $item->itemid,
                    'discount' => $item->discount,
                    'qty' => $item->qty,
                    'subtotal' => $item->sub_total,
                    'due_amount' => $item->due_amount,
                    'invoice_id' => $i,
                    'unit_price' => $item->unit_price
                ));
                $subtotal = $item->sub_total;
                $total_amount += $subtotal;
                $due_amount =  $item->due_amount;
                $total_due_amount += $due_amount;
            }

            $b = DB::table('invoices')->where('id',$i)->update(['total_amount'=>$total_amount, 'total_due_amount'=>$total_due_amount]);
      }
      
      
        return $i;
    }

    public function detail($id)
    {
        $data['invoice'] = DB::table('invoices')
        ->join('students', 'students.id', 'invoices.customer_id')
        ->select('invoices.*', 'students.*', 'invoices.id as invoice_id')
        ->where('invoices.active',1)
        ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
        ->where('invoices.id', $id)
        ->first();

        return view('invoices.detail', $data);
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
