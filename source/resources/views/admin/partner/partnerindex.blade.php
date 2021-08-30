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
              <h4 class="card-title">Add Partner</h4>
              <a class="btn btn-success" href="{{route('add_partner')}}">Add</a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Partner Name</th>
                            <th>Partner Phone</th>
                            <th>City</th>
                            
                            <th>Status</th>
                            <th>Action</th>
                            
                        </tr>
                      </thead>
                      <tbody>
                          @if(count($partner)>0)
                          @php $i=1; @endphp
                          @foreach($partner as $partners)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$partners->partner_name}}</td>
                            <td>{{$partners->partner_phone}}</td>
                            <td>{{$partners->city_name}}</td>
                           
                             <td>
                                 @if($partners->status==0)
                                   <span style="color:red;">Pending</span> 
                                 
                                @elseif($partners->status == 1)
                                    <span style="color:green;">Confirmed</span>
                                @else
                                    <span style="color:red;">Rejected</span>
                                @endif
                             </td>
                            <td>
                                <a href="{{route('partneredit',$partners->partner_id)}}" class="btn btn-primary btn-fab btn-fab-mini btn-round"   style="color: #fff;"><i class="fa fa-edit" ></i></a>
                                
                                @if($partners->holder_name)
                                
                                <a href="{{route('bankdetails',$partners->partner_id)}}" class="btn btn-primary btn-fab btn-fab-mini btn-round"  style="color: #fff;"><i class="fa fa-id-card"></i></a>
                               
                                
                                @endif
                                
                                
                                @if($partners->identify_proof)
                                <a href="{{route('details',[$partners->partner_id])}}" class="btn btn-primary btn-fab btn-fab-mini btn-round"   style="color: #fff;"><i class="fa fa-file" ></i></a>
                                @endif
							<a href="#" class="btn btn-danger btn-fab btn-fab-mini btn-round" data-toggle="modal" data-target="#exampleModal{{$partners->partner_id}}"><i class="fa fa-trash"></i></a>
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
                    {{ $partner->render("pagination::bootstrap-4") }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     @foreach($partner as $partners)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$partners->partner_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Partner</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you want to delete Partner.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('deletepartner',$partners->partner_id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
 
      
@endsection