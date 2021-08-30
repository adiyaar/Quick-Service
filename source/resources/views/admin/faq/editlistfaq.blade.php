@extends('admin.layout.app')

@section ('content')


        <!-- remove -->
          <div class="row">
            
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Answer</h4>
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
                  <form class="forms-sample" action="{{route('updatefaq',$add->faq_desc_id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="form-group">
                      <div class="form-group">
                    <label for="exampleFormControlSelect3">FAQ Categories</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="faq_list">
                      @foreach($faq_category as $faq_category)
		          	<option value="{{$faq_category->faq_cat_id}}" @if($faq_category->faq_cat_id ==$add->faq_cat_id) selected @endif>{{$faq_category->faq_category}}</option>
		              @endforeach 
                    </select>
                    </div>
                    
                     <div class="form-group">
                      <label for="exampleInputName1">Question</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="category_name" value="{{$add->faq_qus}}" placeholder="Category Name" disabled></div>
                    
                    <div class="form-group">
                        <label for="exampleInputName1">Answer</label> 
                    <ul id="fieldList">
                        <ol>
                      <input type="text" class="form-control" id="exampleInputName1" name="price[]" value="" placeholder="Add Answer..."><br>
                         </ol>
                         <ol>
                      <input type="text" class="form-control" id="exampleInputName1" name="price[]" value="" placeholder="Add Answer..."><br>
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
          @if(count($faq_ans)>0)
          @php $i=1; @endphp
          @foreach($faq_ans as $faq_anws)
          
         
        <tr>
            <td>{{$i}}</td>
            <td>{{$faq_anws->faq_ans}}</td>
            <td>
              <a href="{{route('deletefaqans', [$faq_anws->faq_ans_id])}}" class="btn btn-danger">Delete</a>
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
    $("#fieldList").append("<ol><input type='text' class='form-control' name='price[]' id='exampleInputName1' placeholder='Add Answer...' /></ol><br>");
    $("#fieldList").append("<ol><input type='text' class='form-control' name='price[]' id='exampleInputName1' placeholder='Add Answer...' /></ol><br>");
    
  });
});
</script>
 @endsection