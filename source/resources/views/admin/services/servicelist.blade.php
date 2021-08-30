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
              <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title"> Services</h4>
                  <p class="card-category"> Here is a subtitle for this table</p>
                </div>
                <div class="card-body">
                <a class="btn btn-success" href="{{route('add_service')}}">Add</a>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-primary">
                          <th>S.No</th>
                            <th>Child Category Name</th>
                            <th>Services Name</th>
                            <th>Services Image</th>
                            <th>Action</th>
                      </thead>
                      <tbody>
                      @if(count($services)>0)
                          @php $i=1; @endphp
                          @foreach($services as $service)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$service->child_name}}</td>
                            <td>{{$service->service_name}}</td>
                             <td><img src="{{url($service->service_img)}}"></td>
                            
                        
                            <td class="text-center">
         
                    
                                <a href="{{route('editservice',$service->service_id)}}" class="btn btn-primary btn-fab btn-fab-mini btn-round"  style="width: 10px;padding-left: 9px;" style="color: #fff;"><i class="fa fa-edit" ></i></a>
                                <a href="#" class="btn btn-primary btn-fab btn-fab-mini btn-round" data-toggle="modal" data-target="#exampleModal{{$service->service_id}}"><i class="fa fa-trash"></i></a>
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
                  {{ $services->render("pagination::bootstrap-4") }}
                </div>
              </div>
            </div>
    
        </div>
     @foreach($services as $service)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$service->service_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you want to delete Category.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('deleteservice', $service->service_id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
 
      
@endsection