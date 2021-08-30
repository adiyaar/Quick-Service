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
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Update Logo</a>
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
                              <form class="forms-sample" action="{{route('adminUpdateWebLogo')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="form-group">
                                	<img src="{{url($adminWebLogo->value)}}" style="margin-left: auto; margin-right: auto; display: block;">
                                </div>

                                <div class="form-group">
      			                    <label>logo :</label>
      			                    <input type="file" name="app_logo" class="file-upload-default">
      			                    <div class="input-group col-xs-12">
      			                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload logo">
      			                        <span class="input-group-append">
      			                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
      			                        </span>
      			                    </div>
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