
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="INSPIRO" />
    <meta name="description" content="Themeforest Template Polo, html template">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Document title -->
    <title>CDCS-DC</title>
    <!-- Stylesheets & Fonts -->
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    
</head>

<body>
    <!-- Body Inner -->
    <div class="body-inner">
        <!-- Section -->
        {{-- <section class="pt-5 pb-5" data-bg-image="{{ asset('images/pages/1.jpg') }}"> --}}
        <section class="pt-5 pb-5" data-bg-image="{{ asset('images/slider/pexels-annam-w-1057858.jpg') }}">
            <div class="container-fluid d-flex flex-column">
                <div class="row align-items-center min-vh-100">
                    <div class="col-md-6 col-lg-4 col-xl-3 mx-auto">
                          <div class="card">
                            <div class="card-body py-5 px-sm-5">
                                
                                <div class="mb-5 text-center">
                                    <h6 class="h3 mb-1">Login</h6>
                                    <p class="text-muted mb-0">Sign in to your account to continue.</p>
                                </div><span class="clearfix"></span>
                                <form class="form-validate" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="loginname">Login Name</label>
                                        <div class="input-group">
                                        <input type="text" class="form-control" name="loginname" placeholder="Enter your loginname" required="">
                                        <span class="input-group-text"><i class="icon-user"></i></span>
                                    </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="password">Password</label>
                                        <div class="input-group show-hide-password">
                                            <input class="form-control" name="password" placeholder="Enter password" type="password" required="">
                                            <span class="input-group-text"><i class="icon-eye-off" aria-hidden="true" style="cursor: pointer;"></i></span>
                                        </div>
                                    </div>
                                    <div class="mt-4"><button type="submit" class="btn btn-primary btn-block btn-primary">Sign in</button></div>
                                </form>
                                {{-- <div class="mt-4 text-center"><small>Not registered?</small> <a href="{{ url('/') }}" class="small fw-bold">Create account</a> --}}
                                <div class="mt-4 text-center"><small>Back to</small> <a href="{{ url('/') }}" class="small fw-bold">Home Page</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end: Section -->
    </div>
    <!-- end: Body Inner -->
    <!-- Scroll top -->
    <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>
    <!--Plugins-->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!--Template functions-->
    <script src="{{ asset('assets/js/functions.js') }}"></script>
</body>

</html>