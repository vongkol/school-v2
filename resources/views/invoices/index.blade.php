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
                    <form action="{{url('/invoice')}}" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="name">{{$lb_search}}&nbsp;&nbsp;</label>
                            <input type="text" class="form-control" id="q" name="q" value="{{$query}}" >
                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                    <br>
                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>Invoice Ref</th>
                            <th>Code</th>
                            <th>Customer</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Discount (%)</th>
                            <th>Total Amount ($)</th>
                            <th>Due Amount ($)</th>
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
                                <td>{{$invoice->invoice_ref}}</td>
                                <td>{{$invoice->code}}</td>
                                <td>{{$invoice->english_name}}</td>
                                <td>{{$invoice->invoice_date}}</td>
                                <td>{{$invoice->due_date}} </td>
                                <td><span class="text-info">%</span> {{$invoice->discount}}</td>
                                <td><span class="text-info">USD</span> {{$invoice->total_amount}} </td>
                                <td><span class="text-info">USD</span> {{$invoice->due_amount}} </td>
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