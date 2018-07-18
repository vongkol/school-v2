@extends('layouts.app')
@section('content')
<?php
if(Auth::user()->language == 'kh')
{
    include(app_path(). "/lang/kh.php");
    include(app_path(). "/lang/students/kh.student.php");
}
else{
    include(app_path(). "/lang/en.php");
    include(app_path(). "/lang/students/en.student.php");
}
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i>User Action -  Detail Staff&nbsp;&nbsp;
                    <a href="{{url('/log')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a> 
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
                    <form class="form-horizontal">
                       <div class="row">
                           <div class="col-sm-6">
                               {{csrf_field()}}
                               <?php $branches  = DB::table('branches')->get();?>
                               <div class="form-group row">
                                   <label for="branch" class="control-label col-sm-3">Branch</label>
                                   <div class="col-sm-9">
                                       <select name="branch" id="branch" disabled class="form-control">
                                           @foreach($branches as $branch)
                                           <option value="{{$branch->id}}" {{$staff->branch_id==$branch->id?'selected':''}}>{{$branch->name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <input type="hidden" value="{{$staff->id}}" id="staff_id">
                               <div class="form-group row">
                                   <label for="first_name" class="control-label col-sm-3">First Name</label>
                                   <label class="control-label col-sm-9">: {{$staff->first_name}}</label>
                               </div>
                               <div class="form-group row">
                                   <label for="family_name" class="control-label col-sm-3">Family Name</label>
                                   <label class="control-label col-sm-9">: {{$staff->family_name}}</label>
                               </div>
                               <div class="form-group row">
                                   <label for="email" class="control-label col-sm-3">Email</label>
                                   <label class="control-label col-sm-9">: {{$staff->email}}</label>
                               </div>
                               <div class="form-group row">
                                   <label for="nationality" class="control-label col-sm-3">Nationality</label>
                                   <label class="control-label col-sm-9">: {{$staff->nationality}}</label>
                               </div>   
                               <div class="form-group row">
                                   <label for="gender" class="control-label col-sm-3">{{$lb_gender}}</label>
                                   <label class="control-label col-sm-9">: {{$staff->gender}}</label>
                               </div>
                               <div class="form-group row">
                                   <label for="dob" class="control-label col-sm-3">{{$lb_dob}}</label>
                                   <label class="control-label col-sm-9">: {{$staff->dob}}</label>
                               </div>
                               <div class="form-group row">
                                   <label for="join_date" class="control-label col-sm-3">Join Date</label>
                                   <label class="control-label col-sm-9">: {{$staff->join_date}}</label>
                               </div>
                              
                           </div>
                           <div class="col-sm-6">
                               <div class="form-group row">
                                   <label for="phone" class="control-label col-sm-3">Phone</label>
                                   <label class="control-label col-sm-9">: {{$staff->phone}}</label>
                               </div>
                               <div class="form-group row">
                                   <label for="pob" class="control-label col-sm-3">{{$lb_pob}}</label>
                                   <label class="control-label col-sm-9">: {{$staff->pob}}</label>
                               </div>
                               <div class="form-group row">
                                   <label for="current_address" class="control-label col-sm-3">Current Address</label>
                                   <label class="control-label col-sm-9">: {{$staff->current_address}}</label>
                               </div>
                               <?php $positions  = DB::table('positions')->where('active',1)->get();?>
                               <div class="form-group row">
                                   <label for="position" class="control-label col-sm-3">Position</label>
                                   <div class="col-sm-9">
                                       <select name="position" id="position" disabled class="form-control">
                                           @foreach($positions as $position)
                                           <option value="{{$position->id}}" {{$position->id==$staff->position_id?'selected':''}}>{{$position->name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="salary" class="control-label col-sm-3">Salary ($)</label>
                                   <label class="control-label col-sm-9">: {{$staff->salary}}</label>
                               </div>
                               <div class="form-group row">
                                   <div class="col-sm-9">
                                       <img src="{{asset('staffs/'.$staff->photo)}}" alt="" id="preview" height="100">
                                   </div>
                               </div>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
                    <div class="col-sm-12">

                        
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="profile">
                              
                                <table class="tbl table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>File Name</th>
                                        <th>{{$lb_action}}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="docData">
                                    @foreach($documents as $doc)
                                        <tr id="{{$doc->id}}">
                                            <td>{{$doc->description}}</td>
                                            <td>
                                                <a href="{{asset('documents/'.$doc->file_name)}}" target="_blank">
                                                {{$doc->file_name}}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" onclick="deleteDoc(this,event)">
                                                    <i class="fa fa-remove text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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

@endsection
