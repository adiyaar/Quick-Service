@extends('admin.layout.app')

@section('content')

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
          <div class="row profile-page">
            <div class="col-12">
                <div class="card card-nav-tabs">
                    <div class="card-header card-header-primary">
                        <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
                        <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#faq" data-toggle="tab">
                                <i class="material-icons">image</i>
                                FAQ List
                                <div class="ripple-container"></div></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#secondary" data-toggle="tab">
                                <i class="material-icons">image</i>
                                FAQ Category
                                <div class="ripple-container"></div></a>
                            </li>

                            </ul>
                        </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="tab-content">
                        <div class="tab-pane active show" id="faq">
                  
              <div class="row">
                <div class="col-12 table-responsive">
                <a class="btn btn-success" href="{{route('faqdesadd')}}">Add</a>
                <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.No</th>
                            <th>FAQ Category</th>
                            <th>FAQ Question</th>
                            <th>Action</th>
                            
                        </tr>
                      </thead>
                      <tbody>
                          @if(count($faq_desc)>0)
                          @php $i=1; @endphp
                          @foreach($faq_desc as $add)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$add->faq_category}}</td>
                            <td>{{$add->faq_qus}}</td>
                            
                            
                            <td>
                                <a href="{{route('editfaq',$add->faq_desc_id)}}" class="btn btn-info"  style="width: 10px;padding-left: 9px;" style="color: #fff;"><i class="fa fa-edit" style="width: 10px;"></i></a>
							<button type="button"  style="width: 10px; padding-left: 11px;" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$add->faq_cat_id}}"><i class="fa fa-trash"></i></button>
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
                        
                        <div class="row">
                <div class="col-12">
                <a class="btn btn-success" href="{{route('addfaq')}}">Add</a>
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

          </div>
          <!-- Modal start -->
          @foreach($faq_desc as $add)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$add->faq_cat_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
				<a href="" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
<!-- Modal Ends -->
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
        </div>
        <!-- content-wrapper ends -->

@endsection
  