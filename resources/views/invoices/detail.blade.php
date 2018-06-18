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
                        <div class="col-sm-6">
                            {{csrf_field()}}
                            <input type="hidden" value="{{$invoice->id}}" name="id">
                            <div class="form-group row">
                                <label for="invoice_ref" class="control-label col-sm-3">Invoice Reference</label> <label for="total_amount" class="control-label col-sm-6">:  {{$invoice->invoice_ref}}</label>
                            </div>
                            <div class="form-group row">
                                <label for="invoice_ref" class="control-label col-sm-3">Student Code</label> <label for="total_amount" class="control-label col-sm-6">:  {{$invoice->code}}</label>
                            </div>
                            <div class="form-group row">
                                <label for="invoice_by" class="control-label col-sm-3">Invoice By</label> <label for="total_amount" class="control-label col-sm-6">: {{$invoice->english_name}}</label>
                            </div>
                            <div class="form-group row">
                                <label for="invoice_date" class="control-label col-sm-3">Invoice Date</label> <label for="invoice_date" class="control-label col-sm-6">: {{$invoice->invoice_date}}</label>
                            </div>
                            <div class="form-group row">
                            <label for="due_date" class="control-label col-sm-3">Due Date</label> <label for="due_date" class="control-label col-sm-6">:    {{$invoice->due_date}}</label>
                            </div>
                            <div class="form-group row">
                            <label for="total_amount" class="control-label col-sm-3">Total Amount $</label> <label for="total_amount" class="control-label col-sm-6">:  <span class="text-warning">USD</span>   {{$invoice->total_amount}}</label>
                            </div>
                            <div class="form-group row">
                                <label for="due_amount" class="control-label col-sm-3">Due Amount $</label> <label for="due_amount" class="control-label col-sm-6">:  <span class="text-warning">USD</span>   {{$invoice->due_amount}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection