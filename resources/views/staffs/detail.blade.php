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
                    <i class="fa fa-align-justify"></i> Detail Staff&nbsp;&nbsp;
                    <a href="{{url('/staff')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a> | <a href="{{url('/staff/edit/'.$staff->id)}}"  class="btn btn-link btn-sm text-danger"><i class="fa fa-edit"></i> Edit</a>
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

                        <ul class="nav nav-tabs" role="tablist">
                            
                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Document</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="profile">
                                <p>
                                    <button type="button" id="btnAddDocument" class="btn btn-sm btn-success" data-toggle="modal" data-target="#docModal">{{$lb_add}}</button>
                                </p>
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
@section('modal')
    <!-- Document Modal -->
    <div class="modal fade" id="docModal" tabindex="-1" role="dialog" aria-labelledby="docModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="docModalTitle">{{$lb_document}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group row">
                                <label for="doc_description" class="control-label col-sm-3">{{$lb_description}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="doc_description" name="doc_description">
                                    <input type="hidden" id="doc_id" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="doc_file_name" class="control-label col-sm-3">{{$lb_file_name}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="doc_file_name" name="doc_file_name">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p id="docsms" class="text-danger text-center"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveDoc()">{{$lb_save}}</button>
                    <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal" onclick="clearDoc()">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
@endsection
@section('js')
<script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>
    <script>
        // save document
    function saveDoc() {
        var o = confirm('Do you want to save?');
        if(o)
        {
            var file_data = $('#doc_file_name').prop('files')[0];
            var form_data = new FormData();
            form_data.append('doc_file_name', file_data);
            form_data.append('staff_id', $("#staff_id").val());
            form_data.append("description", $('#doc_description').val());
            $("#docsms").html("<img src='" + asset + "/ajax-loader.gif" + "'>");
            $.ajax({
                type: 'POST',
                url:burl + '/staff-document/save',
                data: form_data,
                type: 'POST',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("input[name='_token']").val());
                },
                success:function(sms){
                    sms = JSON.parse(sms);
                    var tr = "";
                    tr +="<tr id='" + sms.id + "'>";
                    tr +="<td>" + sms.description+ "</td>";
                    tr += "<td>" + "<a href='" + doc_url + "/" + sms.file_name + "' target='_blank'>" + sms.file_name + "</a>" + "</td>";
                    tr += "<td>" + "<a href='#' onclick='deleteDoc(this,event)'><i class='fa fa-remove text-danger'></i></a>" + "</td>";
                    tr +="</tr>";
                    var counter = $("#docData tr").length;
                    if(counter>0){
                        $("#docData tr:last-child").after(tr);
                    }
                    else{
                        $("#docData").html(tr);
                    }
                    $("#docsms").html("Your doc has been saved!<br>ឯកសារត្រូវបានរក្សាទុកដោយជោគជ័យ!");
                    $("#doc_description").val("");
                    $("#doc_file_name").val("");
                },
            });

        }
    }
    // delete a document by its id
    function deleteDoc (obj, evt) {
    var tr = $(obj).parent().parent();
    var id = $(tr).attr('id');
    var con = confirm('You want to delete?');
    if(con)
    {
        $.ajax({
        type: "GET",
        url: burl + "/staff-document/delete/" + id,
        success: function (response) {
            $(tr).remove();
        }
    });
    }
    
    }
    function clearDoc() {
    $("#doc_description").val("");
    $("#doc_file_name").val("");
    $("#docsms").html("");
    $("#doc_id").val("0");
    }
    </script>
@endsection
