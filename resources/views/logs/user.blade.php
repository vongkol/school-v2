@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i>User Action - Detail {{$lb_user_profile}}&nbsp;&nbsp; &nbsp;
                </div>
                <div class="card-block">
                    <div class="form-group row">
                        <label class="control-label col-lg-1 col-sm-2">{{$lb_name}}</label>
                        <label class="control-label col-lg-5 col-sm-5">: {{$user->name}}</label>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-1 col-sm-2">{{$lb_email}}</label>
                        <label class="control-label col-lg-5 col-sm-5">: {{$user->email}}</label>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-1 col-sm-2">{{$lb_language}}</label>
                        <label  class="control-label col-lg-5 col-sm-5">: {{$user->language}}</label>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-1 col-sm-2">{{$lb_role}}</label>
                        <label class="control-label col-lg-5 col-sm-5">: {{$role->name}}</label>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-lg-1 col-sm-2">{{$lb_photo}}</label>
                        <label class="control-label col-md-5"> <img src="{{asset('profile/'.$user->photo)}}" alt="" width="72"></label>
                     
                    </div>   
                   
                </div>
            </div>
        </div>
    </div>
@endsection