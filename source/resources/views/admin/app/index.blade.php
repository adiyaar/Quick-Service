@extends('admin.layout.app')

@section('content')

	<!-- remove -->
        <div class="card">
            <div class="card-body">
              <a class="btn btn-success" href="{{route('adminAddApp')}}">Add</a>
              <br><br>
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
              <h4 class="card-title">Data table</h4>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>App Name</th>
                        <th>Logo</th>
                        <th>Link</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    	@if(count($adminApp)>0)
                    		@php $i=1; @endphp
                    		@foreach($adminApp as $adminApps)
                    		  <tr>
		                        <td>{{$i}}</td>
		                        <td>{{$adminApps->app_name}}</td>
		                        <td>
		                        	<img src="{{url($adminApps->app_logo)}}">
		                        </td>
		                        <td>
                              <span style="display: block; width: 300px; overflow: hidden; text-overflow: ellipsis;">
                                {{$adminApps->app_link}}
                              </span>  
                            </td>
		                        <td>
                              <a href="{{route('adminEditApp', [$adminApps->id])}}" class="btn btn-primary">Edit</a>
		                          <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$adminApps->id}}">Delete</button>
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
@foreach($adminApp as $adminApps)
  <div class="modal fade" id="deleteModal{{$adminApps->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel-2">Delete app</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure.</p>
        </div>
        <div class="modal-footer">
          <a href="{{route('adminDeleteApp', [$adminApps->id])}}" type="button" class="btn btn-danger">Delete</a>
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
<!-- Modal Ends -->


@endsection