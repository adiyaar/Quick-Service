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
              <h4 class="card-title">coupon</h4>
              <a class="btn btn-success" href="{{route('add-coupon')}}">Add</a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Coupon Name</th>
                            <th>Coupon Image</th>
                            <th>Coupon Price</th>
                             <th>Discount</th>
                             <th>Cart value</th>
                             
                            <th>Coupon Decsription</th>
                            <th>Action</th>
                            
                        </tr>
                      </thead>
                      <tbody>
                          @if(count($coupon)>0)
                          @php $i=1; @endphp
                          @foreach($coupon as $coupons)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$coupons->coupon_name}}</td>
                           
                            <td><img src="{{url($coupons->coupon_image)}}"></td>
                             <td>{{$coupons->coupon_code}}</td>
                             
                             <td>{{$coupons->coupon_discount}}</td>
                             <td>{{$coupons->cart_value}}</td>
                             
                            <td>{{$coupons->description}}</td>
                            <td>
                               <a href="{{route('edit-coupon',$coupons->coupon_id)}}" class="btn btn-primary btn-fab btn-fab-mini btn-round"  style="color: #fff;"><i class="fa fa-edit" ></i></a>
							<a href="#"  class="btn btn-danger btn-fab btn-fab-mini btn-round" data-toggle="modal" data-target="#exampleModal{{$coupons->coupon_id}}"><i class="fa fa-trash"></i></a>
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
     @foreach($coupon as $coupons)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$coupons->coupon_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete banner</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you want to delete coupon.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('delete-coupon', $coupons->coupon_id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
 
      
@endsection