@extends('admin.layout.app')
<style>
    .no-click{
        pointer-events: none;
    }
</style>
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
                  <h4 class="card-title">Partner Document</h4><br>
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
                  <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Identity Proof Number</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_name" value="{{$partner->identify_proof}}" placeholder="Category Name" disabled></div><br>
                      <img src="{{url($partner->front_image)}}" class="raffleimg">
                      <img src="{{url($partner->back_image)}}" class="raffleimg">
                      
                      <div class="form-group" style ="margin-top:10px;">
                      <label for="exampleInputName1">Voter Card Number</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_phone" value="{{$partner->voter_card_number}}" placeholder="Category Name"disabled></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Gender</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_email" value="{{$partner->gender}}" placeholder="Category Name"disabled></div>
                      
                       <div class="form-group">
                      <label for="exampleInputName1">Date of Birth</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_prof" value="{{$partner->d_o_b}}" placeholder="Category Name"disabled></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Care of</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_pass" value="{{$partner->c_o}}" placeholder="Category Name"disabled></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Permanent Address</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_add" value="{{$partner->permanent_add}}" placeholder="Address"disabled></div>
                     @if($partner->status==0)
                      <a href="{{route('confirmpartnerstatus',[$partner->partner_id])}}" class="btn btn-success" style="color: #fff;">Confirm</a>
                        <a href="{{route('rejectedpartnerstatus',[$partner->partner_id])}}" class="btn btn-danger" style="color: #fff;">Reject</a>
                        @endif
                        @if($partner->status==1)
                        <a href="" class="btn btn-success no-click" style="color: #fff;" >Confirmed</a>
                      
                        @endif
                      
                     <!--<a href="#" class="btn btn-light">Cancel</a>-->
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