@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language == "kh" ? 'kh.php' : 'en.php'; ?>
    <?php include(app_path() . "/lang/" . $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Year -  <span class="text-danger"></span> - Student List  &nbsp;&nbsp;
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
                        <tbody>
                        @php($i=1)
                        @foreach($students as $s)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$s->code}}</td>
                                <td><a href="{{url('student/detail/'.$s->id)}}">{{$s->english_name}}</a></td>
                                <td><a href="{{url('student/detail/'.$s->id)}}">{{$s->khmer_name}}</a></td>
                                <td>{{$s->gender}}</td>
                                <td>{{$s->email}}</td>
                                <td>{{$s->phone}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <nav aria-label="...">
                          {{$students->links()}}
                    </nav>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('.pagination li').addClass('page-item');
        $(".pagination li a").addClass('page-link');
        $(".pagination li span").addClass('page-link');
    });
</script>
@endsection