@extends('admin.layout.app')

@section ('content')
        <!-- remove -->
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Category Points</h4>
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
                  <form class="forms-sample" action="{{route('updatepoint',$category->category_id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    
                      <div class="form-group">
                    <label for="exampleFormControlSelect3">Heading</label>
                     <input type="text" class="form-control" id="exampleInputName1" name="heading" value="" placeholder="Heading">
                    </div>
                      
                    <div class="form-group">
                        <label for="exampleInputName1">Add Points</label> 
                    <ul id="fieldList">
                        <ol>
                      <input type="text" class="form-control" id="exampleInputName1" name="point[]" value="" placeholder="Add more points.."><br>
                         </ol>
                         <ol>
                    </ul>
                        <button id="addMore" class="btn btn-secondary">Add more fields</button>
                        <br>
                        <br>
                    </div>    
                    
                    
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a href="{{route("categorypoint",$category->category_id)}}" class="btn btn-light">Cancel</a>
                  </form>
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
                            <th align="center">Points</th>
                            <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
          @if(count($point)>0)
          @php $i=1; @endphp
          @foreach($point as $points)
          
         
        <tr>
            <td>{{$i}}</td>
            <td>{{$points->point}}</td>
            <td>
              <a href="{{route('deletepoint', $points->points)}}" class="btn btn-danger">Delete</a>
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
    $("#fieldList").append("<ol><input type='text' class='form-control' name='point[]' id='exampleInputName1' placeholder='Add more points..' /></ol><br>");
    
  });
});
</script>
 @endsection