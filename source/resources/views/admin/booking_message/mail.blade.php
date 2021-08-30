@extends('admin.layout.app')

@section ('content')
        <!-- remove -->
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title">Mail Message </h3><br>
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
                  <form class="forms-sample" action="{{route('mailupdate')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      
                      <div class="form-group">
                      <label for="exampleInputName1">From</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="from" value="{{$term->head}}" placeholder="Category Name"></div>
                      <div class="form-group">
                          <b><h4>On Booking Time </h4></b>
                      <label for="exampleInputName1">Subject</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="booking_subject" value="{{$term->email_subject}}" placeholder="Category Name"></div>
                      <div class="form-group">
                      <label for="exampleInputName1">Body</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="booking_body" value="{{$term->email_body}}" placeholder="Category Name"></div>
                      
                      <div class="form-group">
                          <b><h4>On Cancellation Time </h4></b>
                      <label for="exampleInputName1">Subject</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="cancel_subject" value="{{$term->subject_cancel}}" placeholder="Category Name"></div>
                     <div class="form-group">
                      <label for="exampleInputName1">Body</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="cancel_body" value="{{$term->body_cancel}}" placeholder="Category Name"></div>
                      
                      
                   
                    
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
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

 <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'textarea'});</script>


 @endsection