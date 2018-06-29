@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Staff List&nbsp;&nbsp;
                    <a href="{{url('/staff/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                <div class="card-block">
                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>{{$lb_name}}</th>
                            <th>Family Name</th>
                            <th>Branch</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Position</th>
                            <th>Salary</th>
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
                        @foreach($staffs as $staff)
                            <tr>
                                <td>{{$i++}}</td>
                                <td><a href="{{url('/staff/detail/'.$staff->id)}}">{{$staff->first_name}}</a></td>
                                <td><a href="{{url('/staff/detail/'.$staff->id)}}">{{$staff->family_name}}</a></td>
                                <td>{{$staff->branch_id}}</td>
                                <td>{{$staff->email}}</td>
                                <td>{{$staff->phone}}</td>
                                <td>{{$staff->gender}}</td>
                                <td>{{$staff->position_id}}</td>
                                <td>{{$staff->salary}}</td>
                                <td>
                                    <a href="{{url('/staff/detail/'.$staff->id)}}" title="Detail"  class="btn btn-link btn-sm text-info"><i class="fa fa-eye"></i></a>
                                    <a href="{{url('/staff/edit/'.$staff->id)}}" title="{{$lb_edit}}"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp
                                    <a href="{{url('/staff/delete/'.$staff->id)}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    <nav aria-label="...">
                          {{$staffs->links()}}
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