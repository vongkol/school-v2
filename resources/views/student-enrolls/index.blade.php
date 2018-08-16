@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Student Enroll List&nbsp;&nbsp;
                    <a href="{{url('/student-enroll/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                <div class="card-block">
                <table class="tbl table-responsive">
                <thead>
                <tr>
                    <th>{!!$lb_id!!}</th>
                    <th>Student Code</th>
                    <th>English Name</th>
                    <th>Khmer Name</th>
                    <th>Enroll Date</th>
                    <th>{{$lb_class}}</th>
                    <th>Shift</th>
                    <th>{{$lb_school_year}}</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                   
                    <th>{{$lb_action}}</th>
                </tr>
                </thead>
                    <tbody id="rdata">
                    <?php
                        $pagex = @$_GET['page'];
                        if(!$pagex)
                        $pagex = 1;
                        $i = 18 * ($pagex - 1) + 1;
                    ?>
                    @foreach($student_enrolls as $r)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$r->code}}</td>
                            <td>{{$r->english_name}}</td>
                            <td>{{$r->khmer_name}}</td>
                            <td>{{$r->registration_date}}</td>
                            <td>{{$r->class_name}}</td>
                            <td>{{$r->shift_name}}</td>
                            <td>{{$r->year_name}}</td>
                            <td>{{$r->start_date}}</td>
                            <td>{{$r->end_date}}</td>
                            <td>
                                <!--<a href="#" onclick="editRegistration(this, event)"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp;-->
                                <a href="#" onclick="removeRegistration(this,event)">
                                    <i class="fa fa-remove text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
@endsection