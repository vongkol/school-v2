
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            text-align: left;
            padding: 8px;
        }
        
        tr:nth-child(even){background-color: #f2f2f2}
        table, td, th {
            border: 1px solid #ccc;
        }
        th {
            background-color: #eee;
            color: #000;
        }
        .container {
            width: 85%;
            margin: 0 auto;
            height: 500px;
          
        }
        @media print {
            table {
                border-collapse: collapse;
                width: 100%;
                font-size: 13px;
            }
            label {
                padding-right: 10px;
                font-weight: 500;
               font-size: 13px;
            }
            .container {
                width: 85%;
                margin: 0 auto;
                height: 50%;
            }
            th, td {
                text-align: left;
                padding: 8px;
            }
            
            tr:nth-child(even){background-color: #f2f2f2}
            table, td, th {
                border: 1px solid #ccc;
            }
            th {
                background-color: #eee;
                color: #000;
            }
            .invoice-text{
                font-size: 16px;
            }
        }
      
        .text-center {
            text-align: center;
        }
        label {
            padding-right: 10px;
            font-weight: 500;
        }
        .form-group {
            padding: 10px 0;
        }
        .invoice-text{
            font-size: 20px;
        }
    </style>
    <div class="container">
        <div class="col-lg-12">
            <div class="text-center">
                <img src="{{url('logo.png')}}" alt="" width="100">
            </div>
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            {{csrf_field()}}
                            <div class="row">
                               <b class="invoice-text">Invoice Reference {!!$lb_id!!} : {{$invoice->invoice_ref}}</b><br>
                            </div>
                            <div class="form-group row">
                                <label for="invoice_ref" class="control-label col-sm-6">Student Code :  {{$invoice->code}}</label>
                                <label for="invoice_by" class="control-label col-sm-6">Student : {{$invoice->english_name}}</label>
                                <label for="invoice_date" class="control-label col-sm-6">Invoice Date : {{$invoice->invoice_date}}</label>
                                <label for="due_date" class="control-label col-sm-6">Due Date:    {{$invoice->due_date}}</label>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $invoice_details = DB::table('invoice_detials')
                            ->join('items', 'invoice_detials.item_id', 'items.id')
                            ->select('items.*', 'invoice_detials.*', 'items.name as item_name')
                            ->where('invoice_detials.invoice_id' , $invoice->invoice_id)
                            ->where('invoice_detials.active',1)
                            ->get();
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                             
                                    <table class="tbl table">
                                        <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Discount (%)</th>
                                            <th>Quantity</th>
                                            <th>Due Amount ($)</th>
                                            <th>Unit Price ($)</th>
                                            <th>Sub Total ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($invoice_details as $invoice_detail)
                                            <tr>
                                                <td>{{$invoice_detail->item_name}}</td>
                                                <td>{{$invoice_detail->discount}} %</td>
                                                <td>{{$invoice_detail->qty}}</td>
                                                <td>@if($invoice_detail->due_amount != 0)<span class="text-danger"> @endif $ {{$invoice_detail->due_amount}} @if($invoice_detail->due_amount != 0)</span>@endif</td>
                                                <td>$ {{$invoice_detail->unit_price}}</td>
                                                <td>$ {{$invoice_detail->subtotal}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table class="table text-right">
                                        <td width="80%"><div class="text-left">Note: <span class="text-danger">{{$invoice->note}}</span></div></td>
                                        <td width="20%"><b>Total Amount<div id="total" class="text-primary">$ {{$invoice->total_amount}}</div></b></td>
                                    </table>
                                </div>
                                <div width="100%"><br>
                                    <div align="right">
                                        <label>invoice by : {{$invoice->invoice_by}} <span style="color:red;">Total Due Amount :{{ $invoice->total_due_amount}} $</span></label>
                                    </div>
                                    @if(count($histories)>0)
                                    <div class="row">
                                        <div class="col-sm-8" style="width:500px; margin-top: -40px;">
                                            <h5>Payment History</h5>
                                            <table class="table" >
                                                <thead>
                                                    <tr>
                                                        <th>&numero;</th>
                                                        <th>Pay Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php($i=1)
                                                @foreach($histories as $h)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>{{$h->pay_date}}</td>
                                                        <td>{{$h->amount}} $</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                        </table>
                                        </div>
                                    </div>   
                                   
                                    @endif
                                    <div align="left">
                                        <label>Branch : {{$branch->name}} -  {{$branch->address}} </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="container">
        <div class="col-lg-12">
            <div class="text-center">
                <img src="{{url('logo.png')}}" alt="" width="100">
            </div>
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            {{csrf_field()}}
                            <div class="row">
                               <b class="invoice-text">Invoice Reference {!!$lb_id!!} : {{$invoice->invoice_ref}}</b><br>
                            </div>
                            <div class="form-group row">
                                <label for="invoice_ref" class="control-label col-sm-6">Student Code :  {{$invoice->code}}</label>
                                <label for="invoice_by" class="control-label col-sm-6">Student : {{$invoice->english_name}}</label>
                                <label for="invoice_date" class="control-label col-sm-6">Invoice Date : {{$invoice->invoice_date}}</label>
                                <label for="due_date" class="control-label col-sm-6">Due Date:    {{$invoice->due_date}}</label>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $invoice_details = DB::table('invoice_detials')
                            ->join('items', 'invoice_detials.item_id', 'items.id')
                            ->select('items.*', 'invoice_detials.*', 'items.name as item_name')
                            ->where('invoice_detials.invoice_id' , $invoice->invoice_id)
                            ->where('invoice_detials.active',1)
                            ->get();
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                             
                                    <table class="tbl table">
                                        <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Discount (%)</th>
                                            <th>Quantity</th>
                                            <th>Due Amount ($)</th>
                                            <th>Unit Price ($)</th>
                                            <th>Sub Total ($)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($invoice_details as $invoice_detail)
                                            <tr>
                                                <td>{{$invoice_detail->item_name}}</td>
                                                <td>{{$invoice_detail->discount}} %</td>
                                                <td>{{$invoice_detail->qty}}</td>
                                                <td>@if($invoice_detail->due_amount != 0)<span class="text-danger"> @endif $ {{$invoice_detail->due_amount}} @if($invoice_detail->due_amount != 0)</span>@endif</td>
                                                <td>$ {{$invoice_detail->unit_price}}</td>
                                                <td>$ {{$invoice_detail->subtotal}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table class="table text-right">
                                        <td width="80%"><div class="text-left">Note: <span class="text-danger">{{$invoice->note}}</span></div></td>
                                        <td width="20%"><b>Total Amount<div id="total" class="text-primary">$ {{$invoice->total_amount}}</div></b></td>
                                    </table>
                                </div>
                                <div width="100%"><br>
                                <div align="right">
                                        <label>invoice by : {{$invoice->invoice_by}} <span style="color:red;">Total Due Amount :{{ $invoice->total_due_amount}} $</span></label>
                                    </div>
                                    @if(count($histories)>0)
                                    <div class="row">
                                        <div class="col-sm-8" style="width:500px; margin-top: -40px;">
                                            <h5>Payment History</h5>
                                            <table class="table" >
                                                <thead>
                                                    <tr>
                                                        <th>&numero;</th>
                                                        <th>Pay Date</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @php($i=1)
                                                @foreach($histories as $h)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>{{$h->pay_date}}</td>
                                                        <td>{{$h->amount}} $</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                        </table>
                                        </div>
                                    </div>   
                                   
                                    @endif
                                    <div align="left">
                                        <label>Branch : {{$branch->name}} -  {{$branch->address}} </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>