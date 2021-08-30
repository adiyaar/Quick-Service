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
              <h4 class="card-title">Add New Category</h4>
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
              <a class="btn btn-success" href="{{route('addfaq')}}">Add</a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Category Name</th>
                            <th>Action</th>
                            
                        </tr>
                      </thead>
                      <tbody>
                          @if(count($category)>0)
                          @php $i=1; @endphp
                          @foreach($category as $add)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$add->faq_category}}</td>
                            
                            
                            <td>
							<button type="button"  style="width: 10px; padding-left: 11px;" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash"></i></button>
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
     @foreach($category as $add)
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
				<a href="{{route('deletefaqcategory', [$add->faq_cat_id])}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
 
      
@endsection