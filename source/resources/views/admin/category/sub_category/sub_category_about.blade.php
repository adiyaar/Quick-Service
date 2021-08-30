
   <style>
.raffleimg{
    width: 100px;
    border-radius: 50%;
    height: 100px;
}
.line_text{
    overflow: hidden;
   text-overflow: ellipsis;
   display: -webkit-box;
   -webkit-box-orient: vertical;
   -webkit-line-clamp: 2 !important;
}
</style>
@extends('admin.layout.app')

@section ('content')
        <!-- remove -->
          
          <!--start-->
           <div class="row">
		  <div class="col-md-1">
		  </div>
            
            <div class="col-md-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 <h4 class="card-title">About</h4>
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
                  
                  <form class="forms-sample" action="{{route('newsub_category_about',$category->sub_category_id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="form-group">
                      <label for="exampleInputName1">Description title</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="description_title" value="" placeholder="Sub Category Header Main Content"><br>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Description</label> 
                        <textarea type="text" class="form-control" id="exampleInputName1" name="description" value=""></textarea>
                        </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="{{--route('filesubcategory',$category->sub_category_id)--}}" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div> 
            </div>
          <!--end-->
          <!--start-->
           <div class="row">
		  <div class="col-md-1">
		  </div>
            
            <div class="col-md-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 <h4 class="card-title">About</h4>
                   <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                            <th>S.No</th>
                            <th>Description Title</th>
                            <th>Description</th>
                        </tr>
                      </thead>
                      <tbody>
                          @if(count($about)>0)
                          @php $i=1; @endphp
                          @foreach($about as $abouts)
                        <tr>
                             <td>{{$i}}</td>
                             <td>{{$abouts->sub_category_about_title}}</td>
                             <td style="word-wrap: break-word;white-space:pre-wrap;" class="line_text">{{$abouts->sub_category_about_desc}}</td>
                            <td>
                                <a href="{{route('editabout',$abouts->id)}}" class="btn btn-info"  style="width: 10px;padding-left: 9px;" style="color: #fff;"><i class="fa fa-edit" style="width: 10px;"></i></a>
							<button type="button"  style="width: 10px; padding-left: 11px;" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$abouts->id}}"><i class="fa fa-trash"></i></button>
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
             <div class="col-md-1">
		  </div>
     
          </div>
          
          <!--end-->
        
          @foreach($about as $abouts)
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{$abouts->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            				<a href="{{route('deleteabout', $abouts->id)}}" class="btn btn-primary">Delete</a>
            			</div>
            		</div>
            	</div>
            </div>
                @endforeach  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
        	$(document).ready(function(){
        	
                $(".des_price").hide();
                
        		$(".img").on('change', function(){
        	        $(".des_price").show();
        			
        	});
        	});
</script>



 @endsection