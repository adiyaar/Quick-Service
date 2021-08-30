@extends('admin.layout.app')

@section ('content')
        <!-- remove -->
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
        <div class="row profile-page">
            <div class="col-12">

                <div class="card card-nav-tabs ">

                    <div class="card-header card-header-primary">
                        <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                        <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#timing" data-toggle="tab">
                                <i class="menu-icon fa fa-clock-o"></i>
                                Timing
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#message" data-toggle="tab">
                                <i class="material-icons">inbox</i>
                                Message
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#mail" data-toggle="tab">
                                <i class="material-icons">mail</i>
                                Mail
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#coins" data-toggle="tab">
                                <i class="material-icons">money</i>
                                Coins For Part
                                <div class="ripple-container"></div></a>
                            </li>
                         
                            </ul>
                        </div>
                        </div>
                    </div>
                    <div class="card-body  text-left">
                        <div class="tab-content">
                        <div class="tab-pane active show" id="timing">

                         
                            <div class="col-md-12">

                                    <h4 class="card-title">Booking Time</h4><br>
                     
                                    <form class="forms-sample" action="{{route('timeslotupdate')}}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                        <label for="exampleInputName1">Start Time</label>
                                        <input type="time" class="form-control" id="exampleInputName1" style="width:100%;" name="plan_week" value="{{$faq_category->start_time}}" placeholder="Plan Weeks/Months"></div>
                                        <!--<div class="form-group">-->
                                        <!--<label for="exampleInputName1">No. of Days</label>-->
                                        <!--<input type="text" class="form-control" id="exampleInputName1" name="days" placeholder="Days">-->
                                        <!--</div>-->
                                        
                                        <div class="form-group">
                                        <label for="exampleInputName1">End Time</label>
                                        <input type="time" class="form-control" id="exampleInputName1" style="width:100%;" name="plan_price" value="{{$faq_category->EndTime}}" placeholder="Plan Price"></div>
                                        
                                        <div class="form-group">
                                        <label for="exampleInputName1">Duration</label>
                                        <input type="text" class="form-control" id="exampleInputName1" style="width:100%;" name="duration" value="{{$faq_category->Duration}}" placeholder="60"></div>
                                        
                                        
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <!--
                                        <button class="btn btn-light">Cancel</button>
                                        -->
                                        <a href="" class="btn btn-light">Cancel</a>
                                    </form>
                                    </div>
                                </div>
                    
                        
                        <div class="tab-pane" id="message">
                        <h4 class="card-title">Booking Message </h4><br>
                     
                            <form class="forms-sample" action="{{route('messageupdate')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                <label for="exampleInputName1">On Booking Time</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="booking" value="{{$message->booking_msg}}" placeholder="Category Name"></div>
                                <div class="form-group">
                                <label for="exampleInputName1">On Rescheduled</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="reschedule" value="{{$message->rescheduled_msg}}" placeholder="Category Name"></div>
                                
                                <div class="form-group">
                                <label for="exampleInputName1">On Cancelled Time</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="cancelled" value="{{$message->cancel_msg}}" placeholder="Category Name"></div>
                                
                            
                                
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <!--
                                <button class="btn btn-light">Cancel</button>
                                -->
                                <a href="" class="btn btn-light">Cancel</a>
                            </form>
                        </div>
                        <div class="tab-pane" id="mail">
                                <form class="forms-sample" action="{{route('mailupdate')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            
                            <div class="form-group">
                            <label for="exampleInputName1">From</label>
                            <input type="text" class="form-control" id="exampleInputName1" name="from" value="{{$mail->head}}" placeholder="Category Name"></div>
                            <div class="form-group">
                                <b><h4>On Booking Time </h4></b>
                            <label for="exampleInputName1">Subject</label>
                            <input type="text" class="form-control" id="exampleInputName1" name="booking_subject" value="{{$mail->email_subject}}" placeholder="Category Name"></div>
                            <div class="form-group">
                            <label for="exampleInputName1">Body</label>
                            <input type="text" class="form-control" id="exampleInputName1" name="booking_body" value="{{$mail->email_body}}" placeholder="Category Name"></div>
                            
                            <div class="form-group">
                                <b><h4>On Cancellation Time </h4></b>
                            <label for="exampleInputName1">Subject</label>
                            <input type="text" class="form-control" id="exampleInputName1" name="cancel_subject" value="{{$mail->subject_cancel}}" placeholder="Category Name"></div>
                            <div class="form-group">
                            <label for="exampleInputName1">Body</label>
                            <input type="text" class="form-control" id="exampleInputName1" name="cancel_body" value="{{$mail->body_cancel}}" placeholder="Category Name"></div>
                            
                            
                        
                            
                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                            <!--
                            <button class="btn btn-light">Cancel</button>
                            -->
                            <a href="" class="btn btn-light">Cancel</a>
                        </form>
                        </div>
                        <div class="tab-pane" id="coins">
                            <form class="forms-sample" action="{{route('coinsupdate')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                <label for="exampleInputName1">What Precentage you Offer ?</label>
                                <input type="text" class="form-control" id="exampleInputName1" name="percentage" value="{{$coin->coin_value}}" placeholder="What Percentage 50%"><br>
                                
                                
                                <!-- <div class="form-group">-->
                                <!--  <label>Image upload</label>-->
                                <!--  <input type="file" name="image"  class="file-upload-default">-->
                                <!--  <div class="input-group col-xs-12">-->
                                <!--    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image Size (50kb)">-->
                                <!--    <div class="input-group-append">-->
                                <!--      <button class="file-upload-browse btn btn-info" type="button">Upload</button>                          -->
                                <!--    </div>-->
                                <!--  </div>-->
                                <!--</div>-->
                                
                                <button type="submit" class="btn btn-success mr-2">Update</button>
                                
                                <a href="" class="btn btn-light">Cancel</a>
                            </form>
                        </div>

                        </div>
        </div>
        </div>
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