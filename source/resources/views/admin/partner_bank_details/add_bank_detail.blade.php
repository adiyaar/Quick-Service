@extends('admin.layout.app')

@section ('content')
        <!-- remove -->
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Bank Details</h4><br>
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
                  <form class="forms-sample" action="{{route('membershipnewadd')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="form-group">
                      <label for="exampleInputName1">Name( as registered in Bank)</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="name" placeholder="Plan Weeks/Months"></div>
                      <div class="form-group">
                      <label for="exampleInputName1">Bank Account Number</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="number" placeholder="Days">
                      </div>
                      
                        <div class="form-group">
                      <label for="exampleInputName1">Confirm Bank Account Number</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="confirm" placeholder="Days">
                      </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">IFSC Code</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="code" placeholder="Plan Price"></div>
                      
                      <div class="form-group">
                      <label>Cancelled Cheque</label>
                      <input type="file" name="cheque"  class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Back Image">
                        <div class="input-group-append">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>                          
                        </div>
                      </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="{{route('currency')}}" class="btn btn-light">Cancel</a>
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