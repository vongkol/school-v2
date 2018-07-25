@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> {{$lb_class_list}}&nbsp;&nbsp;
                    <a href="{{url('/class/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                <div class="card-block">
                    <table class="tbl table-responsive">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>{{$lb_name}}</th>
                            <th>Active</th>
                            <th>{{$lb_action}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i=1)
                        @foreach($classes as $class)
                            <tr>
                                <td>{{$i++}}</td>
                                <td><a href="{{url('/student/class/'.$class->id)}}">{{$class->name}}</a></td>
                                <td><a class="text-danger" href="{{url('/class/close/'.$class->id)}}" onclick="return confirm('You want to close this class?')" title="Close">Close</a></td>
                                <td>
                                    <a href="{{url('/class/edit/'.$class->id)}}" title="{{$lb_edit}}"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp;
                                    <a href="{{url('/class/delete/'.$class->id)}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
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