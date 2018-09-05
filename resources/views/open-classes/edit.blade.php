@extends('layouts.app')
@section('content')
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Detail Class&nbsp;&nbsp;
                    <a href="{{url('/class/detail/'.$class->id)}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
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
                    <div class="form-group row">
                        <div class="col-md-6"><h2>{{$class->name}}</h2></div>
                    </div>

                    <form action="{{url('/open-class/update')}}" onsubmit="return confirm('You want save change?')"
                          class="form-horizontal" method="post">
                          <input type="hidden" name="id" value="{{$open_class->id}}">
                        {{csrf_field()}}
                        <div class="row">
                        <div class="col-md-4">
                               <div class="form-group row">
                                   <label for="start_date" class="control-label col-sm-4">Start Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-8">
                                       <input type="text" required placeholder="yyyy-mm-dd" name="start_date" id="end_date" class="form-control datepicker-icon" value="{{$open_class->start_date}}">
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group row">
                                   <label for="end_date" class="control-label col-sm-4">End Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-8">
                                       <input type="text" required placeholder="yyyy-mm-dd" name="end_date" id="end_date" class="form-control datepicker-icon" value="{{$open_class->end_date}}">
                                   </div>
                               </div>
                           </div>
                          
                        <div class="form-group row">
                            <label class="control-label col-lg-1 col-sm-2">&nbsp;</label>
                            <div class="col-lg-6 col-sm-8">
                                <button class="btn btn-primary" type="submit">{{$lb_save}}</button>

                            </div>
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
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function(){
        $("#start_date, #end_date").datepicker({
            orientation: 'bottom',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });
    });
    </script>
@endsection