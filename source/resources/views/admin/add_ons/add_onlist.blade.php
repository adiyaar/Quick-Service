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
              <h4 class="card-title">Add new Add-Ons</h4>
              <a class="btn btn-success" href="{{route('add_ons')}}">Add</a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Child category</th>
                            <th>Action</th>
                            
                        </tr>
                      </thead>
                      <tbody>
                          @if(count($add_ons)>0)
                          @php $i=1; @endphp
                          @foreach($add_ons as $add)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$add->child_name}}</td>
                            
                            
                            <td>
                                <a href="{{route('editadd_ons',$add->add_on_id)}}" class="btn btn-primary btn-fab btn-fab-mini btn-round" style="color: #fff;"><i class="fa fa-edit" ></i></a>
							<a href="#"  class="btn btn-danger btn-fab btn-fab-mini btn-round" data-toggle="modal" data-target="#exampleModal{{$add->add_on_id}}"><i class="fa fa-trash"></i></a>
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
     @foreach($add_ons as $add)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$add->add_on_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
				<a href="{{route('deletetitle', [$add->add_on_id])}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
 
      
@endsection