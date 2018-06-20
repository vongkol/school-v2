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
                                   <label for="invoice_by" class="control-label col-sm-3">Invoice By <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <select name="invoice_by" id="invoice_by" class="form-control chosen-select">
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
                                            <thead>
                                                <tr>
                                                    <th>Invoice Lines&nbsp;&nbsp;&nbsp;<a href="#" id="addMore" class="btn btn-link btn-primary">Add More</a></th>
                                                
                                                </tr>
                                            </thead>
                                            <?php 
                                                $items = DB::table('items')->join('branches', 'branches.id', '=', 'items.branch_id')
                                                ->select('items.*', 'branches.name as branch_id')
                                                ->where('items.active',1)->orderBy('items.id', 'desc')->get(); 

                                                $item_price = DB::table('items')->join('branches', 'branches.id', '=', 'items.branch_id')
                                                ->select('items.*', 'branches.name as branch_id')
                                                ->where('items.active',1)->orderBy('items.id', 'desc')->first(); 

                                                ?>
                                            <tbody id="data">
                                                <tr>
                                                    <td>
                                                        Item<br>
                                                        <select class="form-control chosen-select" id="item" name="item">
                                                        @foreach($items as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                  
                                                </td>
                                                    <td> Discount
                                                        <input type="number" class="form-control" name="discount" step="0.1" placeholder="discount %"></td>
                                                    <td> Quantity
                                                        <input type="number" class="form-control" name="qty" placeholder="qty" value="1"></td>
                                                    <td> Unit Price ($)
                                                        <input type="number" class="form-control" name="unit_price" value="{{$item_price->price}}" placeholder="Unit Price $"></td>
                                                    <td><a href="#" class="btn btn-xs btn-danger" onclick='rmRow(this,event)'>Delete</a> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                              
                        <div class="col-md-6">
                               <div class="form-group row">
                               <label class="control-label col-sm-3">&nbsp;</label>
                               <div class="col-sm-9">
                                   <button class="btn btn-primary" type="submit">{{$lb_save}}</button>
                                   <button class="btn btn-danger" type="reset">{{$lb_cancel}}</button>
                               </div>
                               </div>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset("chosen/chosen.jquery.js")}}"></script>
    <script src="{{asset("chosen/chosen.proto.js")}}"></script>
    <script src="{{asset("chosen/docsupport/init.js")}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>
    <script>
        $('#item').on('change', function() {
            
        });
    $(document).ready(function(){
        $("#invoice_date, #due_date").datepicker({
                orientation: 'bottom',
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                toggleActive: true
            });
    });
</script>
<script>
        var burl = "{{url('/')}}";
        $(document).ready(function(){
            $("#dob").inputmask('99/99/9999');
            $(".yy").inputmask('9999 - 9999');
            // add more eduction record
            $("#addMore").click(function (event) {
                event.preventDefault();
                var counter = $("#data tr").length + 1;
                var unit_price = "{{$item_price->price}}";
                var tr = "";
                tr += "<tr>";
                tr += "<td>" + "<input type='text' class='form-control yy' placeholder='' order='" + counter + "'>" + "</td>";
                tr += "<td>" + " <input type='number' class='form-control' name='discount' step='0.1' placeholder='discount %'></td>" + "</td>";
                tr += "<td>" + " <input type='number' class='form-control' name='qty' placeholder='qty' value='1'></td>"+"</td>";
                tr += "<td>" + " <input type='number' class='form-control' name='unit_price' value='" + unit_price +"' placeholder='Unit Price $' +</td>"
                tr += "<td>" + "<a href='#' class='btn btn-danger' onclick='rmRow(this,event)'>Delete</a>" +"</td>";
                tr += "</tr>";
                if($("#data tr").length>0)
                {
                    $("#data tr:last-child").after(tr);
                }
                else{
                    $("#data").html(tr);
                }
            });
        });
        // function to remove row
        function rmRow(obj, evt) {
            evt.preventDefault();
            var tr = $(obj).parent().parent();
            tr.remove();
        }
    </script>
@endsection