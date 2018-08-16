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
    <link href="{{asset('css/datepicker.css')}}" rel="stylesheet">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Detail Student&nbsp;&nbsp;-  {{$lb_code}} {{$student->code}}&nbsp;&nbsp;
                    <a href="{{url('/student/create')}}" class="btn btn-link btn-sm">{{$lb_new}}</a>&nbsp;&nbsp;
                    <a href="{{url('/student')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>&nbsp;&nbsp;
                    <a href="#" id="btnEdit" onclick="edit(event)" class="text-danger">{{$lb_edit}}</a>
                </div>
                <div class="card-block">
                    <form action="#" class="form-horizontal" method="post" enctype='multipart/form-data'>
                       <div class="row">
                           <div class="col-sm-6">
                               {{csrf_field()}}
                               <input type="hidden" value="{{$student->id}}" id="student_id">
                               <div class="form-group row">
                                   <label for="khmer_name" class="control-label col-sm-3">{{$lb_khmer_name}} <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required readonly name="khmer_name" id="khmer_name" class="form-control" value="{{$student->khmer_name}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="english_name" class="control-label col-sm-3">{{$lb_english_name}} <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required name="english_name" id="english_name" readonly class="form-control" value="{{$student->english_name}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="phone" class="control-label col-sm-3">{{$lb_phone}} <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" name="phone" required id="phone" class="form-control" readonly value="{{$student->phone}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="gender" class="control-label col-sm-3">{{$lb_gender}}</label>
                                   <div class="col-sm-9">
                                       <select name="gender" id="gender" class="form-control" readonly>
                                           <option value="Male" {{$student->gender=='Male'?'selected':''}}>{{$lb_male}}</option>
                                           <option value="Female" {{$student->gender=='Female'?'selected':''}}>{{$lb_female}}</option>
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="dob" class="control-label col-sm-3">{{$lb_dob}}</label>
                                   <div class="col-sm-9">
                                       <input type="text"  name="dob" id="dob" class="form-control" readonly value="{{$student->dob}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="pob" class="control-label col-sm-3">{{$lb_pob}}</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="pob" id="pob" class="form-control" readonly value="{{$student->pob}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label class="control-label col-sm-3">&nbsp;</label>
                                   <div class="col-sm-9">
                                       <button class="btn btn-primary hide" type="button" onclick="save()">{{$lb_save}}</button>
                                       <button class="btn btn-danger hide" type="button" onclick="cancelEdit()">{{$lb_cancel}}</button>
                                       <p id="sms"></p>
                                   </div>
                               </div>
                           </div>
                
                           <div class="col-sm-6">
                               <div class="form-group row">
                                   <label for="email" class="control-label col-sm-3">{{$lb_email}}</label>
                                   <div class="col-sm-9">
                                       <input type="email" name="email" id="email" class="form-control" readonly value="{{$student->email}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="university" class="control-label col-sm-3">University</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="university" id="university" class="form-control" readonly value="{{$student->university}}">
                                   </div>
                               </div>
                                <div class="form-group row">
                                   <label for="current_address" class="control-label col-sm-3">{{$lb_current_address}}</label>
                                   <div class="col-sm-9">
                                       <input type="text" name="current_address" id="current_address" readonly class="form-control" value="{{$student->address}}">
                                   </div>
                               </div>
                                <div class="form-group row">
                                   <label for="branch" class="control-label col-sm-3">{{$lb_branch}}</label>
                                   <div class="col-sm-9">
                                       <select id="branch" name="branch" class="form-control" readonly>
                                            @foreach($branches as $b)
                                            <option value="{{$b->id}}">{{$b->name}}</option>
                                            @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="photo" class="control-label col-sm-3">{{$lb_photo}}</label>
                                   <div class="col-sm-9">
                                       <input type="file" name="photo" id="photo" class="form-control" disabled onchange="loadFile(event)">
                                       <br>
                                       <img src="{{asset('photo/'.$student->photo)}}" alt="" id="preview" width="120">
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Invoice List&nbsp;&nbsp;
                    <a href="{{url('/invoice/create?customer_id='.$student->id)}}" class="btn btn-link btn-sm">{{$lb_new}}</a>
                </div>
                
                <div class="card-block">
                    <table class="tbl">
                        <thead>
                        <tr>
                            <th>{!!$lb_id!!}</th>
                            <th>Invoice Ref</th>
                            <th>Student Code</th>
                            <th>Student</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Total Amount</th>
                            <th>{{$lb_action}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $pagex = @$_GET['page'];
                            if(!$pagex)
                            $pagex = 1;
                            $i = 18 * ($pagex - 1) + 1;
                        ?>
                        @foreach($invoices as $invoice)
                            <tr  @if($invoice->total_due_amount) bgcolor="#ffe6e6" @endif>
                                <td>{{$i++}}</td>
                                <td> <a href="{{url('student/invoice-detail/'.$invoice->invoice_id)}}" title="Detail">{{$invoice->invoice_ref}}</a></td>
                                <td> <a href="{{url('student/invoice-detail/'.$invoice->invoice_id)}}" title="Detail"> {{$invoice->code}}</a></td>
                                <td> <a href="{{url('student/invoice-detail/'.$invoice->invoice_id)}}" title="Detail">{{$invoice->english_name}}</a></td>
                                <td>{{$invoice->invoice_date}}</td>
                                <td>{{$invoice->due_date}} </td>
                                <td><span class="text-warning">USD</span> {{$invoice->total_amount}} </td>
                                <td>
                                    <a href="{{url('student/invoice-detail/'.$invoice->invoice_id)}}" title="Detail"><i class="fa fa-eye text-info"></i></a>&nbsp;&nbsp;
                                    <a  href="{{url('/student/delete-invoice/'.$invoice->invoice_id)}}" onclick="return confirm('{{$lb_confirm_delete}}')" title="{{$lb_delete}}"><i class="fa fa-remove text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
        </div>
        <!--/.col-->
    </div>
                        <div class="row">
                            <div class="col-sm-12">

                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">{{$lb_family}}</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{$lb_document}}</a></li>
                                    <li role="presentation"><a href="#registration" aria-controls="registration" role="tab" data-toggle="tab">Student Enroll</a></li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">
                                       <p>
                                           <button type="button" id="btnAddFamily" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModalLong">{{$lb_add}}</button>
                                       </p>
                                        <table class="tbl table-responsive">
                                            <thead>
                                                 <tr>
                                                    <th>{{$lb_full_name}}</th>
                                                    <th>{{$lb_gender}}</th>
                                                    <th>{{$lb_dob}}</th>
                                                    <th>{{$lb_address}}</th>
                                                    <th>{{$lb_career}}</th>
                                                    <th>{{$lb_family_status}}</th>
                                                    <th>{{$lb_phone}}</th>
                                                    <th>{{$lb_relation_type}}</th>
                                                    <th>{{$lb_is_alive}}</th>
                                                    <th>{{$lb_is_disabled}}</th>
                                                    <th>{{$lb_minority}}</th>
                                                    <th>{{$lb_action}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data">
                                            @foreach($families as $fm)
                                                <tr id="{{$fm->id}}">
                                                    <td>{{$fm->full_name}}</td>
                                                    <td>{{$fm->gender}}</td>
                                                    <td>{{$fm->dob}}</td>
                                                    <td>{{$fm->address}}</td>
                                                    <td>{{$fm->career}}</td>
                                                    <td>{{$fm->family_status}}</td>
                                                    <td>{{$fm->phone}}</td>
                                                    <td>{{$fm->relation_type}}</td>
                                                    <td>{{$fm->is_alived}}</td>
                                                    <td>{{$fm->is_disabled}}</td>
                                                    <td>{{$fm->is_minority}}</td>
                                                    <td>
                                                        <a href="#" onclick="editFamily(this, event)"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp;
                                                        <a href="#" onclick="removeFamily(this, event)"><i class="fa fa-remove text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="profile">
                                        <p>
                                            <button type="button" id="btnAddDocument" class="btn btn-sm btn-success" data-toggle="modal" data-target="#docModal">{{$lb_add}}</button>
                                        </p>
                                        <table class="tbl table-responsive">
                                            <thead>
                                            <tr>
                                                <th>{{$lb_description}}</th>
                                                <th>{{$lb_file_name}}</th>
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
                                    <div role="tabpanel" class="tab-pane" id="registration">
                                         <p>
                                            <button type="button" id="btnAddRegistration" class="btn btn-sm btn-success" 
                                            data-toggle="modal" data-target="#registrationModal">{{$lb_add}}</button>
                                        </p>
                                         <table class="tbl table-responsive">
                                            <thead>
                                            <tr>
                                                <th>{{$lb_register_date}}</th>
                                                <th>{{$lb_class}}</th>
                                                <th>Shift</th>
                                                <th>{{$lb_school_year}}</th>
                                                <th>{{$lb_start_date}}</th>
                                                <th>{{$lb_end_date}}</th>
                                               
                                                <th>{{$lb_action}}</th>
                                            </tr>
                                            </thead>
                                            <tbody id="rdata">
                                            @foreach($registrations as $r)
                                                <tr id="{{$r->registration_id}}" year-id="{{$r->year_id}}" class-id="{{$r->class_id}}">
                                                    <td>{{$r->registration_date}}</td>
                                                    <td>{{$r->class_name}}</td>
                                                    <td>{{$r->shift_name}}</td>
                                                    <td>{{$r->year_name}}</td>
                                                    <td>{{$r->start_date}}</td>
                                                    <td>{{$r->end_date}}</td>
                                                    <td>
                                                        <!--<a href="#" onclick="editRegistration(this, event)"><i class="fa fa-edit text-success"></i></a>&nbsp;&nbsp;-->
                                                        <a href="#" onclick="removeRegistration(this,event)">
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
                    <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal" onclick="clearDoc()">{{$lb_close}}</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{$lb_family}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="frelation" class="control-label col-sm-4">{{$lb_relation_type}}<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <select name="frelation" id="frelation" class="form-control">
                                        <option value="Father">{{$lb_father}}</option>
                                        <option value="Mother">{{$lb_mother}}</option>
                                        <option value="Sibling">{{$lb_sibling}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="full_name" class="control-label col-sm-4">{{$lb_full_name}}<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="full_name" name="full_name" class="form-control">
                                    <input type="hidden" id="sid" value="{{$student->id}}">
                                    <input type="hidden" id="family_id" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fdob" class="control-label col-sm-4">{{$lb_dob}}</label>
                                <div class="col-sm-8">
                                    <input type="text" id="fdob" name="fdob" class="form-control" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fcareer" class="control-label col-sm-4">{{$lb_career}}</label>
                                <div class="col-sm-8">
                                    <input type="text" id="fcareer" name="fcareer" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fstatus" class="control-label col-sm-4">{{$lb_family_status}}</label>
                                <div class="col-sm-8">
                                    <input type="text" id="fstatus" name="fstatus" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="falive" class="control-label col-sm-4">{{$lb_is_alive}}</label>
                                <div class="col-sm-8">
                                    <select name="falive" id="falive" class="form-control">
                                        <option value="yes">នៅរស់</option>
                                        <option value="no">ស្លាប់</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group row">
                                <label for="fgender" class="control-label col-sm-4">{{$lb_gender}}<span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <select name="fgender" id="fgender" class="form-control">
                                        <option value="Male">{{$lb_male}}</option>
                                        <option value="Female">{{$lb_female}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="faddress" class="control-label col-sm-4">{{$lb_address}}</label>
                                <div class="col-sm-8">
                                    <input type="text" id="faddress" name="faddress" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fphone" class="control-label col-sm-4">{{$lb_phone}}</label>
                                <div class="col-sm-8">
                                    <input type="text" id="fphone" name="fphone" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="control-label col-sm-3">{{$lb_email}}</label>
                                <div class="col-sm-9">
                                    <input type="email" name="email" id="email" class="form-control" value="{{$student->email}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fdisable" class="control-label col-sm-4">{{$lb_is_disabled}}</label>
                                <div class="col-sm-8">
                                    <select name="fdisable" id="fdisable" class="form-control">
                                        <option value="no">មិនពិការ</option>
                                        <option value="yes">ពិការ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fminority" class="control-label col-sm-4">{{$lb_minority}}</label>
                                <div class="col-sm-8">
                                    <select name="fminority" id="fminority" class="form-control">
                                        <option value="no">មិនមែន</option>
                                        <option value="yes">មែន</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-sm-12">
                           <p id="fsms" class="text-danger text-center"></p>
                       </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveFamily()">{{$lb_save}}</button>
                    <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal" onclick="clearCancel()">{{$lb_close}}</button>

                </div>
            </div>
        </div>
    </div>
   
    <!-- registration modal -->
     <div class="modal fade" id="registrationModal" tabindex="-1" role="dialog" aria-labelledby="registrationModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationModalTitle">{{$lb_registration}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-group row">
                                <label for="register_date" class="control-label col-sm-3">
                                    {{$lb_register_date}}<span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker-icon" id="register_date"
                                     placeholder="yyyy/mm/dd" name="register_date">
                                    <input type="hidden" id="registration_id " value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="class" class="control-label col-sm-3">{{$lb_class}}</label>
                                <div class="col-sm-9">
                                   <select name="class" id="class" class="form-control">
                                   @foreach($classes as $class)
                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                   @endforeach
                                   </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="shift" class="control-label col-sm-3">Shift</label>
                                <div class="col-sm-9">
                                    <select name="shift" id="shift" class="form-control">
                                        @foreach($shifts as $shift)
                                            <option value="{{$shift->id}}">{{$shift->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="year" class="control-label col-sm-3">{{$lb_school_year}}</label>
                                <div class="col-sm-9">
                                   <select name="year" id="year" class="form-control">
                                   @foreach($years as $year)
                                        <option value="{{$year->id}}">{{$year->name}}</option>
                                   @endforeach
                                   </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="start_date" class="control-label col-sm-3">{{$lb_start_date}}</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control  datepicker-icon" id="start_date" 
                                   name="start_date" placeholder="yyyy/mm/dd">
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="end_date" class="control-label col-sm-3">{{$lb_end_date}}</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control datepicker-icon" id="end_date" 
                                   name="end_date" placeholder="yyyy/mm/dd">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <p id="regsms" class="text-danger text-center"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveRegistration()">{{$lb_save}}</button>
                    <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal" onclick="clearRegistration()">{{$lb_close}}</button>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('js')
<script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>
<script>
    function loadFile(e){
        var output = document.getElementById('preview');
        output.src = URL.createObjectURL(e.target.files[0]);
    }
    $(document).ready(function(){
        $("#fdob").inputmask("99/99/9999");
        $("#start_date, #end_date, #register_date").datepicker({
            orientation: 'bottom',
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            toggleActive: true
        });
    });
</script>
<script src="{{asset('js/students/student-edit.js')}}"></script>
@endsection