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
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Update FCM</a>
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