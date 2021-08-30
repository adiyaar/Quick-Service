@extends('admin.layout.app')

@section('content')

  <!-- remove -->
        <div class="card">
            <div class="card-body">
              <a class="btn btn-success" href="{{route('adminAddNavBarApp')}}">Add</a>
              <br><br>
              <h4 class="card-title">Data table</h4>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Icon Name</th>
                        <th>Logo</th>
                        <th></th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($adminNavBarApp)>0)
                        @php $i=1; @endphp
                        @foreach($adminNavBarApp as $adminNavBarApps)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$adminNavBarApps->navbar_app_name}}</td>
                            <td>
                              <img src="{{url($adminNavBarApps->navbar_app_icon)}}" style="background-color:#000">
                            </td>
                            <td></td>
                            <td>
                              <a href="{{route('adminEditNavBarApp', [$adminNavBarApps->id])}}" class="btn btn-primary">Edit</a>
                              <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$adminNavBarApps->id}}">Delete</button>
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
        <!-- content-wrapper ends -->

<!-- Modal start -->
@foreach($adminNavBarApp as $adminNavBarApps)
  <div class="modal fade" id="deleteModal{{$adminNavBarApps->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel-2">Delete Navbar app</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure.</p>
        </div>
        <div class="modal-footer">
          <a href="{{route('adminNavBarAppDelete', [$adminNavBarApps->id])}}" type="button" class="btn btn-danger">Delete</a>
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
<!-- Modal Ends -->

@endsection