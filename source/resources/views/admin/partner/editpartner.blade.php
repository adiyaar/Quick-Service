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
                  <h4 class="card-title">Personal Details</h4><br>
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
                  <form class="forms-sample" action="{{route('updatepartner')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}

                    
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">choose a Category</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="category_list">
                        @foreach($sub_child_category as $service)
                        <option value="{{$service->category_id}}" @if($service->category_id == $partner->category_id) selected @endif>
                            <span style="font-weight:bold">{{$service->category_name}}
                        </option>
                      @endforeach
                        
                    

                    </select>
                    </div>
                    
                     <div class="form-group">
                    <label for="exampleFormControlSelect3">choose a Sub-Category</label>
                                          <div class="subcat">
                    <select class="form-control form-control-sm unshow" id="subcat" name="sub_cat_list">
                        @foreach($sub_category as $service)
                        <option value="{{$service->sub_category_id}}" @if($service->sub_category_id == $partner->sub_cat_id) selected @endif>
                            <span style="font-weight:bold">{{$service->sub_category_name}}
                        </option>
                      @endforeach
                        
                    

                    </select>
                    </div>
                    </div>
                        <div class="form-group">
                    <label for="exampleFormControlSelect3">choose a Child Category</label>
                    <div class="childcat">
                    <select class="form-control form-control-sm unshowchild" id="subchild" name="child_category_id">
                      @foreach($sub_child as $service)
                        <option value="{{$service->child_category_id}}" @if($service->child_category_id == $partner->child_cat_id) selected @endif>
                            <span style="font-weight:bold">{{$service->child_name}}
                        </option>
                      @endforeach
                    </select>
                     </div>
                    </div>
                    
                                        <div class="form-group">
                    <label for="exampleFormControlSelect3">City</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="city_list">
                      @foreach($category as $categories)
		          	<option value="{{$categories->city_id}}" @if($categories->city_id ==$partner->city__id) selected @endif>{{$categories->city_name}}</option>
		              @endforeach
                    </select>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Name</label>
                      <input type="hidden" name="partner_id" value="{{$partner->partner_id}}">
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_name" value="{{$partner->partner_name}}" placeholder="Category Name"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Phone</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_phone" value="{{$partner->partner_phone}}" placeholder="Category Name"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Email</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_email" value="{{$partner->partner_email}}" placeholder="Category Name"></div>
                      
                      
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Password</label>
                      <input type="password" class="form-control" id="exampleInputName1" name="partner_pass" value="{{$partner->partner_password}}" placeholder="Category Name"></div>
                      
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Delivery Range</label>
                      <input type="password" class="form-control" id="exampleInputName1" name="range" value="{{$partner->range}}" placeholder="Category Name"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Address</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_add" value="{{$partner->address}}" placeholder="Address"></div>
                      

                    
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="{{route('partneredit',$partner->partner_id)}}" class="btn btn-light">Cancel</a>
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
        	
        	$('select[name="category_list"]').on('change', function() {
        
        var category_id = $(this).val();
        $("#subcat").hide();
        $("#subchild").hide();
                debugger;
                $.ajax({
                    url: "/quickservice/admin/getbyeditsubcate/"+encodeURI(category_id),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                      debugger;
                      if ($.trim(data)){ 
                        var html = "<select class='form-control form-control-sm subcat' id='subcat' name='sub_cat_list'><option value=''>Select Sub-Category </option>";
                         for(var i=0;i<data.length;i++){ 
                            html+="<option value="+data[i].sub_category_id+">"+data[i].sub_category_name+"</option>";
                        }
                        html+="</select>";
                        $(".subcat").html(html);
                        
                        
            $('select[name="sub_cat_list"]').on('change', function() {
        
        var category_id = $(this).val();
                $("#subchild").hide();
                debugger;
                $.ajax({
                    url: "/quickservice/admin/getbyeditchildcate/"+encodeURI(category_id),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                      debugger;
                      if ($.trim(data)){ 
                        var html = "<select class='form-control form-control-sm childcat' id='subchild'  name='child_category_id'><option value=''>Select Child Category</option>";
                         for(var i=0;i<data.length;i++){ 
                            html+="<option value="+data[i].child_category_id+">"+data[i].child_name+"</option>";
                        }
                        html+="</select>";
                        $(".childcat").html(html);

                      }else{   
                            alert("Subcategory not Exist");
                             $('.unshowchild').hide();
    
                            }
                        
                    }
                });
           
    });
                        
                        
                      }else{   
                            alert("Subcategory not Exist");
                             $('.unshow').hide();
    
                            }
                        
                    }
                });
           
    });
    
            $('select[name="sub_cat_list"]').on('change', function() {
        
        var category_id = $(this).val();
                $("#subchild").hide();
                debugger;
                $.ajax({
                    url: "/quickservice/admin/getbyeditchildcate/"+encodeURI(category_id),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                      debugger;
                      if ($.trim(data)){ 
                        var html = "<select class='form-control form-control-sm childcat' id='subchild'  name='child_category_id'><option value=''>Select Child Category</option>";
                         for(var i=0;i<data.length;i++){ 
                            html+="<option value="+data[i].child_category_id+">"+data[i].child_name+"</option>";
                        }
                        html+="</select>";
                        $(".childcat").html(html);

                      }else{   
                            alert("Subcategory not Exist");
                             $('.unshowchild').hide();
    
                            }
                        
                    }
                });
           
    });
        	
        	});
</script>

 


 @endsection