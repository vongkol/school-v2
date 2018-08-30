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
<style media="print">
    table, tr, td {
        font-size: 12px;
    }
</style>
<body>
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <p style="text-align: center;">
        <img src="{{asset('logo.png')}}" alt="Logo" width="130">
    </p>
    <h3 style="text-align:center" class="kh">List All Student</h3>
    <table class="tbl1">
        <thead>
            <tr>
                <th>{!!$lb_id!!}</th>
                <th>Code</th>
                <th>Khmer Name</th>
                <th>English Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>University</th>
                <th>Branch</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1;?>
            @foreach($students as $st)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$st->code}}</td>
                <td>{{$st->khmer_name}}</td>
                <td>{{$st->english_name}}</td>
                <td>{{$st->email}}</td>
                <td>{{$st->phone}}</td>
                <td>{{$st->gender=="Male"?"ប្រុស":"ស្រី"}}</td>
                <td>{{$st->dob}}</td>
                <td>{{$st->university}}</td>
                <td>{{$st->bname}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3>
        Total Students៖ {{$total}}, Female៖ {{$female}}, Male៖ {{$male}}
    </h3>
</body>
</html>