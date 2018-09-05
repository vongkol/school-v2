@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Detail Invoice&nbsp;&nbsp;
                    <a href="{{url('/invoice')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
                    <a href="{{url('invoice/print/'.$invoice->invoice_id)}}" class="float-right">
                        <button>Print Invoice</button>
                    </a>
                                  
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <label class="control-label col-sm-6"> <h3>Invoice Reference {!!$lb_id!!} : {{$invoice->invoice_ref}}</h3></label>
                            </div>
                            <div class="form-group row">
                                <label for="invoice_ref" class="control-label col-sm-6">Student Code :  {{$invoice->code}}</label>
                                <label for="invoice_date" class="control-label col-sm-6">Invoice Date : {{$invoice->invoice_date}}</label>
                            </div>
                            <div class="form-group row">
                            <label for="invoice_by" class="control-label col-sm-6">Student : {{$invoice->english_name}}</label>
                                
                                <label for="due_date" class="control-label col-sm-6">Due Date:    {{$invoice->due_date}}</label>
                            </div>
                           
                        </div>
                    </div>
                    <?php    
                        $invoice_details = DB::table('invoice_detials')
                            ->join('items', 'invoice_detials.item_id', 'items.id')
                            ->where('invoice_detials.invoice_id', $invoice_id)
                            ->select('invoice_detials.*', 'items.name as item_name')
                            ->get();
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header text-bold">
                                    <i class="fa fa-align-justify"></i> Invoice Lines
                                </div>
                                <div class="card-block">
                                    <table class="tbl table">
                                        <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Discount (%)</th>
                                            <th>Quantity</th>
                                            <th>Due Amount ($)</th>
                                            <th>Unit Price ($)</th>
                                            <th>Sub Total ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($invoice_details as $invoice_detail)
                                            <tr>
                                                <td>{{$invoice_detail->item_name}}</td>
                                                <td>{{$invoice_detail->discount}} %</td>
                                                <td>{{$invoice_detail->qty}}</td>
                                                <td>@if($invoice_detail->due_amount != 0)<span class="text-danger"> @endif $ {{$invoice_detail->due_amount}} @if($invoice_detail->due_amount != 0)</span>@endif</td>
                                                <td>$ {{$invoice_detail->unit_price}}</td>
                                                <td>$ {{$invoice_detail->subtotal}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table class="table text-right">
                                        <td><div class="text-left">Note: <span class="text-danger">{{$invoice->note}}</span></div></td>
                                        <td>
                                            <div>
                                                <b>Due Amount <div id="total" class="text-primary">$ {{$invoice->total_due_amount}}</div></b>
                                            </div>
                                            <b>Total Amount<div id="total" class="text-primary">$ {{$invoice->total_amount}}</div></b>
                                        </td>
                                    </table> 
                                    
                                    @if(count($histories)>0)
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h5>Payment History</h5>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>&numero;</th>
                                                        <th>Pay Date</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php($i=1)
                                                @foreach($histories as $h)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>{{$h->pay_date}}</td>
                                                        <td>{{$h->amount}} $</td>
                                                        <td>
                                                            <a href="{{url('/payment-history/delete?hid='.$h->id .'&id='.$invoice_id)}}" onclick="return confirm('You want to delete?')" class="text-danger">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                
                                        </table>
                                        </div>
                                    </div>   
                                    @endif
                                    @if($invoice->total_due_amount>0)
                                        <a href="#" id="btnPayment" class="btn btn-success btn-sm" data-toggle="modal" data-target="#docModal">Add Payment</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 float-right">
                            Invoice By : {{ $invoice->invoice_by}}
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
 <!-- Document Modal -->
 <div class="modal fade" id="docModal" tabindex="-1" role="dialog" aria-labelledby="docModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="docModalTitle">Add Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group row">
                                <label for="payment_date" class="control-label col-sm-3">Pay Date<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" name="payment_date" id="payment_date">
                                    <input type="hidden" id="id" value="{{$invoice_id}}">
                                    {{csrf_field()}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="amount" class="control-label col-sm-3">Amount<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="number" min="0" max="99999999" step="0.1" class="form-control" id="amount" name="amount">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p id="docsms" class="text-danger text-center"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="savePayment()">{{$lb_save}}</button>
                    <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal" onclick="clearDoc()">Close</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
<script>
var burl = "{{url('/')}}";
// function to save family
function savePayment() {
    var payment = {
        invoice_id: $("#id").val(),
        payment_date: $('#payment_date').val(),
        amount: $("#amount").val()
    };
    // full name is required
    if(payment.amount=="" || payment.payment_date=="")
    {
        alert("Full name is required!");
    }
    else{

        $.ajax({
            type: "POST",
            url: burl + "/payment-history/save",
            data: payment,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("input[name='_token']").val());
            },
            success: function (sms) {
             location.reload();
            //  console.log(sms);
            }
        });
    }
}
</script>
@endsection