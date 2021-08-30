@extends('admin.layout.app')

@section('content')

	<!-- remove -->
        <div class="card">
            <div class="card-body">
              <!-- <a class="btn btn-success" href="#">Add</a> -->
              <br><br>
              <h4 class="card-title">Data table</h4>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Paytm no.</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    	@if(count($adminWithdrawRequest)>0)
                    		@php $i=1; @endphp
                    		@foreach($adminWithdrawRequest as $adminWithdrawRequests)
                    		  <tr>
		                        <td>{{$i}}</td>
		                        <td>{{$adminWithdrawRequests->user_name}}</td>
		                        <td><i class="fa fa-inr"></i>{{$adminWithdrawRequests->redeem_points}}</td>
		                        <td>{{$adminWithdrawRequests->paytm_number}}</td>
		                        <td>
		                        	@if($adminWithdrawRequests->status == 0)
		                        		<a class="btn btn-success" href="{{route('adminWithdrawRequestApprove', [$adminWithdrawRequests->id])}}">Approve</a>
		                        	@else
		                        		<button class="btn btn-primary">Done</button>
		                        	@endif
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

@endsection