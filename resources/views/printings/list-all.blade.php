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
    <p style="text-align: center;">
        <img src="{{asset('img/cocd.jpg')}}" alt="Logo" width="130">
    </p>
    <h3 style="text-align:center" class="kh">បញ្ជីឈ្មោះសិស្សសរុប</h3>
    <table class="tbl1">
        <thead>
            <tr>
                <th>ល.រ</th>
                <th>លេខកូដ</th>
                <th>ឈ្មោះខ្មែរ</th>
                <th>ឈ្មោះអង់គ្លេស</th>
                <th>ភេទ</th>
                <th>ថ្ងៃខែឆ្នាំកំណើត</th>
                <th>អាស័យដ្ឋាន</th>
                <th>ឈ្មោះសាលា</th>
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
                <td>{{$st->gender=="Male"?"ប្រុស":"ស្រី"}}</td>
                <td>{{$st->dob}}</td>
                <td>{{$st->address}}</td>
                <td>{{$st->bname}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3>
        សិស្សសរុប៖ {{$total}} នាក់, ស្រី៖ {{$female}} នាក់, ប្រុស៖ {{$male}} នាក់
    </h3>
</body>
</html>