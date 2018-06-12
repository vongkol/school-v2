@extends('layouts.app')
@section('content')
<link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Edit Invoice&nbsp;&nbsp;
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
                    <form action="{{url('/invoice/update')}}" class="form-horizontal" method="post" enctype='multipart/form-data'>
                       <div class="row">
                           <div class="col-sm-6">
                               {{csrf_field()}}
                               <input type="hidden" value="{{$invoice->id}}" name="id">
                               <div class="form-group row">
                                   <label for="invoice_ref" class="control-label col-sm-3">Invoice Referentce</label>
                                   <div class="col-sm-9">
                                       <input type="text"  name="invoice_ref" id="invoice_ref" class="form-control" value="{{$invoice->invoice_ref}}">
                                   </div>
                               </div>
                               <?php $students = DB::table('students')->where('active',1)->orderBy('id','desc')->get();?>
                               <div class="form-group row">
                                   <label for="invoice_by" class="control-label col-sm-3">Invoice By <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <select name="invoice_by" id="invoice_by" class="form-control chosen-select">
                                           @foreach($students as $s)
                                           <option value="{{$s->id}}" {{$invoice->invoice_by==$s->id?'selected':''}}>{{$s->english_name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="invoice_date" class="control-label col-sm-3">Invoice Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required placeholder="yyyy-mm-dd" value="{{$invoice->invoice_date}}" name="invoice_date" id="invoice_date" class="form-control datepicker-icon"">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="due_date" class="control-label col-sm-3">Due Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required placeholder="yyyy-mm-dd" name="due_date" id="due_date" class="form-control datepicker-icon" value="{{$invoice->due_date}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="total_amount" class="control-label col-sm-3">Total Amount $ <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="number" step="0.1" required placeholder="USD" name="total_amount" id="total_amount" class="form-control" value="{{$invoice->total_amount}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="due_amount" class="control-label col-sm-3">Due Amount $ <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="number" step="0.1" required placeholder="USD" name="due_amount" id="due_amount" class="form-control" value="{{$invoice->due_amount}}">
                                   </div>
                               </div>
                               
                               <div class="form-group row">
                               <label class="control-label col-sm-3">&nbsp;</label>
                               <div class="col-sm-9">
                                   <button class="btn btn-primary" type="submit">Save Change</button>
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
    <script>
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
@endsection