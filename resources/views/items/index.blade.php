@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Item List&nbsp;&nbsp;
                    <a href="{{url('/item/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                <div class="card-block">
                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>Photo</th>
                            <th>{{$lb_name}}</th>
                            <th>Branch</th>
                            <th>Tax</th>
                            <th>Price</th>
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
                        @foreach($items as $item)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>
                                    <a href="{{url('/item/detail/'.$item->id)}}" title="Detail">
                                        @if($item->photo !== null)
                                            <img src="{{asset('uploads/items/'.$item->photo)}}" width="50" alt="">
                                        @else 
                                            <img src="{{asset('logo.png')}}" width="50" alt="">
                                        @endif
                                    </a>
                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->branch_id}}</td>
                                <td>% {{$item->tax}} </td>
                                <td>$ {{$item->price}} </td>
                                <td>
                                    <a href="{{url('/item/detail/'.$item->id)}}" title="Detail"><i class="fa fa-eye text-info"></i></a>&nbsp;&nbsp
                                    <a href="{{url('/item/edit/'.$item->id)}}" title="{{$lb_edit}}"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp
                                    <a href="{{url('/item/delete/'.$item->id)}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    <nav aria-label="...">
                          {{$items->links()}}
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