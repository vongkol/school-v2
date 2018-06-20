@extends('layouts.app')
@section('content')
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Detail Invoice&nbsp;&nbsp;
                    <a href="{{url('/invoice')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
                </div>
                <div class="card-block">
                @if(Session::has('sms'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div>
                            {{session('sms')}}
                        </div>
                    </div>
                @endif
                @if(Session::has('sms1'))
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div>
                            {{session('sms1')}}
                        </div>
                    </div>
                @endif
                    <div class="row">
                        <div class="col-sm-12">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$invoice->id}}" name="id">
                            <div class="row">
                                <label class="control-label col-sm-6">: <h3>{{$invoice->invoice_ref}}</h3></label>
                            </div>
                            <div class="form-group row">
                                <label for="invoice_ref" class="control-label col-sm-6">Student Code :  {{$invoice->code}}</label>
                                <label for="invoice_date" class="control-label col-sm-6">Invoice Date : {{$invoice->invoice_date}}</label>
                            </div>
                            <div class="form-group row">
                            <label for="invoice_by" class="control-label col-sm-6">Invoice By : {{$invoice->english_name}}</label>
                                
                                <label for="due_date" class="control-label col-sm-6">Due Date:    {{$invoice->due_date}}</label>
                            </div>
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header text-bold">
                                    <i class="fa fa-align-justify"></i> Invoice Lines&nbsp;&nbsp;
                                    <a href="{{url('/invoice/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                                </div>
                                <div class="card-block">
                                    <table class="tbl table">
                                        <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Discount (%)</th>
                                            <th>Quantity</th>
                                            <th>Unit Price ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Laravel Couse</td>
                                                <td>10 </td>
                                                <td>1</td>
                                                <td>200</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection