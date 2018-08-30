@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> E-Mail List
                    <a href="{{url('/mail/create')}}" class="btn btn-link btn-sm">Compose</a>
                </div>
                <div class="card-block">
                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Send To</th>
                            <th>Send Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i=1)
                            @foreach($mails as $mail)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td><a href="{{url('mail/detail/'.$mail->id)}}">{{$mail->subject}}</a></td>
                                    <td>{{$mail->send_to}}</td>
                                    <td>{{$mail->send_date}}</td>
                                    <td>
                                        <a href="{{url('/mail/delete/'.$mail->id)}}" onclick="return confirm('You want to delete this message?')"><i class="fa fa-remove text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p>
                        {{$mails->links()}}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection