@extends('layouts.app')
@section('content')
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Detail Class&nbsp;&nbsp;
                    <a href="{{url('/class')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
                </div>
                <div class="card-block">
                    @if(Session::has('sms'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div>
                                {{session('sms')}}
                            </div>
                        </div>
                    @endif
                    @if(Session::has('sms1'))
                        <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div>
                                {{session('sms1')}}
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-md-6"><h2>{{$class->name}}</h2></div>
                    </div>
                    <form action="{{url('/open-class/save')}}" onsubmit="return confirm('You want to open new class?')"
                          class="form-horizontal" method="post">
                          <input type="hidden" name="id" value="{{$class->id}}">
                        {{csrf_field()}}
                        <div class="row">
                        <div class="col-md-4">
                               <div class="form-group row">
                                   <label for="start_date" class="control-label col-sm-4">Start Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-8">
                                       <input type="text" required placeholder="yyyy-mm-dd" name="start_date" id="end_date" class="form-control datepicker-icon" value="{{old('invoice_date')}}">
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group row">
                                   <label for="end_date" class="control-label col-sm-4">End Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-8">
                                       <input type="text" required placeholder="yyyy-mm-dd" name="end_date" id="end_date" class="form-control datepicker-icon" value="{{old('due_date')}}">
                                   </div>
                               </div>
                           </div>
                          
                        <div class="form-group row">
                            <label class="control-label col-lg-1 col-sm-2">&nbsp;</label>
                            <div class="col-lg-6 col-sm-8">
                                <button class="btn btn-primary" type="submit">{{$lb_save}}</button>

                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Open Class List&nbsp;&nbsp;
                </div>
                <div class="card-block">
                    <table class="table  tbl table-condensed table-striped table-responsive">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $pagex = @$_GET['page'];
                            if(!$pagex)
                            $pagex = 1;
                            $i = 18 * ($pagex - 1) + 1;
                        ?>
                        @foreach($open_classes as $o)
                            <tr>
                                <td>{{$i++}}</td>
                                <td><a href="{{url('/student/history?start_date='.$o->start_date.'&end_date='.$o->end_date.'&class_id='.$o->class_id)}}">{{$o->start_date}}</a></td>
                                <td><a href="{{url('/student/history?start_date='.$o->start_date.'&end_date='.$o->end_date.'&class_id='.$o->class_id)}}">{{$o->end_date}}</a></td>
                                <td>
                                    <a href="{{url('/open-class/edit/'.$o->id)}}" title="{{$lb_edit}}"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp
                                    <a  href="{{url('/open-class/delete/'.$o->id ."?page=".@$_GET["page"])}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    <nav aria-label="...">
                          {{$open_classes->links()}}
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
        $("#start_date, #end_date").datepicker({
            orientation: 'bottom',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });
    });
    </script>
<script>
    $(document).ready(function(){
        $('.pagination li').addClass('page-item');
        $(".pagination li a").addClass('page-link');
        $(".pagination li span").addClass('page-link');
    });
</script>
@endsection