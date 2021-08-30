@extends('admin.layout.app')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<style>
   
    .material-icons{
        margin-top:0px !important;
        margin-bottom:0px !important;
    }
</style>
@section ('content')
<div class="container-fluid">
 <div class="row">
<div class="col-lg-12">
    @if (session()->has('success'))
   <div class="alert alert-success">
    @if(is_array(session()->get('success')))
            <ul>
                @foreach (session()->get('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
            @else
                {{ session()->get('success') }}
            @endif
        </div>
    @endif
     @if (count($errors) > 0)
      @if($errors->any())
        <div class="alert alert-danger" role="alert">
          {{$errors->first()}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
      @endif
    @endif
    </div>
<div class="col-lg-12">
    <div class="col-lg-12" align="right"><a class="btn btn-primary" href="{{route('pay_req')}}" rel="tooltip">
                            <i class="fa fa-exit" style="color:red"></i>ALL Withdrawal Requests
                            </a></div>   
<div class="card">    
<div class="card-header card-header-primary">
      <h4 class="card-title ">{{$title}}</h4>
    </div>
 <div class="card-header card-header-secondary">
    <form class="forms-sample" action="{{route('pay_req_date')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                     <div class="row">
                       <div class="col-md-4"><br>
                        <div class="form-group">
                          <label>Start Date</label><br>
                          <input type="date" name="start_date" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4"><br>
                        <div class="form-group">
                          <label>End Date</label><br>
                          <input type="date" name="end_date" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-4">
                          <br>
                        <div class="form-group">
                          <button type="submit"  style="margin-bottom: 13px;margin-top: 10px;" class="btn btn-primary">Show Requests</button>
                        </div>
                      </div>
                    </div>  
            </form>
       </div><hr>    
    
<div class="table-responsive">
<table id="order-listing" class="table display">
    <thead>
        <tr>
            <th class="text-center">#</th>
                      <!--<th>ID</th>-->
                      <th>Booking id</th>
                      <th>Partner</th>
                      <th>Booking Price</th>
                      <th>Request date</th>
                      <th>UPI/PAYPAL</th>
                      <th>Booking Coins</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                         @if(count($total_earnings)>0)
                          @php $i=1; @endphp
                          @foreach($total_earnings as $total_earning)
                            <tr>
                                <td class="text-center">{{$i}}</td>
                                <td class="text-center">{{$total_earning->booking_id}}</td>
                                <td>{{$total_earning->partner_name}} <p style="font-size:14px">({{$total_earning->partner_phone}})</p></td>
                                <td>{{$total_earning->booking_price}}</td>
                                <td>{{$total_earning->request_date}}</td>
                                @if($total_earning->complete == 2 || $total_earning->complete == 1)
                                <td>{{$total_earning->upi}}</td>
                                @elseif($total_earning->complete == 3)
                                <td><span style="color:red">Rejected</span></td>
                                @else
                                <td><span style="color:orange">Not approved yet</span></td>
                                @endif
                                <td>{{$total_earning->booking_coins}}</td>
                                <td>
                                    @if($total_earning->complete == 1)
                                    <span style="color:green">Paid</span>
                                    @elseif($total_earning->complete == 0)
                                     <a href="{{route('approve_payout' , $total_earning->req_id)}}" class="btn btn-primary">Approve</a>
                                    <a href="{{route('reject_payout' , $total_earning->req_id)}}" class="btn btn-danger">Reject</a>
                                    @elseif($total_earning->complete == 3)
                                    <span style="color:red">Rejected</span>
                                    @else
                                    <a href="{{route('partner_pay' , $total_earning->req_id)}}" class="btn btn-primary">Mark Paid</a>
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
<div>
  </div>
 <script>
        $(document).ready( function () {
    $('#order-listing').DataTable();
} );
    </script>
    @endsection
</div>