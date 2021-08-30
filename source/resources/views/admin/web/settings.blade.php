@extends('admin.layout.app')

@section('content')

        <div class="">
          <div class="row profile-page">
            <div class="col-12">
                <div class="card card-nav-tabs">
                    <div class="card-header card-header-primary">
                        <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                        <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                           
                          
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#app_version" data-toggle="tab">
                                <i class="material-icons">build</i>
                                App Version
                                <div class="ripple-container"></div></a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="#fcm" data-toggle="tab">
                                <i class="material-icons">build</i>
                                FCM
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#otp" data-toggle="tab">
                                <i class="material-icons">build</i>
                                OTP
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#map_key" data-toggle="tab">
                                <i class="material-icons">place</i>
                                Map Key
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about_us" data-toggle="tab">
                                <i class="material-icons">build</i>
                                About Us
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tc" data-toggle="tab">
                                <i class="material-icons">build</i>
                                Terms & Conditions
                                <div class="ripple-container"></div></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#user_review" data-toggle="tab">
                                <i class="menu-icon fa fa-star"></i>
                                User Review
                                <div class="ripple-container"></div></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#cc" data-toggle="tab">
                                <i class="menu-icon fa fa-bullhorn"></i>
                                Complaint Center 
                                <div class="ripple-container"></div></a>
                            </li>
                     
                     
                            </ul>
                        </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content">
                        
                        <div class="tab-pane" id="app_name">
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
                              <!-- <h4 class="card-title">Change Password</h4> -->
                              <form class="forms-sample" action="{{route('adminUpdateWebName')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="form-group">
                                	<h4>{{ $adminWebName->value }}</h4>
                                </div>

                                <div class="form-group">
                                  <label for="app_name">app name :</label>
                                  <input type="text" class="form-control" id="app_name" name="app_name" placeholder="app name" value="{{$adminWebName->value}}">
                                </div>

                                <button type="submit" class="btn btn-success mr-2">Update</button>
                              </form>
                        </div>
                        <div class="tab-pane" id="app_version">
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
                              <!-- <h4 class="card-title">Change Password</h4> -->
                              <form class="forms-sample" action="{{route('adminUpdateAppUpdate')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="form-group">
                                	<h4>Version - {{ $adminAppUpdate->value }}</h4>
                                </div>

                                <div class="form-group">
                                  <label for="app_version">app version :</label>
                                  <input type="text" class="form-control" id="app_version" name="app_version" placeholder="app version" value="{{$adminAppUpdate->value}}">
                                </div>

                                <button type="submit" class="btn btn-success mr-2">Update</button>
                              </form>
                          
                        </div>
                        <div class="tab-pane active show" id="fcm">
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
                              <!-- <h4 class="card-title">Change Password</h4> -->
                              <form class="forms-sample" action="{{route('adminUpdateFcm')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="form-group">
                                  <label for="server_key">Enter FCM Key</label>
                                  <input type="text" class="form-control" id="server_key" name="server_key" placeholder="server key" value="{{$adminFcm->server_key}}">
                                </div>

                                <div class="form-group">
                                  <label for="sender_id">Re-Enter FCM Key</label>
                                  <input type="text" class="form-control" id="sender_id" name="sender_id" placeholder="sender id" value="{{$adminFcm->sender_id}}">
                                </div>

                                <button type="submit" class="btn btn-success mr-2">Update</button>
                              </form>
                        </div>
                        <div class="tab-pane" id="otp">
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
                              <!-- <h4 class="card-title">Change Password</h4> -->
                              <form class="forms-sample" action="{{route('adminUpdateOtp')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                
                                <!--<div class="form-group">-->
                                <!--  <label>choose otp option : </label>-->
                                <!--  <select class="js-example-basic-single w-100 select-card-type" name="otp_option">-->
                                <!--    <option value="1" @if($adminOtp->value == '1') selected @endif>On</option>-->
                                <!--    <option value="0" @if($adminOtp->value == '0') selected @endif>Off</option>-->
                                <!--  </select>-->
                                <!--</div>-->
                                
                                <div class="form-group">
                                  <label for="mag_auth_key">Msg auth key :</label>
                                  <input type="text" class="form-control" id="mag_auth_key" name="mag_auth_key" placeholder="mag auth key" value="{{$adminMsgKey->mag_auth_key}}">
                                </div>

                                <div class="form-group">
                                  <label for="mag_sender_id">Msg sender id :</label>
                                  <input type="text" class="form-control" id="mag_sender_id" name="mag_sender_id" placeholder="msg sender id" value="{{$adminMsgKey->mag_sender_id}}">
                                </div>

                                <button type="submit" class="btn btn-success mr-2">Update</button>
                              </form>
                        </div>
                        <div class="tab-pane" id="about_us">
                        <a class="btn btn-success" href="{{route('addaboutus')}}">Add</a>
                      <div class="row">
                        <div class="col-12">
                          <div class="table-responsive">
                            <table id="order-listing" class="table">
                              <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>About Us</th>
                                    <th>Action</th>
                                    
                                </tr>
                              </thead>
                              <tbody>
                                  @if(count($abouts)>0)
                                  @php $i=1; @endphp
                                  @foreach($abouts as $terms)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td style="word-wrap: break-word;white-space:pre-wrap;"class="line_text">{{$terms->description}}</td>
                                    
                                    
                                    <td>
                                        <a href="{{route('editaboutus',$terms->id)}}" class="btn btn-info"  style="width: 10px;padding-left: 9px;" style="color: #fff;"><i class="fa fa-edit" style="width: 10px;"></i></a>
                      <button type="button"  style="width: 10px; padding-left: 11px;" class="btn btn-danger" data-toggle="modal" data-target="#about{{$terms->id}}"><i class="fa fa-trash"></i></button>
                      </td>

                                </tr>
                                @php $i++; @endphp
                                @endforeach
                              @else
                                <tr>
                                  <td>No data found</td>
                                </tr>
                              @endif
                              
                              </tbody>
                            </table>                    
                          </div>
                        </div>
                        </div>
            
            
                        </div>
                        <div class="tab-pane" id="tc">
                        <div class="row">
                                <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Terms and Conditions</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($term)>0)
                                        @php $i=1; @endphp
                                        @foreach($term as $terms)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td style="word-wrap: break-word;white-space:pre-wrap;"class="line_text">{{$terms->termcondition}}</td>
                                            
                                            
                                            <td>
                                                <a href="{{route('termconditionedit',$terms->id)}}" class="btn btn-info"  style="width: 10px;padding-left: 9px;" style="color: #fff;"><i class="fa fa-edit" style="width: 10px;"></i></a>
                                            <button type="button"  style="width: 10px; padding-left: 11px;" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$terms->id}}"><i class="fa fa-trash"></i></button>
                                            </td>

                                        </tr>
                                        @php $i++; @endphp
                                        @endforeach
                                    @else
                                        <tr>
                                        <td>No data found</td>
                                        </tr>
                                    @endif
                                    
                                    </tbody>
                                    </table>                    
                                </div>
                                </div>
                              </div>
                        </div>
                        <div class="tab-pane" id="map_key">
                        <form class="forms-sample" action="{{route('gmap_update')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                            <label for="exampleInputName1">Key</label>
                            <input type="text" class="form-control" id="exampleInputName1" style="width:50%;" name="gmap" value="{{$map->map_key}}" placeholder="GMap Key"></div>
      
                            
                          
                          <button type="submit" class="btn btn-success mr-2">Update</button>
                          <!--
                          <button class="btn btn-light">Cancel</button>
                          -->
                          <a href="" class="btn btn-light">Cancel</a>
                        </form>
                        </div>
                        <div class="tab-pane" id="user_review">
                        <div class="row">
                          <div class="col-12">
                            <div class="table-responsive">
                              <table id="order-listing" class="table">
                                <thead>
                                  <tr>
                                      <th>S.No</th>
                                      <th>Service Name</th>
                                      <th>User Name</th>
                                      <th>Rating Star</th>
                                      <th>Review Heading</th>
                                      <th>Review Description</th>
                                    
                                      <th>Action</th>
                                      
                                  </tr>
                                </thead>
                                <tbody>
                                    @if(count($tbl_rating)>0)
                                    @php $i=1; @endphp
                                    @foreach($tbl_rating as $rewards)
                                  <tr>
                                      <td>{{$i}}</td>
                                      <td>{{$rewards->service_name}}</td>
                                      <td>{{$rewards->user_name}}</td>
                                      <td>{{$rewards->rating}}</td>
                                      <td>{{$rewards->review_head}}</td>
                                      <td>{{$rewards->review_desc}}</td>
                                      
                                      <td>
                        <a href="#"  style="width: 10px; padding-left: 11px;" class="btn btn-danger btn-fab btn-fab-mini btn-round" data-toggle="modal" data-target="#exampleModal{{$rewards->rating_id}}"><i class="fa fa-trash"></i></a>
                        </td>

                                  </tr>
                                  @php $i++; @endphp
                                  @endforeach
                                @else
                                  <tr>
                                    <td>No data found</td>
                                  </tr>
                                @endif
                                
                                </tbody>
                              </table>                    
                            </div>
                          </div>
                        </div>
                        </div>
                        <div class="tab-pane" id="cc">
                        <a class="btn btn-success" href="{{route('complaint1')}}">Add</a>
                          <div class="row">
                            <div class="col-12">
                              <div class="table-responsive">
                                <table id="order-listing" class="table">
                                  <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Complaint Heading</th>
                                        <th>Complaint Price</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                  </thead>
                                  <tbody>
                                      @if(count($complaint_raise)>0)
                                      @php $i=1; @endphp
                                      @foreach($complaint_raise as $rewards)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$rewards->complaint_head}}</td>
                                        <td>{{$rewards->complaint_point}}</td>
                                        
                                        <td>
                                            <a href="{{route('editcomplaint',$rewards->complaint_id)}}" class="btn btn-primary btn-fab btn-fab-mini btn-round"  style="color: #fff;"><i class="fa fa-edit" ></i></a>
                          <a href="#"  class="btn btn-danger btn-fab btn-fab-mini btn-round" data-toggle="modal" data-target="#exampleModal{{$rewards->complaint_id}}"><i class="fa fa-trash"></i></a>
                          </td>

                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                  @else
                                    <tr>
                                      <td>No data found</td>
                                    </tr>
                                  @endif
                                  
                                  </tbody>
                                </table>                    
                              </div>
                            </div>
                          </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

          </div>
          @foreach($abouts as $terms)
<!-- Modal -->
<div class="modal fade" id="about{{$terms->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you want to delete About Us.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('deleteaboutus', $terms->id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
@foreach($term as $terms)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$terms->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Term</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you want to delete Terms?.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('termconditiondelete', $terms->id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
@foreach($complaint_raise as $rewards)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$rewards->complaint_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Complaints</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you sure want to Delete.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('deletecomplaint', $rewards->complaint_id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
@foreach($tbl_rating as $rewards)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$rewards->rating_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Review</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you sure want to delete.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('deleterating', $rewards->rating_id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
        </div>
        <!-- content-wrapper ends -->

@endsection