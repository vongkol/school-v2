<!doctype html>
<html lang="en">
<head>
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
    <h3 style="text-align:center" class="kh">Student List By Receptionist - <span style="color: red;">@if($receptionist!=null){{$recept->name}}@else All @endif</span></h3>
        @if ($receptionist==null)
        <?php $users = DB::table('users')->where('role_id', 2)->get();?>
        @else 
        <?php $users = DB::table('users')->where('role_id', 2)->where('id', $recept->id)->get();?>
        @endif
        @foreach($users as $user)
        <?php 
            if($start_date !== null && $end_date !== null &&  $receptionist !== null ) {
            $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("invoices", "students.id", "invoices.customer_id")
                ->where("invoices.active",1)
                ->whereDate('invoices.invoice_date','>=', $start_date )
                ->whereDate('invoices.invoice_date','<=', $end_date ) 
                ->where('invoices.invoice_by', $user->id)
                ->whereIn('students.branch_id', $user_brand)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'invoices.*')
                ->orderBy('invoices.invoice_date', 'desc')
                ->get();
            }
            elseif($start_date !== null && $end_date !== null && $receptionist == null) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("invoices", "students.id", "invoices.customer_id")
                ->where("invoices.active",1)
                ->whereIn('students.branch_id', $user_brand)
                ->whereDate('invoices.invoice_date','>=', $start_date )
                ->whereDate('invoices.invoice_date','<=', $end_date ) 
                ->where('invoices.invoice_by', $user->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'invoices.*')
                ->orderBy('invoices.invoice_date', 'desc')
                ->get(); 
            } elseif ($start_date == null && $end_date == null && $receptionist == null)
            {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("invoices", "students.id", "invoices.customer_id")
                ->where("invoices.active",1)
                ->whereIn('students.branch_id', $user_brand)
                ->where('invoices.invoice_by', $user->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'invoices.*')
                ->orderBy('invoices.invoice_date', 'desc')
                ->get();
            }   elseif($start_date == null && $end_date == null && $receptionist !== null) {
                $students = DB::table('students')
                    ->join("branches", "students.branch_id", "branches.id")
                    ->join("invoices", "students.id", "invoices.customer_id")
                    ->where("invoices.active",1)
                    ->where('invoices.invoice_by', $user->id)
                    ->whereIn('students.branch_id', $user_brand)
                    ->where('students.active',1)
                    ->select('students.*', 'branches.name as bname', 'invoices.*')
                    ->orderBy('invoices.invoice_date', 'desc')
                    ->get();
            } 
            elseif($start_date == null && $end_date !== null && $receptionist !== null) {
                $students = DB::table('students')
                    ->join("branches", "students.branch_id", "branches.id")
                    ->join("invoices", "students.id", "invoices.customer_id")
                    ->where("invoices.active",1)
                    ->whereDate('invoices.invoice_date','<=', $end_date ) 
                    ->where('invoices.invoice_by', $user->id)
                    ->whereIn('students.branch_id', $user_brand)
                    ->where('students.active',1)
                    ->select('students.*', 'branches.name as bname', 'invoices.*')
                    ->orderBy('invoices.invoice_date', 'desc')
                    ->get();
            } 
            elseif($start_date !== null && $end_date == null && $receptionist !== null) {
                $students = DB::table('students')
                    ->join("branches", "students.branch_id", "branches.id")
                    ->join("invoices", "students.id", "invoices.customer_id")
                    ->where("invoices.active",1)
                    ->whereDate('invoices.invoice_date','>=', $start_date ) 
                    ->where('invoices.invoice_by', $user->id)
                    ->where('students.active',1)
                    ->whereIn('students.branch_id', $user_brand)
                    ->select('students.*', 'branches.name as bname', 'invoices.*')
                    ->orderBy('invoices.invoice_date', 'desc')
                    ->get();
            }
            elseif($start_date == null && $end_date !== null && $receptionist !== null) {
                $students = DB::table('students')
                    ->join("branches", "students.branch_id", "branches.id")
                    ->join("invoices", "students.id", "invoices.customer_id")
                    ->where("invoices.active",1)
                    ->whereDate('invoices.invoice_date','<=', $end_date ) 
                    ->where('invoices.invoice_by', $user->id)
                    ->whereIn('students.branch_id', $user_brand)
                    ->where('students.active',1)
                    ->select('students.*', 'branches.name as bname', 'invoices.*')
                    ->orderBy('invoices.invoice_date', 'desc')
                    ->get();
            } 
            elseif($start_date !== null && $end_date == null && $receptionist !== null) {
                $students = DB::table('students')
                    ->join("branches", "students.branch_id", "branches.id")
                    ->join("invoices", "students.id", "invoices.customer_id")
                    ->where("invoices.active",1)
                    ->whereDate('invoices.invoice_date','>=', $start_date ) 
                    ->where('invoices.invoice_by', $user->id)
                    ->where('students.active',1)
                    ->whereIn('students.branch_id', $user_brand)
                    ->select('students.*', 'branches.name as bname', 'invoices.*')
                    ->orderBy('invoices.invoice_date', 'desc')
                    ->get();
            } 
            elseif($start_date !== null && $end_date == null && $receptionist == null) {
                $students = DB::table('students')
                    ->join("branches", "students.branch_id", "branches.id")
                    ->join("invoices", "students.id", "invoices.customer_id")
                    ->where("invoices.active",1)
                    ->whereDate('invoices.invoice_date','>=', $start_date ) 
                    ->where('invoices.invoice_by', $user->id)
                    ->whereIn('students.branch_id', $user_brand)
                    ->where('students.active',1)
                    ->select('students.*', 'branches.name as bname', 'invoices.*')
                    ->orderBy('invoices.invoice_date', 'desc')
                    ->get();
            } 
            elseif($start_date == null && $end_date !== null && $receptionist == null) {
                $students = DB::table('students')
                    ->join("branches", "students.branch_id", "branches.id")
                    ->join("invoices", "students.id", "invoices.customer_id")
                    ->where("invoices.active",1)
                    ->whereDate('invoices.invoice_date','<=', $end_date ) 
                    ->where('invoices.invoice_by', $user->id)
                    ->where('students.active',1)
                    ->whereIn('students.branch_id', $user_brand)
                    ->select('students.*', 'branches.name as bname', 'invoices.*')
                    ->orderBy('invoices.invoice_date', 'desc')
                    ->get();
            } 
            $receptionist= DB::table('users')
                ->where('id', $user->id)
                ->first();
        ?> 
      
    <table class="tbl1">
    <span style="color:red;">{{$receptionist->name}}</span>
        <thead>
            <tr>
                <th>ល.រ</th>
                <th>Code</th>
                <th>Khmer Name</th>
                <th>English Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Invoice Reference</th>
                <th>Invoice Date</th>
                <th>Due Amount</th>
                <th>Total Amount $</th>
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
                <td>{{$st->invoice_ref}}</td>
                <td>{{$st->invoice_date}}</td>
                <td>$ {{$st->total_due_amount}}</td>
                <td>$ {{$st->total_amount}} </td>
                <?php $total+=$st->total_amount; ?>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="float: right;"><b>Total Amount: $ {{$total}}</b></p><br>
        <?php $grant_total += $total; ?>
    
    @endforeach
    <hr style="width: 100%"> 
    <p  style="position: absolute;right: 10px; color: blue;"><b>Grand Total: $ {{$grant_total}}</b></p>
  
</body>
</html>