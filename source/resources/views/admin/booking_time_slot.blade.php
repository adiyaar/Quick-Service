@extends('admin.layout.app')

@section ('content')
        <!-- remove -->
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Booking Time</h4><br>
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
                  <form class="forms-sample" action="{{route('timeslotupdate')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="form-group">
                      <label for="exampleInputName1">Start Time</label>
                      <input type="time" class="form-control" id="exampleInputName1" style="width:50%;" name="plan_week" value="{{$faq_category->start_time}}" placeholder="Plan Weeks/Months"></div>
                      <!--<div class="form-group">-->
                      <!--<label for="exampleInputName1">No. of Days</label>-->
                      <!--<input type="text" class="form-control" id="exampleInputName1" name="days" placeholder="Days">-->
                      <!--</div>-->
                    
                      <div class="form-group">
                      <label for="exampleInputName1">End Time</label>
                      <input type="time" class="form-control" id="exampleInputName1" style="width:50%;" name="plan_price" value="{{$faq_category->EndTime}}" placeholder="Plan Price"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Duration</label>
                      <input type="text" class="form-control" id="exampleInputName1" style="width:50%;" name="duration" value="{{$faq_category->Duration}}" placeholder="60"></div>
                      
                    
                    <button type="submit" class="btn btn-success mr-2">Update</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="" class="btn btn-light">Cancel</a>
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