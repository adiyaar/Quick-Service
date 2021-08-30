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
                        " role="tab " aria-controls="user-profile-info " aria-selected="true ">Edit Price</a>
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
                              <form class="forms-sample" action="{{route('updatehygine', [$category1->price_id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                    
                                     <div class="form-group">
                    <label for="exampleFormControlSelect3">Selected Category</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="child_category_id">
                       @foreach($child_category as $category)
		          	<option value="{{$category->child_category_id}}" @if($category->child_category_id == $category1->child_category_id) selected @endif>{{$category->child_name}}</option>
		              @endforeach
                    </select>
                    </div>
                                    
                                <div class="form-group">
                                  <label for="banner_name">Price</label>
                                  <input type="text" class="form-control" id="banner_name" name="price" placeholder="Price" value="{{$category1->price}}">
                                </div>



                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <a href="{{route('lowerbannerindex')}}" class="btn btn-light">back</a>
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