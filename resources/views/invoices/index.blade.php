@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> {{$lb_invoice_list}}&nbsp;&nbsp;
                </div>
                
                <div class="card-block">
                    <form action="{{url('/invoice')}}" class="form-inline" method="get">
                        <div class="form-group">
                            <label for="name">{{$lb_search}}&nbsp;&nbsp;</label>
                            <input type="text" class="form-control" id="q" name="q" value="{{$query}}" >
                            <button type="submit" style="padding:12px;" class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                    <br>
                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>{{$lb_invoice_ref}}</th>
                            <th>{{$lb_student_code}}</th>
                            <th>{{$lb_student_english_name}}</th>
                            <th>{{$lb_invoice_date}}</th>
                            <th>{{$lb_due_date}}</th>
                            <th>{{$lb_total_due_amount}} ($)</th>
                            <th>{{$lb_total_amount}} ($)</th>
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
                            <tr @if($invoice->total_due_amount) bgcolor="#ffe6e6" @endif >
                                <td>{{$i++}}</td>
                                <td> <a href="{{url('/invoice/detail/'.$invoice->id)}}" title="Detail">{{$invoice->invoice_ref}}</a></td>
                                <td> <a href="{{url('/invoice/detail/'.$invoice->id)}}" title="Detail">{{$invoice->code}}</a></td>
                                <td> <a href="{{url('/invoice/detail/'.$invoice->id)}}" title="Detail">{{$invoice->english_name}}</a></td>
                                <td>{{$invoice->invoice_date}}</td>
                                <td>{{$invoice->due_date}} </td>
                                <td>$ {{$invoice->total_due_amount}}</td>
                                <td>$ {{$invoice->total_amount}}</td>
                                <td>
                                    <a href="{{url('/invoice/detail/'.$invoice->id)}}" title="Detail"><i class="fa fa-eye text-info"></i></a>&nbsp;&nbsp;
                                    <a href="{{url('/invoice/ajustment?customer_id='.$invoice->customer_id.'&'.'invoice_ref='.$invoice->invoice_ref)}}" title="Ajustment"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp;
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