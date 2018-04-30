@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> {{$lb_new_commune}}&nbsp;&nbsp;
                    <a href="{{url('/commune')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
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

                    <form action="{{url('/commune/save')}}" class="form-horizontal" method="post">
                        {{csrf_field()}}
                          <div class="form-group row">
                            <label for="province" class="control-label col-lg-1 col-sm-2">{{$lb_province}}</label>
                            <div class="col-lg-6 col-sm-8">
                               <select name="province" id="province" class="form-control">
                                @foreach($provinces as $pro)
                                    <option value="{{$pro->id}}">{{$pro->name}}</option>    
                                @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="control-label col-lg-1 col-sm-2">{{$lb_name}}</label>
                            <div class="col-lg-6 col-sm-8">
                                <input type="text" required autofocus name="name" id="name" class="form-control" value="{{old('name')}}">
                            </div>
                        </div>
                      
                        <div class="form-group row">
                            <label class="control-label col-lg-1 col-sm-2">&nbsp;</label>
                            <div class="col-lg-6 col-sm-8">
                                <button class="btn btn-primary" type="submit">{{$lb_save}}</button>
                                <button class="btn btn-danger" type="reset">{{$lb_cancel}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
@endsection
@section('js')
    <script src="{{asset('js/districts/district.js')}}"></script>
    <script>
        $(document).ready(function(){
            var province_id = $("#province").val();
            
        });
    </script>
@endsection