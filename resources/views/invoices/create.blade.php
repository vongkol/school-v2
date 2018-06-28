@extends('layouts.app')
@section('content')
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> New Invoice&nbsp;&nbsp;
                    <a href="{{url('/invoice')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
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
                    <form action="{{url('/invoice/save')}}" class="form-horizontal" method="post" enctype='multipart/form-data'>
                       <div class="row">
                           <div class="col-sm-6">
                               {{csrf_field()}}
                               <div class="form-group row">
                                   <label for="invoice_ref" class="control-label col-sm-3">Invoice Referentce</label>
                                   <div class="col-sm-9">
                                       <input type="text"  name="invoice_ref" id="invoice_ref" class="form-control" value="{{old('invoice_ref')}}">
                                   </div>
                               </div>
                               <?php $students = DB::table('students')->where('active',1)->orderBy('id','desc')->get();?>
                               <div class="form-group row">
                                   <label for="invoice_by" class="control-label col-sm-3">Customer <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <select name="customer_id" id="customer_id" class="form-control chosen-select">
                                           @foreach($students as $s)
                                           <option value="{{$s->id}}">{{$s->code}} - {{$s->english_name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="invoice_date" class="control-label col-sm-3">Invoice Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required placeholder="yyyy-mm-dd" name="invoice_date" id="invoice_date" class="form-control datepicker-icon" value="{{old('invoice_date')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="due_date" class="control-label col-sm-3">Due Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required placeholder="yyyy-mm-dd" name="due_date" id="due_date" class="form-control datepicker-icon" value="{{old('due_date')}}">
                                   </div>
                               </div>
                           </div>
                             
                                    <div class="col-sm-12 col-md-12">
                                        <table id="invoice">

                                            <?php 
                                                $items = DB::table('items')->join('branches', 'branches.id', '=', 'items.branch_id')
                                                ->select('items.*', 'branches.name as branch_id')
                                                ->where('items.active',1)->orderBy('items.id', 'desc')->get(); 
                                                ?>
                                            <tbody id="data">
                                                <tr>
                                                    <td>
                                                        Item<br>
                                                        <select class="form-control chosen-select" onchange="change_item()" id="itemid" name="itemid">
                                                        <option value="0"> </option>
                                                            @foreach($items as $item)
                                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                  
                                                </td>
                                                    <td> Discount
                                                        <input type="number" class="form-control" id="discount" name="discount" step="0.1" value="0" placeholder="discount %"></td>
                                                    <td> Quantity
                                                        <input type="number" class="form-control" id="qty" name="qty" placeholder="qty" value="1"></td>
                                                    <td> Due Amount
                                                        <input type="number" class="form-control" id="due_amount" name="due_amount" placeholder="due_amount" value="0"></td>
                                                    <td> Unit Price ($)
                                                        <input type="number" class="form-control" id="unit_price"  name="unit_price" placeholder="Unit Price $"></td>
                                                    <td><a href="#" id="addMore" class="btn btn-link btn-primary">Add More</a> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            <thead>
                                <div class="col-md-12">
                                    <tr>
                                        <th>Invoice Lines&nbsp;&nbsp;&nbsp;</th>
                                    
                                    </tr>
                                </div>
                            </thead>
                            <br>
                            <div class="col-md-12">
                                <table id="tbl_item" class="tbl table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Discount (%)</th>
                                            <th>Quantity</th>
                                            <th>Due Amount $</th>
                                            <th>Unit Pirce $</th>
                                            <th>Sub Total $</th>
                                            <th>{{$lb_action}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_item">
                                        
                                    </tbody>
                                </table>
                                <div id="total">0</div>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary" id="save_invoice" onclick="sinvoice()" type="button">{{$lb_save}}</button>
                            <button class="btn btn-danger" type="reset">{{$lb_cancel}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var burl = "{{url('/')}}";
    </script>
@endsection
@section('js')
    <script src="{{asset("chosen/chosen.jquery.js")}}"></script>
    <script src="{{asset("chosen/chosen.proto.js")}}"></script>
    <script src="{{asset("chosen/docsupport/init.js")}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        $("#invoice_date, #due_date").datepicker({
            orientation: 'bottom',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });

        $("#addMore").click(function () {
            var tr = $("#body_item").html();
            var itemid = $("#itemid").val();
            var item_name = $("#itemid :selected").text();
            var discount = $("#discount").val();
            var due_amount = $("#due_amount").val();
            var qty = $("#qty").val();
            var unit_price = $("#unit_price").val();
            var sub_total = qty * unit_price * (1 - discount / 100);
            var ntr = tr + "<tr row-index='"+ itemid+"'>";
            ntr += "<td>" + item_name + "</td>";
            ntr += "<td>" + discount + "</td>";
            ntr += "<td>" + qty + "</td>";
            ntr += "<td>" + due_amount + "</td>";
            ntr += "<td>" + unit_price + "</td>";
            ntr += "<td>" + sub_total + "</td>";
            ntr += "<td>" + '<a href="#" onclick="remove_item(this, event)"><i class="fa fa-remove text-danger"></i></a>' +"</td>"
            ntr += "</tr>";
            $("#body_item").html(ntr);
            total();
        });

    });

    function remove_item(obj, evt) {
        evt.preventDefault();
        $(obj).parent().parent().remove();
        total();
    }

    function change_item() {
        var id = $('#itemid').val();
        $.ajax({
            type : "GET",
            url : burl + "/getitem/" + id,
            success: function(data) {
                data = JSON.parse(data);
                $("#unit_price").val(data.price);
            }
        })
    }
    
    function total() {
        var total = 0;
        var trs = $("#body_item tr");
        for(var i=0; i<trs.length;i++)
        {
            var subtotal = $(trs[i]).children("td:nth(4)").html();
            total += Number(subtotal);
        }
        $("#total").html("$ " + total);
    }

    function sinvoice() {
        var data = {
            master:{
                customer_id: $("#customer_id").val(),
                invoice_date: $("#invoice_date").val(),
                due_date: $("#due_date").val(),
                invoice_ref: $("#invoice_ref").val()
            },
            items: []
        }
        var item = $("#body_item tr");
        for(var i=0; i<item.length; i++) 
        {
            var itemid =  $(item[i]).attr("row-index");
            var discount = $(item[i]).children("td:nth(1)").html();
            var qty = $(item[i]).children("td:nth(2)").html();
            var due_amount = $(item[i]).children("td:nth(3)").html();
            var unit_price = $(item[i]).children("td:nth(4)").html();
            var sub_total = $(item[i]).children("td:nth(5)").html();
            var item_data = {
                itemid: itemid,
                discount: discount,
                qty: qty,
                due_amount: due_amount,
                unit_price: unit_price,
                sub_total: sub_total
            }
            data.items.push(item_data);
        }
        console.log(data);
       // send data to server
       $.ajax({
            type: "POST",
            url: burl +"/invoice/save",
            data: data,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("input[name='_token']").val());
            },
            success: function (sms) {
                location.href = burl + "/invoice/create";
            },
            error: function(){
                location.href = burl + "/invoice/create";
            }
        });
    }
</script>

@endsection