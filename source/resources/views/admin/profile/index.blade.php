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
                            <p class="profile-user-designation">SuperAdmin</p>
                          </div>
                        </div>
                      </div>
                      <div class="details">
                        <div class="detail-col ">
                          <!--<p>TotalApps</p>-->
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-body pt-0 pt-sm-4">
                    <ul class="nav tab-switch " role="tablist ">
                      <li class="nav-item ">
                        <a class="nav-link active " id="user-profile-info-tab " data-toggle="pill " href="#user-profile-info
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Change Profile</a>
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
                              <form class="forms-sample" action="{{route('adminChangeProfile',[$getAdmin->id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                  <label for="username">Username</label>
                                  <input type="text" class="form-control" id="username" name="username" placeholder="username" value="{{$getAdmin->username}}">
                                </div>
                                <div class="form-group">
                                  <label for="email">email</label>
                                  <input type="text" class="form-control" id="email" name="email" placeholder="email"  value="{{$getAdmin->email}}">
                                </div>
                                <div class="form-group">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                              <div class="fileinput-new thumbnail img-raised">
                           </div>
                              <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                              <div>
                              <span class="btn btn-raised btn-round btn-rose btn-file">
                                <span class="fileinput-new">Select image</span>
                                <span class="fileinput-exists">Change</span>
                                <input type="file" name="image" />
                              </span>
                                    <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput">
                                    <i class="fa fa-times"></i> Remove</a>
                              </div>
                                </div>
                                <button type="submit" class="btn btn-success mr-2">Update</button>
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