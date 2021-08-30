@extends('admin.layout.app')

@section('content')

        <!-- remove -->
          <div class="row profile-page">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="profile-body pt-0 pt-sm-4">
                    <ul class="nav tab-switch " role="tablist ">
                      <li class="nav-item ">
                        <a class="nav-link active " id="user-profile-info-tab " data-toggle="pill " href="#user-profile-info
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Update Admob</a>
                      </li>
                    </ul>
                    <div class="row ">
                      <div class="col-2 col-md-2"></div>
                      <div class="col-8 col-md-8">
                        <div class="tab-content tab-body " id="profile-log-switch ">
                          <div class="card">
                            <div class="card-body">
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
                          </div>
                        </div>
                      </div>
                      <div class="col-2 col-md-2"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

@endsection