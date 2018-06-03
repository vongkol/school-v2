@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Invoice List&nbsp;&nbsp;
                    <a href="{{url('/invoice/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                <div class="card-block">
                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>Invoice By</th>
                            <th>Invoice Date</th>
                            <th>Total Amount</th>
                            <th>Due Date</th>
                            <th>Due Amount</th>
                            <th>Invoice Ref</th>
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
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$invoice->invoice_by}}</td>
                                <td>{{$invoice->invoice_date}}</td>
                                <td>{{$invoice->total_mount}} </td>
                                <td>{{$invoice->due_amount}} </td>
                                <td>{{$invoice->total_mount}} </td>
                                <td>{{$invoice->due_date}} </td>
                                <td>{{$invoice->invoice_ref}}</td>
                                <td>
                                    <a href="{{url('/invoice/detail/'.$invoice->id)}}" title="Detail"><i class="fa fa-eye text-info"></i></a>&nbsp;&nbsp
                                    <a href="{{url('/invoice/edit/'.$invoice->id)}}" title="{{$lb_edit}}"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp
                                    <a  href="{{url('/invoice/delete/'.$invoice->id ."?page=".@$_GET["page"])}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    <nav aria-label="...">
                          {{$invoices->links()}}
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