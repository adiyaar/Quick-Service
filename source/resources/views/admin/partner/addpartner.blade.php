@extends('admin.layout.app')
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no"/>

    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>
    <script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font: 16px Arial;
        }

        /*the container must be positioned relative:*/
        .autocomplete {
            position: relative;
            display: inline-block;
        }

        input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        input[type=text] {
            width: 100%;
        }

        input[type=submit] {
            background-color: DodgerBlue;
            color: #fff;
            cursor: pointer;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
   
 <style>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="crossorigin="anonymous"></script>
      #map {
        height: 100%;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
    </style>
@section ('content')
        <!-- remove -->
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Partner</h4><br>
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
                  <form class="forms-sample" action="{{route('addnewpartner')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="form-group">
                    <label for="exampleFormControlSelect3">Select Category</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="sub_category_id">
                    <option value="">Select Category </option>
                      @foreach($category as $categories)
		          	<option value="{{$categories->category_id}}"><span style="font-weight:bold">{{$categories->category_name}}</option>
		              @endforeach
                      
                    </select>
                    </div>
                    
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">Select Sub-Category</label>
                    <select class="form-control form-control-sm unshow" id="subcat" name="subcat_name">
                   
                    </select>
                    </div>
                    
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">Select Child Category</label>
                    <select class="form-control form-control-sm unshow" id="subchild" name="child_category_id">
                   
                    </select>
                    </div>
                    
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">City</label>
                    <select class="form-control form-control-sm" id="exampleFormControlSelect3 " name="cites">
                      @foreach($partner_city as $partner_cites)
                    <option value="{{$partner_cites->city_id}}">{{$partner_cites->city_name}}</option>
                      @endforeach
                      
                      
                    </select>
                    </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_name" value="" placeholder="Partner Name"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Phone</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_phone" value="" placeholder="Phone Number"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Email</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="partner_email" value="" placeholder="Partner_Email"></div>
                      
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Partner Password</label>
                      <input type="password" class="form-control" id="exampleInputName1" name="partner_pass" value="" placeholder="password"></div>
                      
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Range</label>
                      <input type="number" class="form-control" id="exampleInputName1" name="range" value="" placeholder="Delivery Range"></div>
                      
                      <div class="form-group">
                      <label for="autocomplete">Current Address</label>
                      <input type="text" class="form-control" id="autocomplete" name="partner_add" placeholder="Enter Address">
                      
                    </div>
                      
                      <!--<div class="form-group">-->
                      <!--<label for="exampleInputName1">Current Address</label>-->
                      <!--<input type="text" class="form-control" id="exampleInputName1" name="partner_add" value="" placeholder="Address"></div>-->
                      
                      <div class="form-group">
                      <label>Profile Picture</label>
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-circle img-raised">
                     </div>
                        <div class="w-50 fileinput-preview fileinput-exists thumbnail img-circle img-raised"></div>
                        <div>
                        <span class="btn btn-raised btn-round btn-rose btn-file">
                            <span class="fileinput-new">Add Photo</span>
                      <span class="fileinput-exists">Change</span>
                      <input type="file" name="image" /></span>
                            <br />
                            <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                    </div>
                    

    
                    
                    <div class="form-group">
                    <label for="exampleFormControlSelect3">Identity Proof</label>
                    <select class="form-control form-control-sm img" id="exampleFormControlSelect3" name="identify_proof">
                      <option>Aadhar Card</option>
                      <option>Driver's License</option>
                      <option>PAN Card</option>
                    </select>
                    </div>

                    <div class="form-group">
                    <label>Identity Picture (Front)</label>
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-circle img-raised">
                     </div>
                        <div class="w-50 fileinput-preview fileinput-exists thumbnail img-circle img-raised"></div>
                        <div>
                        <span class="btn btn-raised btn-round btn-rose btn-file">
                            <span class="fileinput-new">Add Photo</span>
                      <span class="fileinput-exists">Change</span>
                      <input type="file" name="front" /></span>
                            <br />
                            <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                    </div>

                    <div class="form-group">
                    <label>Identity Picture (Back)</label>
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-new thumbnail img-circle img-raised">
                     </div>
                        <div class="w-50 fileinput-preview fileinput-exists thumbnail img-circle img-raised"></div>
                        <div>
                        <span class="btn btn-raised btn-round btn-rose btn-file">
                            <span class="fileinput-new">Add Photo</span>
                      <span class="fileinput-exists">Change</span>
                      <input type="file" name="back" /></span>
                            <br />
                            <a href="javascript:;" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                    </div>
                    

                      <div class="form-group">
                      <label for="exampleInputName1">Voter Card Number</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="voter_card_number" value="" placeholder="Category Name"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Gender</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="gender" value="" placeholder="Category Name"></div>
                      
                       <div class="form-group">
                      <label for="exampleInputName1">Date of Birth</label>
                      <input type="date" class="form-control" id="exampleInputName1" name="d_o_b" value="" placeholder="Category Name"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Care of</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="c_o" value="" placeholder="Category Name"></div>
                      
                      <div class="form-group">
                      <label for="exampleInputName1">Permanent Address</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="permanent_add" value="" placeholder="Address"></div>
                    
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="{{route('add_partner')}}" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
             <div class="col-md-2">
		  </div>
     
          </div>
        </div>
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
        	$(document).ready(function(){
        	
          $('select[name="sub_category_id"]').on('change', function() {
        
        var sub_category_id = $(this).val();
                debugger;
                $.ajax({
                    url: "getbysubcate/"+encodeURI(sub_category_id),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                      debugger;
                      if ($.trim(data)){ 
                        var html = "<option value=''>Select Sub-Category </option>";
                        for(var i=0;i<data.length;i++){ 
                            html+="<option value="+data[i].sub_category_id+">"+data[i].sub_category_name+"</option>";
                        }
                        $("#subcat").html(html);
                        $('.unshow').show();
                      }else{   
                            alert("Subcategory not Exist");
                             $('.unshow').hide();
    
                            }
                        
                    }
                });
           
    });
     $('select[name="subcat_name"]').on('change', function() {
        
        var child_category_id = $(this).val();
                debugger;
                $.ajax({
                    url: "childcate/"+encodeURI(child_category_id),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                      debugger;
                      if ($.trim(data)){ 
                        var html = "<option value=''>Select Child Category</option>";
                        for(var i=0;i<data.length;i++){ 
                            html+="<option value="+data[i].child_category_id+">"+data[i].child_name+"</option>";
                        }
                        $("#subchild").html(html);
                        $('.unshow').show();
                      }else{   
                            alert("Subcategory not Exist");
                             $('.unshow').hide();
    
                            }
                        
                    }
                });
           
    });

        	});
</script>

 


 @endsection