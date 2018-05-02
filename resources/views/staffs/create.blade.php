@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> New Staff&nbsp;&nbsp;
                    <a href="{{url('/staff')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
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

                    <form action="{{url('/staff/save')}}" class="form-horizontal" method="post" enctype='multipart/form-data'>
                       <div class="row">
                           <div class="col-sm-6">
                               {{csrf_field()}}
                               <?php $branches  = DB::table('branches')->get();?>
                               <div class="form-group row">
                                   <label for="branch" class="control-label col-sm-3">Branch</label>
                                   <div class="col-sm-9">
                                       <select name="branch" id="branch" class="form-control">
                                           @foreach($branches as $branch)
                                           <option value="{{$branch->id}}">{{$branch->name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="first_name" class="control-label col-sm-3">First Name <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required autofocus name="first_name" id="first_name" class="form-control" value="{{old('first_name')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="family_name" class="control-label col-sm-3">Family Name <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" name="family_name" id="family_name" required class="form-control" value="{{old('family_name')}}">
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
                                   <label for="dob" class="control-label col-sm-3">{{$lb_dob}} <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text"  name="dob" id="dob" required class="form-control" value="{{old('dob')}}" placeholder="dd/mm/yyyy">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="pob" class="control-label col-sm-3">{{$lb_pob}}</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="pob" id="pob" class="form-control" value="{{old('pob')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="join_date" class="control-label col-sm-3">Join Date <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                   <input type="text"  name="join_date" required id="join_date" class="form-control" value="{{old('join_date')}}" placeholder="dd/mm/yyyy">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="current_address" class="control-label col-sm-3">Current Address</label>
                                   <div class="col-sm-9">
                                   <input type="text" name="current_address" id="current_address" class="form-control" value="{{old('current_address')}}">
                                   </div>
                               </div>
                           </div>
                           <div class="col-sm-6">
                               <div class="form-group row">
                                   <label for="email" class="control-label col-sm-3">Email <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required autofocus name="email" id="email" class="form-control" value="{{old('email')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="phone" class="control-label col-sm-3">Phone</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="nationality" class="control-label col-sm-3">Nationality <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" name="nationality" required id="nationality" class="form-control" value="{{old('nationality')}}">
                                   </div>
                               </div>
                               <?php $positions  = DB::table('positions')->where('active',1)->get();?>
                               <div class="form-group row">
                                   <label for="position" class="control-label col-sm-3">Position</label>
                                   <div class="col-sm-9">
                                       <select name="position" id="position" class="form-control">
                                           @foreach($positions as $position)
                                           <option value="{{$position->id}}">{{$position->name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="salary" class="control-label col-sm-3">Salary</label>
                                   <div class="col-sm-9">
                                       <input type="text"  name="salary" id="salary" class="form-control" value="{{old('salary')}}" placeholder="00.00$">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="photo" class="control-label col-sm-3">{{$lb_photo}}</label>
                                   <div class="col-sm-9">
                                       <input type="file" name="photo" id="photo" class="form-control" onchange="loadFile(event)">
                                       <br>
                                       <img src="{{asset('staffs/default.png')}}" alt="" id="preview" height="100">
                                   </div>
                               </div>
                           </div>
                            <div class="col-sm-6">
                               <div class="form-group row">
                                   <label class="control-label col-sm-3">&nbsp;</label>
                                   <div class="col-sm-9">
                                       <button class="btn btn-primary" type="submit">{{$lb_save}}</button>
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
<script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>
<script>
    function loadFile(e){
        var output = document.getElementById('preview');
        output.src = URL.createObjectURL(e.target.files[0]);
    }
    $(document).ready(function(){
        $("#dob").inputmask("99/99/9999");
        $("#join_date").inputmask("99/99/9999");
    });
</script>
@endsection