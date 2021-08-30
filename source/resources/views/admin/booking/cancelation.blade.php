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
.button1 {
  background-color: #4CAF50;
  border-radius:0px;
}
</style>

@extends('admin.layout.app')

@section ('content')
   <!-- remove -->
          <div class="card">
            <div class="card-body">
              <b><h4 class="card-title">Booking Status</h4></b>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>S.No</th>
                            <th>User Name</th>
                            <th>User Phone</th>
                            <!--<th>Service Name</th>-->
                            <th>Date of Booking</th>
                            <th>Confirmed On</th>
                            <th>Payment Method</th>
                            <th>Price</th>
                            <th>Booking Status</th>
                            
                            
                        </tr>
                      </thead>
                      <tbody>
                          @if(count($booking)>0)
                          @php $i=1; @endphp
                          @foreach($booking as $bookings)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$bookings->user_name}}</td>
                            <td>{{$bookings->user_phone}}</td>
                            <td>{{$bookings->booking_date}}</td>
                            <td>{{$bookings->confirmed_on}}</td>
                            <td>{{$bookings->payment_mode}}</td>
                            <td>{{$bookings->price}}</td>
                            
                             <td><span style="color:red;">Cancelled</span></td>
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
                     {{$booking->render("pagination::bootstrap-4")}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       
 
      
@endsection