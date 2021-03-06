@extends('layouts.app')
@section('content')
    <div class="row" style="margin-top: 18px">
        @foreach($classes as $s)
        <?php 
            $date = date("y-m-d");
            
            $students = DB::table('registrations')
                ->join('students', 'students.id', 'registrations.student_id')
                ->where('students.active', 1)
                ->whereIn('students.branch_id', $user_brand)
                ->where('class_id', $s->id)
                ->whereDate('registrations.start_date', '<=', $date)
                ->whereDate('registrations.end_date' ,'>=' ,$date)
                ->where('registrations.active',1)
                ->count()
        ;?>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-primary">
                <div class="card-block pb-0">
                    <div class="btn-group float-right">
                        <i class="icon-user"></i>
                    </div>
                    <h4 class="mb-0">{{$students}}</h4>
                    <p>{{$s->name}}</p>
                </div>
                <div class="chart-wrapper px-3" style="padding: 20px;">
                     <a href="{{url('/student/class/'.$s->id)}}" class="text-white btn btn-xs btn-info"> View</a>
                </div>
            </div>
        </div>
       @endforeach
        <!--/.col-->
    </div>
@endsection
