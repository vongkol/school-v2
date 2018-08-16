@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i>User Action - Detail Invoice&nbsp;&nbsp;
                    <a href="{{url('/log')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
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
                            ->select('items.*', 'invoice_detials.*', 'items.name as item_name')
                            ->where('invoice_detials.invoice_id' , $invoice->invoice_id)
                            ->where('invoice_detials.active',1)
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
                                        <td><b>Total Amount<div id="total" class="text-primary">$ {{$invoice->total_amount}}</div></b></td>
                                    </table>
                                    
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