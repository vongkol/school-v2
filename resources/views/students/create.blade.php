@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> {{$lb_new_student}}&nbsp;&nbsp;
                    <a href="{{url('/student')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
                </div>
                <div class="card-block">
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

                    <form action="{{url('/student/save')}}" class="form-horizontal" method="post" enctype='multipart/form-data'>
                       <div class="row">
                           <div class="col-sm-6">
                               {{csrf_field()}}
                               <div class="form-group row">
                                   <label for="code" class="control-label col-sm-3">{{$lb_code}}​ <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required autofocus name="code" id="code" class="form-control" value="{{old('code')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="khmer_name" class="control-label col-sm-3">{{$lb_khmer_name}}</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="khmer_name" id="khmer_name" class="form-control" value="{{old('khmer_name')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="english_name" class="control-label col-sm-3">{{$lb_english_name}}</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="english_name" id="english_name" class="form-control" value="{{old('english_name')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="gender" class="control-label col-sm-3">{{$lb_gender}}</label>
                                   <div class="col-sm-9">
                                       <select name="gender" id="gender" class="form-control">
                                           <option value="Male">{{$lb_male}}</option>
                                           <option value="Female">{{$lb_female}}</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="dob" class="control-label col-sm-3">{{$lb_dob}}</label>
                                   <div class="col-sm-9">
                                       <input type="text"  name="dob" id="dob" class="form-control" value="{{old('dob')}}" placeholder="dd/mm/yyyy">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="pob" class="control-label col-sm-3">{{$lb_pob}}</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="pob" id="pob" class="form-control" value="{{old('pob')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label class="control-label col-sm-3">&nbsp;</label>
                                   <div class="col-sm-9">
                                       <button class="btn btn-primary" type="submit">{{$lb_save}}</button>
                                       <button class="btn btn-danger" type="reset">{{$lb_cancel}}</button>
                                   </div>
                               </div>
                           </div>

                           <div class="col-sm-6">
                               <div class="form-group row">
                                   <label for="phone" class="control-label col-sm-3">{{$lb_phone}}</label>
                                   <div class="col-sm-9">
                                       <input type="text" autofocus name="phone" id="phone" class="form-control" value="{{old('phone')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="email" class="control-label col-sm-3">{{$lb_email}}</label>
                                   <div class="col-sm-9">
                                       <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                                   </div>
                               </div>
                                <div class="form-group row">
                                   <label for="current_address" class="control-label col-sm-3">{{$lb_current_address}}</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="current_address" id="current_address" class="form-control" value="{{old('current_address')}}">
                                   </div>
                               </div>
                                <div class="form-group row">
                                   <label for="branch" class="control-label col-sm-3">{{$lb_branch}}</label>
                                   <div class="col-sm-9">
                                       <select id="branch" name="branch" class="form-control">
                                            @foreach($branches as $b)
                                            <option value="{{$b->id}}">{{$b->name}}</option>
                                            @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="photo" class="control-label col-sm-3">{{$lb_photo}}</label>
                                   <div class="col-sm-9">
                                       <input type="file" name="photo" id="photo" class="form-control" onchange="loadFile(event)">
                                       <br>
                                       <img src="" alt="" id="preview" width="150">
                                   </div>
                               </div>
                           </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
    {{--  <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-controls="home">Family</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="profile">Health</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages" role="tab" aria-controls="messages">Documents</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel">
                    1. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
                <div class="tab-pane" id="profile" role="tabpanel">
                    2. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
                <div class="tab-pane" id="messages" role="tabpanel">
                    3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                    dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
        </div>

    </div>  --}}
@endsection
@section('js')
<script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>
<script>
    function loadFile(e){
        var output = document.getElementById('preview');
        output.src = URL.createObjectURL(e.target.files[0]);
    }
    $(document).ready(function(){
        $("#dob").inputmask("99/99/9999");
    });
</script>
@endsection