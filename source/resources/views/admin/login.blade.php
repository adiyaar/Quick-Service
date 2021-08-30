<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin: Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{url('vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{url('vendors/iconfonts/flag-icon-css/css/flag-icon.min.css')}}">
  <link rel="stylesheet" href="{{url('vendors/iconfonts/simple-line-icon/css/simple-line-icons.css')}}">
  <link rel="stylesheet" href="{{url('vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{url('vendors/css/vendor.bundle.addons.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{url('css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{url($logo->value)}}" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{asset('/login/fonts/icomoon/style.css')}}">
<link rel="stylesheet" href="{{asset('/login/css/owl.carousel.min.css')}}">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{asset('/login/css/bootstrap.min.css')}}">
<!-- Style -->
<link rel="stylesheet" href="{{asset('/login/css/style.css')}}">
<link rel="stylesheet" href="{{url('vendors/login/fonts/icomoon/style.css')}}">
<link rel="stylesheet" href="{{url('vendors/login/css/owl.carousel.min.css')}}">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{url('vendors/login/css/bootstrap.min.css')}}">
<!-- Style -->
<link rel="stylesheet" href="{{url('vendors/login/css/style.css')}}">

</head>

<body>
<div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="{{asset('images/undraw_remotely_2j6y.svg')}}" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
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
          <div class="row justify-content-center">
 
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Welcome to Quick Service</h3>
              <p class="mb-4">Quick Service App is Complete Solution for Your Bussiness. Please Buy this Script form Codecanyon.</p>
            </div>
            <form action="{{route('adminLoginCheck')}}" method="post" autocomplete="off">
                {{csrf_field()}}
              <div class="form-group first">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">

              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
              </div>

              <input type="submit" value="Log In" class="btn btn-block btn-primary">

              
             
            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  <!-- container-scroller -->
  <!-- plugins:js -->

  <script src="{{asset('login/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('login/js/popper.min.js')}}"></script>
    <script src="{{asset('login/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('login/js/main.js')}}"></script>


    <script src="{{url('vendors/login/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{url('vendors/login/js/popper.min.js')}}"></script>
    <script src="{{url('vendors/login/js/bootstrap.min.js')}}"></script>
    <script src="{{url('vendors/login/js/main.js')}}"></script>

  <!-- endinject -->
</body>

</html>