@extends('layouts.app')
@section('content')
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
<style>
     #sp .multi-select-button, #sp1 .multi-select-button{
        background: #eceeef;
    }
</style>
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> User Action List&nbsp;&nbsp;
                </div>
                <div class="card-block">
                    <form action="">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="user_id">All User</label> 
                            <select name="user_id" id="user_id" class="form-control text-center">
                                <option value="">--All--</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Action</label> 
                            <select name="action" id="action" class="form-control text-center">
                                <option value="">--All--</option>
                                <option value="insert">Insert</option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                                <option value="login">Login</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="on_table">On Table</label> 
                            <select name="on_table" id="on_table" class="form-control text-center">
                                <option value="">--All--</option>
                                <option value="students">students</option>
                                <option value="staffs">staffs</option>
                                <option value="items">items</option>
                                <option value="users">users</option>
                                <option value="invoices">invoices</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Start Date</label> 
                            <input type="text"  placeholder="yyyy-mm-dd"  class="form-control datepicker-icon" id="start_date" name="start_date" value="{{old('start_date')}}">
                        </div>
                        <div class="col-md-2">
                            <label for="">End Date</label> 
                            <input type="text" class="form-control datepicker-icon" placeholder="yyyy-mm-dd" id="end_date" name="end_date" value="{{old('end_date')}}">
                        </div>
                        <div class="col-md-2" style="margin-top: 34px;">
                            <input type="Submit" name="search" value="Search" class="btn btn-primary btn-lg form-control">
                        </div>
                    </div>
                    </form>
                  <br>

                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>{{$lb_name}}</th>
                            <th>Action Type</th>
                            <th>Table Action</th>
                            <th>Description</th>
                           

                            <th>Record ID</th>
                            <th>Date</th>
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
                        @php($i=1)
                        @foreach($logs as $log)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$log->user_id}}</td>
                                <td>{{$log->action_type}}</td>
                                <td>{{$log->table_action}}</td>
                                <td>{{$log->description}}</td>
                               
                                <td>{{$log->record_id}}</td>
                                <td>{{$log->log_date}} {{$log->time}}</td>
                                <td>
                                <a href="{{url('/log/delete/'.$log->id ."?page=".@$_GET["page"])}}" onclick="return confirm('You want to delete?')" title="Delete"><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        All Action : <span class="text-danger"><b>{{$total}}</b></span>
                    </table>
                    <br>
                    <nav aria-label="...">
                          {{$logs->links()}}
                    </nav>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
@endsection
@section('js')
<script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.pagination li').addClass('page-item');
        $(".pagination li a").addClass('page-link');
        $(".pagination li span").addClass('page-link');
        $("#start_date, #end_date").datepicker({
                orientation: 'bottom',
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            });
    });
</script>
@endsection