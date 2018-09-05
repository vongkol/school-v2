@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> {{$lb_student_enroll_list}}&nbsp;&nbsp;
                    <a href="{{url('/student-enroll/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                <div class="card-block">
                <form action="{{url('/student-enroll')}}" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="name">{{$lb_search}}&nbsp;&nbsp;</label>
                            <input type="text" class="form-control" id="q" name="q" value="{{$query}}" >
                            <button type="submit" style="padding:12px;" class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                    <br>
                <table class="tbl table-responsive">
                <thead>
                <tr>
                    <th>{!!$lb_id!!}</th>
                    <th>{{$lb_student_code}}</th>
                    <th>{{$lb_student_english_name}}</th>
                    <th>{{$lb_student_khmer_name}}</th>
                    <th>{{$lb_enroll_date}}</th>
                    <th>{{$lb_class}}</th>
                    <th>{{$lb_study_time}}</th>
                    <th>{{$lb_start_date}}</th>
                    <th>{{$lb_end_date}}</th>
                   
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
                            <td><a href="{{url('/student/detail/'.$r->student_id)}}">{{$r->code}}</a></td>
                            <td><a href="{{url('/student/detail/'.$r->student_id)}}">{{$r->english_name}}</a></td>
                            <td><a href="{{url('/student/detail/'.$r->student_id)}}">{{$r->khmer_name}}</a></td>
                            <td>{{$r->registration_date}}</td>
                            <td>{{$r->class_name}}</td>
                            <td>{{$r->study_time}}</td>
                            <td>{{$r->start_date}}</td>
                            <td>{{$r->end_date}}</td>
                            <td>
                                <a  href="{{url('/admin/student-enroll/delete/'.$r->registration_id."?page=".@$_GET["page"])}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br>
                <nav aria-label="...">
                {{$student_enrolls->links()}}
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