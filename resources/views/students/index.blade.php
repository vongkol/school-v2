@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> {{$lb_student_list}}&nbsp;&nbsp;
                    <a href="{{url('/student/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                <div class="card-block">
                    <form action="{{url('/student')}}" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="name">{{$lb_search}}&nbsp;&nbsp;</label>
                            <input type="text" class="form-control" id="q" name="q" value="{{$query}}" >
                            <button type="submit"  style="padding:12px;" class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                    <br>
                    <table class="tbl table">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>{{$lb_code}}</th>
                            <th>{{$lb_khmer_name}}</th>
                            <th>{{$lb_english_name}}</th>
                            <th>{{$lb_gender}}</th>
                            <th>{{$lb_email}}</th>
                            <th>{{$lb_phone}}</th>
                            <th>{{$lb_address}}</th>
                            <th>{{$lb_action}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $pagex = @$_GET['page'];
                            if(!$pagex)
                            $pagex = 1;
                            $i = 18 * ($pagex - 1) + 1;
                        ?>
                        @foreach($students as $st)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$st->code}}</td>
                                <td><a href="{{url('/student/detail/'.$st->id)}}">{{$st->khmer_name}}</a></td>
                                <td><a href="{{url('/student/detail/'.$st->id)}}">{{$st->english_name}}</a></td>
                                <td>{{$st->gender}}</td>
                                <td>{{$st->email}}</td>
                                <td>{{$st->phone}}</td>
                                <td>{{$st->address}}</td>
                                <td>
                                    <a href="{{url('/student/detail/'.$st->id)}}">
                                        <i class="fa fa-edit text-success"></i>
                                    </a>&nbsp;&nbsp;
                                    <a  href="{{url('/student/delete/'.$st->id ."?page=".@$_GET["page"])}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
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