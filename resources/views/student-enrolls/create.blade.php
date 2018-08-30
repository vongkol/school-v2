@extends('layouts.app')
@section('content')
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> New Student Enroll&nbsp;&nbsp;
                    <a href="{{url('/student-enroll')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
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

                    <form action="{{url('/student-enroll/save')}}" class="form-horizontal" method="post">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label for="registration_date" class="control-label col-lg-2 col-sm-2">Registration Date <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-sm-8">
                                <input type="text" required name="registration_date" id="registration_date" class="form-control  datepicker-icon">
                            </div>
                        </div>
                          <div class="form-group row">
                            <label for="student_id" class="control-label col-lg-2 col-sm-2">Student Name <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-sm-8">
                               <select name="student_id" id="student_id" class="form-control chosen-select">
                                    @foreach($students as $s)
                                    <option value="{{$s->id}}">{{$s->code}} - {{$s->english_name}}</option>    
                                    @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="class_id" class="control-label col-lg-2 col-sm-2">{{$lb_class}} <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-sm-8">
                               <select name="class_id" id="class_id" class="form-control">
                                    @foreach($classes as $c)
                                        <option value="{{$c->id}}">{{$c->name}}</option>    
                                    @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shift_id" class="control-label col-lg-2 col-sm-2">Shift </label>
                            <div class="col-lg-6 col-sm-8">
                               <select name="shift_id" id="shift_id" class="form-control">
                                    @foreach($shift as $s)
                                    <option value="{{$s->id}}">{{$s->name}}</option>    
                                    @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="study_time" class="control-label col-lg-2 col-sm-2">Student Time</label>
                            <div class="col-lg-6 col-sm-8">
                                <input type="text" name="study_time" id="study_time" class="form-control" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="year_id" class="control-label col-lg-2 col-sm-2">Year</label>
                            <div class="col-lg-6 col-sm-8">
                               <select name="year_id" id="year_id" class="form-control">
                                @foreach($years as $y)
                                    <option value="{{$y->id}}">{{$y->name}}</option>    
                                @endforeach
                               </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="start_date" class="control-label col-lg-2 col-sm-2">Start Date <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-sm-8">
                                <input type="text" required name="start_date" id="start_date" class="form-control  datepicker-icon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="end_date" class="control-label col-lg-2 col-sm-2">End Date <span class="text-danger">*</span></label>
                            <div class="col-lg-6 col-sm-8">
                                <input type="text" required name="end_date" id="end_date" class="form-control  datepicker-icon">
                            </div>
                        </div>
                      
                        <div class="form-group row">
                            <label class="control-label col-lg-2 col-sm-2">&nbsp;</label>
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
<script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('chosen/chosen.jquery.js')}}"></script>
    <script src="{{asset('chosen/chosen.proto.js')}}"></script>
    <script src="{{asset('chosen/docsupport/init.js')}}"></script>
<script>

    $(document).ready(function(){
        $("#start_date, #end_date, #registration_date").datepicker({
            orientation: 'bottom',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });
    });
</script>
@endsection