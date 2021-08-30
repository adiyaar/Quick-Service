@extends('admin.layout.app')

@section('content')

        <!-- remove -->
          <div class="row profile-page">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="profile-header text-white d-none d-md-block">
                    <div class="d-flex justify-content-around">
                      <div class="profile-info d-flex justify-content-center align-items-md-center">
                        <img class="rounded-circle img-lg" src="{{url($getAdmin->image)}}" alt="profile image">
                        <div class="wrapper pl-4">
                          <p class="profile-user-name">{{$getAdmin->username}}</p>
                          <div class="wrapper d-flex align-items-center">
                            <p class="profile-user-designation">Super Admin</p>
                          </div>
                        </div>
                      </div>
                      <div class="details">
                        <div class="detail-col ">
                         
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-body pt-0 pt-sm-4">
                    <ul class="nav tab-switch " role="tablist ">
                      <li class="nav-item ">
                        <a class="nav-link active " id="user-profile-info-tab " data-toggle="pill " href="#user-profile-info
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Change Password</a>
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
                              <form class="forms-sample" action="{{route('adminChangePassword',[$getAdmin->id])}}" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                  <label for="currentPassword">Current Password</label>
                                  <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="current password" value="{{old('current_password')}}">
                                </div>
                                <div class="form-group">
                                  <label for="newPassword">New Password</label>
                                  <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="new password" value="{{old('new_password')}}">
                                </div>
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
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