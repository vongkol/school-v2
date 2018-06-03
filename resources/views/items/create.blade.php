@extends('layouts.app')
@section('content')
    <?php $lang = Auth::user()->language=="kh"?'kh.php':'en.php'; ?>
    <?php include(app_path()."/lang/". $lang); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-bold">
                    <i class="fa fa-align-justify"></i> New Item&nbsp;&nbsp;
                    <a href="{{url('/item')}}" class="btn btn-link btn-sm">{{$lb_back_to_list}}</a>
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
                    <form action="{{url('/item/save')}}" class="form-horizontal" method="post" enctype='multipart/form-data'>
                       <div class="row">
                           <div class="col-sm-6">
                               {{csrf_field()}}
                              
                               <div class="form-group row">
                                   <label for="name" class="control-label col-sm-3">Name <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="text" required autofocus name="name" id="name" class="form-control" value="{{old('name')}}">
                                   </div>
                               </div>
                               <?php $branches  = DB::table('branches')->get();?>
                               <div class="form-group row">
                                   <label for="branch" class="control-label col-sm-3">Branch <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <select name="branch" id="branch" class="form-control">
                                           @foreach($branches as $branch)
                                           <option value="{{$branch->id}}">{{$branch->name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <?php $item_categories  = DB::table('item_categories')->where('active',1)->get();?>
                               <div class="form-group row">
                                   <label for="item_category" class="control-label col-sm-3">Item Category</label>
                                   <div class="col-sm-9">
                                       <select name="item_category" id="item_category" class="form-control">
                                     
                                           @foreach($item_categories as $item_category)
                                           <option value="{{$item_category->id}}">{{$item_category->name}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="price" class="control-label col-sm-3">Price <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="number" step="0.1" name="price" id="price" required class="form-control" value="{{old('price')}}">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="tax" class="control-label col-sm-3">Tax <span class="text-danger">*</span></label>
                                   <div class="col-sm-9">
                                       <input type="number" step="0.1" name="tax" id="tax" required class="form-control" value="{{old('tax')}}">
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-6">
                             <div class="form-group row">
                                   <label for="photo" class="control-label col-sm-3">{{$lb_photo}} </label>
                                   <div class="col-sm-9">
                                       <input type="file" name="photo" id="photo" class="form-control" onchange="loadFile(event)">
                                       <br>
                                       <img src="{{asset('uploads/items/default.svg')}}" alt="" id="preview" height="150">
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-12">
                            <div class="form-group row">
                                   <label for="description" class="control-label col-sm-3">Description</label>
                                   <div class="col-sm-12">
                                       <textarea name="description" class="form-control ckeditor" id="description"></textarea>
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
<script>
    function loadFile(e){
        var output = document.getElementById('preview');
        output.src = URL.createObjectURL(e.target.files[0]);
    }
</script>
<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
@endsection