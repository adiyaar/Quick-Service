@extends('admin.layout.app')
<style>
.raffleimg{
    width: 100px;
border-radius: 50%;
height: 100px;
}
</style>

@section ('content')
        <!-- remove -->
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add-Sub-Category</h4><br>
                   @if (count($errors) > 0)
                      @if($errors->any())
                        <div class="alert alert-primary" role="alert">
                          {{$errors->first()}}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                      @endif
                  @endif
                  <form class="forms-sample" action="{{route('updatesubcategory')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">Category</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="category_list">
                      @foreach($tbl_category as $categories)
		          	<option value="{{$categories->category_id}}" @if($categories->category_id ==$sub_category->category_id) selected @endif>{{$categories->category_name}}</option>
		              @endforeach
                      
                      
                    </select>
                    </div>
                      <div class="form-group">
                      <label for="exampleInputName1">Sub Category Name</label>
                      <input type="hidden" name="sub_category_id" value="{{$sub_category->sub_category_id}}">
                      <input type="text" class="form-control" id="exampleInputName1" name="category_name" value="{{$sub_category->sub_category_name}}" placeholder="Category Name"><br>
                      
                      
                     <img src="{{url($sub_category->sub_category_img)}}" class="raffleimg">
                     <div class="form-group">
                          <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-raised">
                        <img src="{{url($sub_category->sub_category_img)}}" class="raffleimg">
                      </div>
                        <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <div>
                        <span class="btn btn-raised btn-round btn-rose btn-file">
                          <span class="fileinput-new">Select image</span>
                          <span class="fileinput-exists">Change</span>
                          <input type="file" name="reward_image" />
                        </span>
                              <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                              <i class="fa fa-times"></i> Remove</a>
                        </div>
                          </div>

                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="{{route('editsubcategory', $sub_category->sub_category_id)}}" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
             <div class="col-md-2">
		  </div>
     
          </div>
        </div>
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
        	$(document).ready(function(){
        	
                $(".des_price").hide();
                
        		$(".img").on('change', function(){
        	        $(".des_price").show();
        			
        	});
        	});
</script>

 


 @endsection