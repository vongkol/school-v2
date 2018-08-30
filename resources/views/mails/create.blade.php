@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Create New Email &nbsp;&nbsp;
                    <a href="{{url('/mail')}}" class="btn btn-link btn-sm">Back To List</a>
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
                    <form action="{{url('/mail/send')}}" class="form-horizontal" method="post" onsubmit="return selectAll()">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label for="subject" class="control-label col-lg-2 col-sm-2">Subject</label>
                            <div class="col-sm-8">
                                <input type="text" name="subject" id="subject" required autofocus class="form-control" value="{{old('subject')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="other" class="control-label col-lg-2 col-sm-2">Other Email</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="other" name="other">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="btnAdd"> Add </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="list" class="control-label col-sm-2">Email List</label>
                            <div class="col-sm-8">
                                <select name="list[]" id="list" class="form-control" multiple  style="height: 200px;">
                                    @foreach($mails as $mail)
                                        <option value="{{$mail->email}}">{{$mail->email}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2"></label>
                            <div class="col-sm-8">
                              <button type="button" class="btn btn-danger" onclick="removeEmail()">Remove</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="control-label col-lg-2 col-sm-2">&nbsp;</label>
                            <div class=" col-sm-8">
                                <textarea name="description" id="description" cols="30" rows="10">
                                    {{old('description')}}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-lg-2 col-sm-2">&nbsp;</label>
                            <div class="col-sm-8">
                                <button class="btn btn-primary" type="submit">Send Now</button>
                                <button class="btn btn-danger" type="reset">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
@endsection
@section("js")
    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
    <script>
        var roxyFileman = "{{asset('fileman/index.html?integration=ckeditor')}}"; 
        CKEDITOR.replace('description',{filebrowserBrowseUrl:roxyFileman, 
                               filebrowserImageBrowseUrl:roxyFileman+'&type=image',
                               removeDialogTabs: 'link:upload;image:upload'});

        </script>
    <script>
        $(document).ready(function () {
          
            // onchange
            $("#send_to").change(function () {
                var id = $("#send_to").val();
                $.ajax({
                    type: "GET",
                    url: "{{url('/')}}" + "/mail/get/" + id,
                    success: function (sms) {
                       var option = "";
                       for(var i=0; i<sms.length;i++)
                       {
                           option += "<option value='" + sms[i].email + "'>" + sms[i].email + "</option>";
                       }
                       $("#list").html(option);
                    }
                });
            });
            // add email
            $("#btnAdd").click(function(){
                var m = $("#other").val();
                $("#list").prepend("<option value='" + m + "'>" + m + "</option>");
                $("#other").val("");
            });
        });
        function removeEmail() {
            $("#list option:selected").remove();
        }
        function selectAll() {
            $("#list option").prop("selected", false);
            $("#list option").attr("selected", "selected");
            return true;
        }
    </script>
  
@endsection
