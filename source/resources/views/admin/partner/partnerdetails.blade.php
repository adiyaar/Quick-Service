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
                  <h4 class="card-title">Partner Details</h4><br>
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
                      <label for="exampleInputName1">Name (as registered in Bank)</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_name" value="{{$partners->holder_name}}" placeholder="No Information" disabled></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Bank Account Number</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_phone" value="{{$partners->acc_no}}" placeholder="No Information"disabled></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">IFSC Code:</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_email" value="{{$partners->ifsc_code}}" placeholder="No Information"disabled></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Cancelled Cheque</label>
                      </div>
                      <img src="{{url($partners->image)}}" class="raffleimg">
                      
                       <div class="form-group"><br>
                      <label for="exampleInputName1">Name (as registered in GST) </label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_email" value="{{$partners->gst_name}}" placeholder="No Information"disabled></div>
                      
                       <div class="form-group">
                      <label for="exampleInputName1">GST Number</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_email" value="{{$partners->gst_no}}" placeholder="No Information"disabled></div>
                      
                       
                      
                      
                      
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