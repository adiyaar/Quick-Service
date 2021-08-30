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
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Add App</a>
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
                              <form class="forms-sample" action="{{route('adminAddNewApp')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="form-group">
                                  <label for="app_name">App name :</label>
                                  <input type="text" class="form-control" id="app_name" name="app_name" placeholder="app name" value="{{old('app_name')}}">
                                </div>
                                <div class="form-group">
                                  <label for="app_link">App link :</label>
                                  <input type="text" class="form-control" id="app_link" name="app_link" placeholder="app link" value="{{old('app_link')}}">
                                </div>
                                <div class="form-group">
      			                      <label>App logo :</label>
      			                      <input type="file" name="app_logo" class="file-upload-default">
      			                      <div class="input-group col-xs-12">
      			                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload logo">
      			                        <span class="input-group-append">
      			                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
      			                        </span>
      			                      </div>
      			                    </div>

                                <div class="form-group">
                                  <label for="app_hex_code">App hex code (optional) :</label>
                                  <input type="text" class="form-control" id="app_hex_code" name="app_hex_code" placeholder="app name" value="{{old('app_hex_code')}}">
                                </div>

                                <div class="form-group">
                                  <label for="app_search_link">App search link (optional) :</label>
                                  <input type="text" class="form-control" id="app_search_link" name="app_search_link" placeholder="enter search link" value="{{old('app_search_link')}}">
                                </div>

                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <a href="{{route('adminApp')}}" class="btn btn-light">back</a>
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