<!doctype html>
<html lang="en">
<head>
<?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student List</title>
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
</head>
<body>
<?php 
    $grant_total = 0;
?>
    <p style="text-align: center;">
        <img src="{{asset('logo.png')}}" alt="Logo" width="130">
    </p>
    <h3 style="text-align:center" class="kh">Student List By Class - <span style="color: red;">@if($class!=null){{$classes->name}}@else All @endif</span></h3>
        @if ($classes==null)
        <?php $classes = DB::table('classes')->get();?>
        @else 
        <?php $classes = DB::table('classes')->where('id', $class)->get();?>
        @endif
        @foreach($classes as $cla)
        <?php 
            if($open_classes->start_date !== null && $open_classes->end_date !== null &&  $class !== null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("invoices", "students.id", "invoices.customer_id")
                ->join("invoice_detials", "invoices.id", "invoice_detials.invoice_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->where("invoices.active",1)
                ->whereDate('registrations.start_date','>=', $open_classes->start_date )
                ->whereDate('registrations.end_date','<=',  $open_classes->end_date ) 
                ->whereDate('invoices.invoice_date','>=', $open_classes->start_date )
                ->whereDate('invoices.due_date','<=',  $open_classes->end_date ) 
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'registrations.*', "invoices.*")
                ->orderBy('invoices.id', 'desc')
                ->get();
            }  
            $classes= DB::table('classes')
                ->where('id', $cla->id)
                ->first();
        ?> 
      
    <table class="tbl1">
    <span style="color:red;">{{$cla->name}}</span>
        <thead>
            <tr>
                <th>{!!$lb_id!!}</th>
                <th>Code</th>
                <th>Khmer Name</th>
                <th>English Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Study Time</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
                <th>Due Amount</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;
            $total = 0;
            ?>
            @foreach($students as $st)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$st->code}}</td>
                <td>{{$st->khmer_name}}</td>
                <td>{{$st->english_name}}</td>
                <td>{{$st->email}}</td>
                <td>{{$st->phone}}</td>
                <td>{{$st->gender=="Male"?"Male":"Female"}}</td>
                <td>{{$st->study_time}}</td>
                <td>{{$st->invoice_date}}</td>
                <td>{{$st->due_date}}</td>
                <td><span style="color: red;">$ {{$st->total_due_amount}}</span></td>
                <td><span style="color: green;">$ {{$st->total_amount}}</span></td>
                <?php $total+=$st->total_amount; ?>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <p style="float: right;"><b>Total Amount: $ {{$total}}</b></p><br>
        <?php $grant_total += $total; ?>
    @endforeach
    <hr style="width: 100%"> 
    <p  style="position: absolute;right: 10px; color: blue;"><b>Grand Total: $ {{$grant_total}}</b></p>
</body>
</html>