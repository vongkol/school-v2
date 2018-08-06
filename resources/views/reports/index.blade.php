@extends('layouts.app')
@section('content')
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Report Student List&nbsp;&nbsp;
                </div>
                <div class="card-block">
                   <div class="row">
                       <div class="col-sm-12">
                           <h4>List All Students</h4>
                           <hr>
                           <div class="form-group row">
                               <label for="" class="control-label col-sm-2">&nbsp;</label>
                               <div class="col-sm-7">
                                   <a href="{{url('/printing')}}" class="btn btn-primary" target="_blank">Generate Report</a>
                               </div>
                           </div>
                           <h4>List student by receptionist</h4>
                           <hr>
                           <form action="{{url('/printing/school')}}" class="form-horizontal" method="get" target="_blank">
                           <div class="form-group row">
                           <div class="col-md-2">
                            <label for="">Start Date</label> 
                            <input type="text"  placeholder="yyyy-mm-dd"  class="form-control datepicker-icon" id="start_date" name="start_date" value="{{old('start_date')}}">
                        </div>
                                <div class="col-md-2">
                                    <label for="">End Date</label> 
                                    <input type="text" class="form-control datepicker-icon" placeholder="yyyy-mm-dd" id="end_date" name="end_date" value="{{old('end_date')}}">
                                </div>
                                <div class="col-md-2">
                                    <label for="school" class="control-label col-sm-2">Receptionist</label>
                                        <select name="school" id="province" class="form-control">
                                            <option value="">--All--</option>
                                            @foreach($schools as $pro)
                                                <option value="{{$pro->id}}">{{$pro->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                            
                                    <div class="col-sm-2">
                                    <label class="control-label col-sm-2"><br></label>
                                        <button class="btn btn-primary" type="submit">Generate Report</button>
                                    </div>
                                </div>
                                </form>
                           <h4>List student by class</h4>
                           <hr>
                           <form action="{{url('/printing/school')}}" class="form-horizontal" method="get" target="_blank">
                               <div class="form-group row">
                               <div class="col-md-2">
                                <label for="">Start Date</label> 
                                <input type="text"  placeholder="yyyy-mm-dd"  class="form-control datepicker-icon" id="start_date" name="start_date" value="{{old('start_date')}}">
                            </div>
                                    <div class="col-md-2">
                                        <label for="">End Date</label> 
                                        <input type="text" class="form-control datepicker-icon" placeholder="yyyy-mm-dd" id="end_date" name="end_date" value="{{old('end_date')}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="school" class="control-label col-sm-2">Class</label>
                                            <select name="school" id="province" class="form-control">
                                                <option value="">--All--</option>
                                                @foreach($schools as $pro)
                                                    <option value="{{$pro->id}}">{{$pro->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                                
                                        <div class="col-sm-2">
                                        <label class="control-label col-sm-2"><br></label>
                                            <button class="btn btn-primary" type="submit">Generate Report</button>
                                        </div>
                                    </div>
                                    </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>
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
<script src="{{asset('js/students/student-edit.js')}}"></script>
@endsection