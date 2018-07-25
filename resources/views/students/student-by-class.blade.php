@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language == "kh" ? 'kh.php' : 'en.php'; ?>
    <?php include(app_path() . "/lang/" . $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Class -  <span class="text-danger">{{$class->name}}</span> - Student List  &nbsp;&nbsp;
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
                        </tr>
                        </thead>
                        <div class="row">
                            <div class=" col-md-8">
                        Total Student : <span class="text-danger"> {{$students->count()}} </span> &nbsp;&nbsp; 
                        Male : <span class="text-primary">{{$total_student_male}}</span>&nbsp;&nbsp;
                        Female : <span class="text-primary">{{$total_student_female}}</span>
                        </div>
                        <div class="col-md-4">
                        <form action="{{url('/student/class/'.$class->id)}}" class="form-inline" method="get">
                            <div class="text-right">
                                <div class="form-group">
                                        <label for="name">{{$lb_search}}&nbsp;&nbsp;</label>
                                        <select id="q" name="q" value="{{$query}}">
                                            <option value="">--All--</option>
                                            @foreach($shifts as $shift)
                                                <option value="{{$shift->id}}">{{$shift->name}}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit"  style="padding:3px 10px;"><i class="fa fa-search"></i></button>
                            
                                </div>
                            </div>
                        </form>
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