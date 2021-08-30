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
                              <form class="forms-sample" action="{{route('adminUpdateAdmob')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="form-group">
                                  <label for="app_id">app id :</label>
                                  <input type="text" class="form-control" id="app_id" name="app_id" placeholder="app id" value="{{$adminAdmob->app_id}}">
                                </div>

                                <div class="form-group">
                                  <label for="banner_unit_id">banner unit id :</label>
                                  <input type="text" class="form-control" id="banner_unit_id" name="banner_unit_id" placeholder="banner unit id" value="{{$adminAdmob->banner_unit_id}}">
                                </div>

                                <div class="form-group">
                                  <label for="interstitial_unit_id">interstitial unit id :</label>
                                  <input type="text" class="form-control" id="interstitial_unit_id" name="interstitial_unit_id" placeholder="interstitial unit id" value="{{$adminAdmob->interstitial_unit_id}}">
                                </div>

                                <div class="form-group">
                                  <label for="reward_unit_id">reward unit id :</label>
                                  <input type="text" class="form-control" id="reward_unit_id" name="reward_unit_id" placeholder="reward unit id" value="{{$adminAdmob->reward_unit_id}}">
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