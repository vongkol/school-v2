<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // index
    public function index()
    { 
        if(!Right::check('Invoice', 'l')){
            return view('permissions.no');
        }
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
                    ->orWhere('students.english_name', 'like', "%{$_GET['q']}%")
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
        if(!Right::check('Invoice', 'i')){
            return view('permissions.no');
        }
        $customer_id = $r->query('customer_id');
        $data['customer'] = DB::table('students')
            ->where('id',  $customer_id)
            ->first();
        return view('invoices.create', $data);
    }
    public function save(Request $r)
    {
        if(!Right::check('Invoice', 'i')){
            return view('permissions.no');
        }
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
        if(!Right::check('Invoice', 'l')){
            return view('permissions.no');
        }
        $data['invoice'] = DB::table('invoices')
            ->join('students', 'students.id', 'invoices.customer_id')
            ->join('users' ,'invoices.invoice_by', 'users.id')
            ->select('invoices.*', 'students.english_name','students.code', 'invoices.id as invoice_id', 'users.name as invoice_by')
            ->where('invoices.active',1)
            ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
            ->where('invoices.id', $id)
            ->first();
        $data['histories'] = DB::table('payment_histories')->where('invoice_id', $id)->get();
        $data['invoice_id'] = $id;
        return view('invoices.detail', $data);
    }
   
    public function print_invoice($id)
    {
        if(!Right::check('Invoice', 'l')){
            return view('permissions.no');
        }
        $data['invoice'] = DB::table('invoices')
            ->join('students', 'students.id', 'invoices.customer_id')
            ->join('users' ,'invoices.invoice_by', 'users.id')
            ->select('invoices.*', 'students.*', 'invoices.id as invoice_id', 'users.name as invoice_by')
            ->where('invoices.active',1)
            ->whereIn('students.branch_id', Right::branch(Auth::user()->id))
            ->where('invoices.id', $id)
            ->first();

        $data['branch'] = DB::table('branches')
            ->where('id', $data['invoice']->branch_id)
            ->first();

        return view('invoices.print', $data);
    }

    public function get_item($id) {
        $item  = DB::table('items')->where('id', $id)->first();

        return json_encode($item);
    }
    public function delete($id)
    {
        if(!Right::check('Invoice', 'd')){
            return view('permissions.no');
        }
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

    public function ajustment($id) {
        // if(!Right::check('Invoice', 'i')){
        //     return view('permissions.no');
        // }
        // if(!Right::check('Invoice', 'i')){
        //     return view('permissions.no');
        // }
       
        $data['master'] = DB::table('invoices')->where('id', $id)->first();
        $data['details'] = DB::table('invoice_detials')
                            ->join('items', 'invoice_detials.item_id', 'items.id')
                            ->where('invoice_detials.invoice_id', $id)
                            ->select('invoice_detials.*', 'items.name')
                            ->get();
        $data['customer'] = DB::table('students')->where('id', $data['master']->customer_id)->first();
        return view('invoices.edit', $data);
    }
    public function update(Request $r)
    {
        $master = json_encode($r->master);
        $master = json_decode($master);
        $items = json_encode($r->items);
        $items = json_decode($items);
        $data = [
            'invoice_date' => $master->invoice_date,
            'due_date' => $master->due_date,
            'invoice_by' => Auth::user()->id,
            'note' => $master->note,
        ];
        $i = DB::table('invoices')->where('id', $master->id)->update($data);
        $time = date("h:i:sa");
        Right::log(Auth::user()->id,"update Invoice","update", $master->id, "invoices", $time);
        //delete item detail before insert new
        DB::table('invoice_detials')->where('invoice_id', $master->id)->delete();
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
                'invoice_id' => $master->id,
                'unit_price' => $item->unit_price
            ));
            $subtotal = $item->sub_total;
            $total_amount += $subtotal;
            $due_amount =  $item->due_amount;
            $total_due_amount += $item->due_amount;
           
        }
        $his = DB::table('payment_histories')->where('invoice_id',$master->id)->sum('amount');
        $total_due_amount -=$his;
        $b = DB::table('invoices')->where('id',$master->id)->update([
            'total_amount'=>$total_amount, 
            'total_due_amount'=>$total_due_amount
            ]);
        return 1;
    }
    public function save_history(Request $r)
    {
       
        $inv = DB::table('invoices')->where('id', $r->invoice_id)->first();
        if($r->amount<=$inv->total_due_amount)
        {
            // save payment history
            $data = array(
                'invoice_id' => $r->invoice_id,
                'pay_date' => $r->payment_date,
                'amount' => $r->amount
            );
            $i = DB::table('payment_histories')->insert($data);
            // calulate due amount in invoices table
            $balance = $inv->total_due_amount - $r->amount;
            DB::table('invoices')->where('id', $r->invoice_id)->update([
                'total_due_amount' => $balance
            ]);
        }
        return 1;
    }
    public function delete_history(Request $r)
    {
        $hid = $r->hid;
        $id = $r->id;
        $h = DB::table('payment_histories')->where('id', $hid)->first();
        $inv = DB::table('invoices')->where('id', $id)->first();
        DB::table('payment_histories')->where('id', $hid)->delete();
        // recalculate total_due_amount
        $due = $inv->total_due_amount + $h->amount;
        DB::table('invoices')->where('id', $id)->update(['total_due_amount'=>$due]);
        return redirect('/invoice/detail/'.$id);
    }
}

