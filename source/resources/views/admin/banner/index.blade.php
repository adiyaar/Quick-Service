@extends('admin.layout.app')

@section('content')

        <!-- remove -->
          <div class="row profile-page">
            <div class="col-12">
                <div class="card card-nav-tabs">
                    <div class="card-header card-header-primary">
                        <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                        <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#banner_main" data-toggle="tab">
                                <i class="material-icons">image</i>
                                Main Banner
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#secondary" data-toggle="tab">
                                <i class="material-icons">image</i>
                                Secondary banner
                                <div class="ripple-container"></div></a>
                            </li>

                            </ul>
                        </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content">
                        <div class="tab-pane active show" id="banner_main">
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
              <div class="row">
                <div class="col-12 table-responsive">
                <a class="btn btn-success" href="{{route('adminAddBanner')}}">Add</a>
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Banner Name</th>
                        <th>Banner Icon</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($adminBanner)>0)
                        @php $i=1; @endphp
                        @foreach($adminBanner as $adminBanners)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$adminBanners->banner_name}}</td>
                            <td>
                              <img src="{{url($adminBanners->banner_image)}}">
                            </td>
                            <td>
                              <a href="{{route('adminEditBanner', [$adminBanners->id])}}" class="btn btn-primary">Edit</a>
                              <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$adminBanners->id}}">Delete</button>
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
                        <div class="tab-pane" id="secondary">
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
              <div class="row">
                <div class="col-12 table-responsive">
                <a class="btn btn-success" href="{{route('lowerbanner')}}">Add</a>
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Banner Name</th>
                        <th>Banner Icon</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($secondary_banner)>0)
                        @php $i=1; @endphp
                        @foreach($secondary_banner as $adminBanners)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$adminBanners->heading}}</td>
                            <td>
                              <img src="{{url($adminBanners->banner_image)}}">
                            </td>
                            <td>
                              <a href="{{route('editlowerbanner', [$adminBanners->banner_id])}}" class="btn btn-primary">Edit</a>
                              <button class="btn btn-danger" data-toggle="modal" data-target="#deleteSecondary{{$adminBanners->banner_id}}">Delete</button>
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
          <!-- Modal start -->
@foreach($adminBanner as $adminBanners)
  <div class="modal fade" id="deleteModal{{$adminBanners->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel-2">delete banner</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>are you sure.</p>
        </div>
        <div class="modal-footer">
          <a href="{{route('adminDeleteBanner', [$adminBanners->id])}}" type="button" class="btn btn-danger">Delete</a>
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endforeach

@foreach($secondary_banner as $adminBanners)
  <div class="modal fade" id="deleteSecondary{{$adminBanners->banner_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel-2">delete banner</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>are you sure.</p>
        </div>
        <div class="modal-footer">
          <a href="{{route('deletelowerbanner', [$adminBanners->banner_id])}}" type="button" class="btn btn-danger">Delete</a>
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
<!-- Modal Ends -->

        </div>
        <!-- content-wrapper ends -->

@endsection