@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> Report Student List&nbsp;&nbsp;
                </div>
                <div class="card-block">
                   <div class="row">
                       <div class="col-sm-6">
                           <h4>List All Students</h4>
                           <hr>
                           <div class="form-group row">
                               <label for="" class="control-label col-sm-2">&nbsp;</label>
                               <div class="col-sm-7">
                                   <a href="{{url('/printing')}}" class="btn btn-primary" target="_blank">Generate Report</a>
                               </div>
                           </div>
                           <h4>List student by provinces</h4>
                           <hr>
                           <form action="{{url('/printing/province')}}" class="form-horizontal" method="get" target="_blank">
                               <div class="form-group row">
                                   <label for="province" class="control-label col-sm-2">Province</label>
                                   <div class="col-sm-7">
                                       <select name="province" id="province" class="form-control">
                                           @foreach($provinces as $pro)
                                               <option value="{{$pro->address}}">{{$pro->address}}</option>
                                           @endforeach
                                       </select>
                                       <br>
                                       <button class="btn btn-primary" type="submit">Generate Report</button>
                                   </div>
                               </div>
                           </form>
                           <h4>List student by school</h4>
                           <hr>
                           <form action="{{url('/printing/school')}}" class="form-horizontal" method="get" target="_blank">
                               <div class="form-group row">
                                   <label for="school" class="control-label col-sm-2">School</label>
                                   <div class="col-sm-7">
                                       <select name="school" id="province" class="form-control">
                                           @foreach($schools as $pro)
                                               <option value="{{$pro->id}}">{{$pro->name}}</option>
                                           @endforeach
                                       </select>
                                       <br>
                                       <button class="btn btn-primary" type="submit">Generate Report</button>
                                   </div>
                               </div>
                           </form>
                       </div>
                       <div class="col-sm-6">

                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection