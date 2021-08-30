@extends('admin.layout.app')

@section ('content')
        <!-- remove -->
          <div class="row">
            
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Website Content </h4><br>
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
                  
                  <form class="forms-sample" action="{{route('filenewsubcategory',$category->sub_category_id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="form-group">
                    <label for="exampleFormControlSelect3">Sub Category</label><br>
                    <input value="{{$category->sub_category_name}}" disabled>
                    </div>
                      <div class="form-group">
                      <label for="exampleInputName1">Sub Heading</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="header_content" value="" placeholder="Sub Category Header Main Content"><br>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Multiple Points</label> 
                    <ul id="fieldList">
                        <ol>
                      <input type="text" class="form-control" id="exampleInputName1" name="header_subcontent[]" value="" placeholder="Add more points.."required><br>
                         </ol>
                    </ul>
                        <button id="addMore" class="btn btn-secondary">Add more fields</button>
                        <br>
                        <br>
                    </div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Sub Category Child Header Question</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="header_question" value="" placeholder="Sub Category Child Header Question"><br>
                      </div>
                    
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="{{route('filesubcategory',$category->sub_category_id)}}" class="btn btn-light">Cancel</a>
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
                            <th align="center">Header Main Content</th>
                            <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          @if(count($head)>0)
                          @php $i=1; @endphp
                          @foreach($head as $heads)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$heads->sub_category_header_main_content}}</td>
                            <td>
                              <a href="{{route('deleteheadercontent', [$heads->id])}}" class="btn btn-danger">Delete</a>
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
    $("#fieldList").append("<ol><input type='text' class='form-control' name='header_subcontent[]' id='exampleInputName1' placeholder='Add more points..' /></ol><br>");
    
  });
});
</script>

 


 @endsection