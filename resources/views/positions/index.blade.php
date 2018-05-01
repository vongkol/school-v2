@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Position List&nbsp;&nbsp;
                    <a href="{{url('/position/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                <div class="card-block">
                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>{{$lb_name}}</th>
                            <th>{{$lb_action}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i=1)
                        @foreach($positions as $position)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$position->name}}</td>
                                <td>
                                    <a href="{{url('/position/edit/'.$position->id)}}" title="{{$lb_edit}}"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp
                                    <a href="{{url('/position/delete/'.$position->id)}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    <nav aria-label="...">
                          {{$positions->links()}}
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