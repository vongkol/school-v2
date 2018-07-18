@extends('layouts.app')
@section('content')
    <div class="row" style="margin-top: 18px">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-warning">
                <div class="card-block pb-0">
                    <div class="btn-group float-right">
                        <i class="icon-user"></i>
                    </div>
                    <h4 class="mb-0">{{$students}}</h4>
                    <p>Students</p>
                </div>
                <div class="chart-wrapper px-3" style="padding: 20px;">
                     <a href="{{url('/student')}}" class="text-white btn btn-xs btn-info"> View</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-danger">
                <div class="card-block pb-0">
                    <div class="btn-group float-right">
                      
                            <i class="icon-settings"></i>
                    
                       
                    </div>
                    <h4 class="mb-0">{{$invoices}}</h4>
                    <p>Invoices</p>
                </div>
                <div class="chart-wrapper px-3" style="padding: 20px;">
                    <a href="{{url('/invoice')}}" class="text-white btn btn-xs btn-info"> View</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-primary">
                <div class="card-block pb-0">
                    <button type="button" class="btn btn-transparent active p-0 float-right">
                        <i class="icon-user"></i>
                    </button>
                    <h4 class="mb-0">{{$staffs}}</h4>
                    <p>Staffs</p>
                </div>
                <div class="chart-wrapper px-3" style="padding: 20px;">
                     <a href="{{url('/staff')}}" class="text-white btn btn-xs btn-info"> View</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-success">
                <div class="card-block pb-0">
                    <div class="btn-group float-right">
                        
                            <i class="icon-settings"></i>

                        
                    </div>
                    <h4 class="mb-0">{{$items}}</h4>
                    <p>Items</p>
                </div>
                <div class="chart-wrapper px-3" style="padding: 20px;">
                <a href="{{url('/item')}}" class="text-white btn btn-xs btn-info"> View</a>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
@endsection
