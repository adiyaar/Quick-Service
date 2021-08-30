@extends('admin.layout.app')

@section('content')

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 52px;
  height: 25px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  top: 0px;
  position: absolute;
  content: "";
  height: 25px;
  width: 25px;
  left: 0px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

  <!-- remove -->
        <div class="card">
            <div class="card-body">
              <!--<a class="btn btn-success" href="{{route('adminAddUser')}}">Add</a>-->
              <br><br>
              <h4 class="card-title">Data table</h4>
              	     	<fieldset class="form-group position-relative">
			                <input type="text" class="form-control form-control-xl input-xl" id="search_name" placeholder="Search User...">
			                <div class="form-control-position">
			                  <i class="ft-search font-medium-4"></i>
			                </div>
	              		</fieldset>
              
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
                
              <div class="row">
                <div class="col-12 table-responsive">
                  <table id="order-listing" class="table">
                    <thead>
                      <tr>
                          <th>S.No</th>
                         <th>User Name</th>
                        <th>Email</th>
                         <th>Phone Number</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                   
                    <tbody id="hide" style="text">
                      @if(count($adminUser)>0)
                        @php $i=1; @endphp
                        @foreach($adminUser as $adminUsers)
                          <tr>
                            <td>{{$i}}</td>
                           
                            <td>{{$adminUsers->user_name}}</td>
                            <td>{{$adminUsers->user_email}}</td>
                             <td>{{$adminUsers->user_phone}}</td>
                            <td>
                                    <a href="{{route('adminEditUser', [$adminUsers->id])}}" class="btn btn-primary">Edit</a>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$adminUsers->id}}">Delete </button>
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
                     <tbody id="show" style="display: none;">
                          </tbody>
                  </table>
                   {{ $adminUser->render("pagination::bootstrap-4") }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".checkbox").click(function(){
      var val = $(this).val();
      var user_id = $(this).attr('user_id');
      // alert(val);
      if(val == 1){
        $(".checkbox").val('0');
      }
      else{
        $(".checkbox").val('1');
      }
      $.ajax({
        url:"{{route('adminUserStatus')}}",
        type:"get",
        data:{user_id:user_id, val:val},
        success:function(data){
          // alert(data);
        }
      });
    });
  });
   $(document).ready(function(){
      $("#search_name").keyup(function(){
        var entered_name = $("#search_name").val();
        var length = entered_name.length;
        if (length > 1){
          $.ajax({
          url:"{{route('searchsubject')}}",
          type:"get",
          data:{entered_name:entered_name},
          success:function (data) {
            var l = data.length;
            for (var i = 0; i < l; i++) {
                var j = i+1;
                
                 data[i] = "<tr><th scope='row'>"+j+"</th><td>"+data[i].user_name+"</td><td>"+data[i].user_email+"</td><td>"+data[i].user_phone+"</td><td>"+data[i].trade_url+"</td><td></td><td><a class='btn btn-info btn-glow mr-1 mb-1' href='{{url('/admin/user/edit')}}/"+data[i].id+"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-glow mr-1 mb-1' style='color:white;' data-toggle='modal' data-target='#inlineForm1"+data[i].id+"'><i class='icon-trash'></i></a><div class='modal fade text-left' id='inlineForm1"+data[i].id+"' tabindex='-1' role='dialog' aria-labelledby='myModalLabel33' aria-hidden='true'><div class='modal-dialog' role='document'><div class='modal-content'><div class='modal-header'><label class='modal-title text-text-bold-600' id='myModalLabel33'></label><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div><form action='#'><div class='modal-body center'><h3>Are You Want to Delete</h3></div><div class='modal-footer'><input type='reset' class='btn btn-outline-secondary btn-sm round' data-dismiss='modal' value='close'><a href='{{url('/admin/user/delete')}}/"+data[i].id+"' class='btn btn-outline-primary btn-sm round'>Delete</a></div></form></div></div></div></td></tr>";
              }
              $("#show").html(data);
              $("#show").show();
              $("#hide").hide();
            }
          });
        }
        else{
          $("#show").hide();
          $("#hide").show();
        }
      });
    });
</script>

<!-- Modal start -->
@foreach($adminUser as $adminUsers)
  <div class="modal fade" id="deleteModal{{$adminUsers->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel-2">delete user</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>are you sure?? press confirm button to delete.</p>
        </div>
        <div class="modal-footer">
          <a href="{{route('adminDeleteUser', [$adminUsers->id])}}" type="button" class="btn btn-danger">Confirm</a>
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
<!-- Modal Ends -->

@endsection