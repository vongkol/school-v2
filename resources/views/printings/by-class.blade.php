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
    <h3 style="text-align:center" class="kh">Student List By Class - <span style="color: red;">@if($class!=null){{$classes->name}}@else All @endif</span></h3>
        @if ($classes==null)
        <?php $classes = DB::table('classes')->get();?>
        @else 
        <?php $classes = DB::table('classes')->where('id', $class)->get();?>
        @endif
        @foreach($classes as $cla)
        <?php 
            if($start_date !== null && $end_date !== null &&  $class == null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->whereDate('registrations.start_date','>=', $start_date )
                ->whereDate('registrations.end_date','<=', $end_date ) 
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                // ->orderBy('students.english_name')
                ->orderBy('school_years.name', 'desc')
                ->get();
            }
            elseif($start_date !== null && $end_date !== null &&  $class !== null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->whereDate('registrations.start_date','>=', $start_date )
                ->whereDate('registrations.end_date','<=', $end_date ) 
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*')
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                ->orderBy('registrations.end_date', 'desc')
                ->orderBy('school_years.name', 'desc')
                ->get();
            } 
            elseif($start_date !== null && $end_date == null &&  $class !== null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->whereDate('registrations.start_date','>=', $start_date )
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                ->orderBy('registrations.end_date', 'desc')
                ->orderBy('school_years.name', 'desc')
                ->get();
            }   elseif($start_date == null && $end_date !== null &&  $class !== null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->whereDate('registrations.end_date','<=', $end_date )
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                ->orderBy('registrations.end_date', 'desc')
                ->orderBy('school_years.name', 'desc')
                ->get();
            }
            elseif($start_date == null && $end_date == null &&  $class !== null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                ->orderBy('registrations.end_date', 'desc')
                ->orderBy('school_years.name', 'desc')
                ->get();
            }
            elseif($start_date !== null && $end_date == null &&  $class == null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->whereDate('registrations.start_date','>=', $start_date )
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                ->orderBy('registrations.end_date', 'desc')
                ->orderBy('school_years.name', 'desc')
                ->get();
            }  
            elseif($start_date !== null && $end_date == null &&  $class !== null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->whereDate('registrations.start_date','>=', $start_date )
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                ->orderBy('registrations.end_date', 'desc')
                ->orderBy('school_years.name', 'desc')
                ->get();
            }  
            elseif($start_date == null && $end_date !== null &&  $class == null ) {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->whereDate('registrations.end_date','<=', $end_date )
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                ->orderBy('registrations.end_date', 'desc')
                ->orderBy('school_years.name', 'desc')
                ->get();
            }  else {
                $students = DB::table('students')
                ->join("branches", "students.branch_id", "branches.id")
                ->join("registrations", "students.id", "registrations.student_id")
                ->join("classes", "classes.id", "registrations.class_id")
                ->join("school_years", "school_years.id", "registrations.year_id")
                ->where("registrations.active",1)
                ->where("classes.active", 1)
                ->where('registrations.class_id', $cla->id)
                ->where('students.active',1)
                ->select('students.*', 'branches.name as bname', 'classes.*', 'registrations.*', "school_years.*")
                ->orderBy('registrations.end_date', 'desc')
                ->orderBy('school_years.name', 'desc')
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
                <th>ល.រ</th>
                <th>Code</th>
                <th>Khmer Name</th>
                <th>English Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Branch</th>
                <th>Study Time</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Year</th>
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
                <td>{{$st->bname}}</td>
                <td>{{$st->study_time}}</td>
                <td>{{$st->start_date}}</td>
                <td>{{$st->end_date}}</td>
                <td>{{$st->name}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    @endforeach
</body>
</html>