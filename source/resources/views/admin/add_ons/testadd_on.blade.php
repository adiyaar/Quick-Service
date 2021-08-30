@extends('admin.layout.app')

@section ('content')


        <!-- remove -->
          <div class="row">
            
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Add Ons</h4>
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
                  <form class="forms-sample" action="{{route('addmultiple')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="form-group">
                      <div class="form-group">
                    <label for="exampleFormControlSelect3">Services</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="service_list">
                      @foreach($services as $service)
		          	<option value="{{$service->service_id}}" @if($service->service_id ==$add->service_id) selected @endif>{{$service->service_name}}</option>
		              @endforeach 
                    </select>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputName1">Add-ons Title</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="add_title" value="" placeholder="Add-on Title"></div>
                      
                    <div class="form-group">
                        <label for="exampleInputName1">Add-ons Points</label> 
                    <ul id="fieldList">
                        <ol>
                      <input type="text" class="form-control" id="exampleInputName1" name="box[]" value="" placeholder="Add more points.."><br>
                         </ol>
                         <ol>
                      <input type="text" class="form-control" id="exampleInputName1" name="box[]" value="" placeholder="Add Price"><br>
                        </ol>
                    </ul>
                        <button id="addMore" class="btn btn-secondary">Add more fields</button>
                        <br>
                        <br>
                    </div>    
                    
                    
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a href="" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
            
     
          </div>
          
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                            <th>S.No</th>
                            <th align="center">Add Ons</th>
                            <th>Action</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                            <th>S.No</th>
                            <th align="center">Add Ons</th>
                            <th>Action</th>
                            </tr>
                          </tfoot>
                          <tbody>
          @if(count($add_ons_des)>0)
          @php $i=1; @endphp
          @foreach($add_ons_des as $add_ons_desc)
          
         
        <tr>
            <td>{{$i}}</td>
            <td>{{$add_ons_desc->add_on_des}}</td>
            <td>
              <a href="{{route('deleteaddons', [$add_ons_desc->des_id])}}" class="btn btn-danger">Delete</a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
        	$(document).ready(function(){
        	
                $(".des_price").hide();
                
        		$(".img").on('change', function(){
        	        $(".des_price").show();
        			
        	});
        	});
        	$(function() {
  $("#addMore").click(function(e) {
    e.preventDefault();
    $("#fieldList").append("<ol></ol>");
    $("#fieldList").append("<ol><input type='text' class='form-control' name='box[]' id='exampleInputName1' placeholder='Add more points..' /></ol><br>");
    $("#fieldList").append("<ol><input type='text' class='form-control' name='box[]' id='exampleInputName1' placeholder='Add Price' /></ol><br>");
    
  });
});
</script>
 @endsection