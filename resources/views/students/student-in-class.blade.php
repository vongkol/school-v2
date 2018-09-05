@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language == "kh" ? 'kh.php' : 'en.php'; ?>
    <?php include(app_path() . "/lang/" . $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Class -  <span class="text-danger">{{$class->name}}</span> - Student List  &nbsp;&nbsp;
                
                    <a href="{{url('/class/detail/'.$class->id)}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
                </div>
                <div class="card-block">
                    <table class="table table-condensed tbl table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>Code</th>
                            <th>English Name</th>
                            <th>Khmer Name</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Study Time</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                        </thead>
                        <div class="row">
                            <div class=" col-md-8">
                        Total Student : <span class="text-danger"> {{$students->count()}} </span> &nbsp;&nbsp; 
                        Male : <span class="text-primary">{{$total_student_male}}</span>&nbsp;&nbsp;
                        Female : <span class="text-primary">{{$total_student_female}}</span>
                        </div>
                        <tbody>
                        @php($i=1)
                        @foreach($students as $s)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$s->code}}</td>
                                <td><a href="{{url('student/detail/'.$s->student_id)}}">{{$s->english_name}}</a></td>
                                <td><a href="{{url('student/detail/'.$s->student_id)}}">{{$s->khmer_name}}</a></td>
                                <td>{{$s->gender}}</td>
                                <td>{{$s->email}}</td>
                                <td>{{$s->phone}}</td>
                                <td>{{$s->study_time}}</td>
                                <td>{{$s->start_date}}</td>
                                <td>{{$s->end_date}}</td>
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