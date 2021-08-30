<style>
    a.btn.btn-info {
    border-radius: 49%;
    background-color: transparent;
    color: grey;
    border: 2px solid;
}
button.btn.btn-danger {
    border-radius: 49%;
    background-color: transparent;
    color: grey;
    border: 2px solid;
}
    a.btn.btn-info:hover {
    border-radius: 49%;
    background-color: black;
    color: white;
    border: 2px solid;
}
button.btn.btn-danger:hover {
    border-radius: 49%;
    background-color: black;
    color: white;
    border: 2px solid;
}
</style>

@extends('admin.layout.app')

@section ('content')
   <!-- remove -->
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">LeaderBoard</h4>
              <!--<a class="btn btn-success" href="">Add</a>-->
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Profile Image</th>
                            <th>Total Coins</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          @if(count($tbl_user)>0)
                          @php $i=1; @endphp
                          @foreach($tbl_user as $rewards)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$rewards->user_name}}</td>
                             <td><img src="{{url('').'/'.$rewards->user_image}}"></td>
                                <td>{{$rewards->user_reward}}</td>      
                            <td>
                                <button type="button"  style="width: 10px; padding-left: 11px;" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$rewards->id}}"><i class="fa fa-trash"></i></button>
							</td>
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
                     {{ $tbl_user->render("pagination::bootstrap-4") }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     @foreach($tbl_user as $rewards)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$rewards->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you want to delete User.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('leaderdelete', $rewards->id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
 
      
@endsection