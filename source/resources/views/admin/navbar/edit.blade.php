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
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Edit Navbar App</a>
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
                              <form class="forms-sample" action="{{route('adminUpdateNavBarApp', [$navbar->id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="form-group">
                                  <label for="navbar_app_name">navbar app name :</label>
                                  <input type="text" class="form-control" id="navbar_app_name" name="navbar_app_name" placeholder="navbar app name" value="{{$navbar->navbar_app_name}}">
                                </div>

                                <div class="form-group">
      			                    <label>navbar app icon :</label>
      			                    <input type="file" name="navbar_app_icon" class="file-upload-default">
      			                    <div class="input-group col-xs-12">
      			                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Icon">
      			                        <span class="input-group-append">
      			                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
      			                        </span>
      			                    </div>
      			                </div>

                                <div class="form-group">
                                  <label for="navbar_app">select app :</label>
                                  <div class="row">
                                    @foreach($app as $apps)
                                      <div class="col-md-3" style="margin-top: 5px;">
                                        <img src="{{url($apps->app_logo)}}" style="width: 30px; height: 30px; display: block; margin: auto;">
                                        <div class="form-check form-check-flat" style="margin: 4px 20px 2px 20px;">
                                          <label class="form-check-label" style="font-size: 11px;">
                                            <input type="checkbox" name="navbar_app[]" value="{{$apps->id}}" class="form-check-input" @if(in_array($apps->id, json_decode($navbar->navbar_app))) checked @endif> {{$apps->app_name}}
                                          </label>
                                        </div>
                                      </div>
                                    @endforeach
                                  </div>
                                </div>

                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <a href="{{route('adminNavBarApp')}}" class="btn btn-light">back</a>
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