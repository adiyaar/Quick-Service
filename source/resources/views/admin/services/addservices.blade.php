@extends('admin.layout.app')

@section ('content')
        <!-- remove -->
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Services</h4><br>
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
                  <form class="forms-sample" action="{{route('addnewservices')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      
                       <div class="form-group">
                    <label for="exampleFormControlSelect3">Select City</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="partner">
                      @foreach($partner as $partners)
                    <option value="{{$partners->city_id}}">{{$partners->city_name}}</option>
                      @endforeach
                      
                      
                    </select>
                    </div>
                     
                        <div class="form-group">
                    <label for="exampleFormControlSelect3">choose a category</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="child_category">
                      @foreach($sub_category as $sub_category)
		          	<option value="{{$sub_category->child_category_id}}"><span style="font-weight:bold">{{$sub_category->category_name}}-></span>&nbsp;{{$sub_category->sub_category_name}}-></span>&nbsp;{{$sub_category->child_name}}</option>
		              @endforeach
                      
                      
                    </select>
                    </div>
                      
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Service Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="service_name" value="" placeholder="Service Name">
                      </div>
                      <div class="form-group">
                      <label for="exampleInputName1">Service Short Description</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="service_des" value="" placeholder="Service Short Description"></div>
                       <div class="form-group">
                      <label for="exampleInputName1">Service Price</label>
                      <input type="number" class="form-control" id="exampleInputName1" name="service_price" value="" placeholder="Service Price"></div>
                      <div class="form-group">
                      <label for="exampleInputName1">Strike Price</label>
                      <input type="number" class="form-control" id="exampleInputName1" name="strike_price" value="" placeholder="Strike Price"></div>
                      <div class="form-group">
                      <label for="exampleInputName1">Time</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="time" value="" placeholder="Time"></div>
                      
                      <div class="form-group">
                          <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail img-raised">
                                      
  
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                <div class="text-right">
                                <span class="btn btn-raised btn-round btn-rose btn-file">
                        
                                  select Image
                                  <input type="file" name="image" />
                                </span>
                                      <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                                      <i class="fa fa-times"></i> Remove</a>
                                </div>
                          
                      
                          </div>
                          </div>
                      
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="{{route('add_service')}}" class="btn btn-light">Cancel</a>
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