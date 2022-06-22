
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="CKSTJV" />
    <meta name="description" content="CDCS-DC">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/CKPL-icon16.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Document title -->
    <title>CKSTJV | CDCS-DC</title>
    <!-- Stylesheets & Fonts -->
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    
</head>

<body>
    <!-- Body Inner -->
    <div class="body-inner">
        <!-- Header -->
        <header id="header" data-fullwidth="true">
        {{-- <header id="header" class="header-always-fixed"> --}}
            <div class="header-inner">
                <div class="container">
                    <!--Logo-->
                    <div id="logo"> <a href="index.html"><span class="logo-default">CDCS-PLJV</span><span class="logo-dark">POLO</span></a> </div>
                    <!--End: Logo-->
                    <!-- Search -->
                    {{-- <div id="search"><a id="btn-search-close" class="btn-search-close" aria-label="Close search form"><i class="icon-x"></i></a>
                        <form class="search-form" action="search-results-page.html" method="get">
                            <input class="form-control" name="q" type="text" placeholder="Type & Search..." />
                            <span class="text-muted">Start typing & press "Enter" or "ESC" to close</span>
                        </form>
                    </div> --}}
                    <!-- end: search -->
                    <!--Header Extras-->
                    {{-- <div class="header-extras">
                        <ul>
                            <li>
                                <a id="btn-search" href="#"> <i class="icon-search"></i></a>
                            </li>
                            <li>
                                <div class="p-dropdown">
                                    <a href="#"><i class="icon-globe"></i><span>EN</span></a>
                                    <ul class="p-dropdown-content">
                                        <li><a href="#">French</a></li>
                                        <li><a href="#">Spanish</a></li>
                                        <li><a href="#">English</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div> --}}
                    <!--end: Header Extras-->
                    <!--Navigation Resposnive Trigger-->
                    <div id="mainMenu-trigger">
                        <a class="lines-button x"><span class="lines"></span></a>
                    </div>
                    <!--end: Navigation Resposnive Trigger-->
                    <!--Navigation-->
                    <div id="mainMenu">
                        <div class="container">
                            <nav>
                                <ul>
                                    <li><a href="{{ URL('/') }}">Home</a></li>
                                    @guest
                                        <li><a href="page-services.html">guest</a></li>
                                        {{-- @if (Route::has('login'))
                                            <li class="nav-item">
                                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                        @endif

                                        @if (Route::has('register'))
                                            <li>
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif --}}
                                    @else
                                        <li class="dropdown-submenu"><span class="dropdown-menu-title-only">{{ Auth::guard('cdcs')->user()->LoginName }}</span>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ route('cdcs.logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>
                                                    <form id="logout-form" action="{{ route('cdcs.logout') }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    @endguest
                                    
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!--end: Navigation-->
                </div>
            </div>
        </header>
        <!-- end: Header -->
        <!-- Page title -->
        {{-- <section id="page-title">
            <div class="container">
                <div class="page-title">
                    <h1>Forms</h1>
                    <span>Inspiration comes of working every day.</span>
                </div>
                <div class="breadcrumb">
                    <ul>
                        <li><a href="#">Home</a> </li>
                        <li><a href="#">Shortcodes</a> </li>
                        <li class="active"><a href="#">Forms</a> </li>
                    </ul>
                </div>
            </div>
        </section> --}}
        <!-- end: Page title -->
        <!-- Page Content -->
        @yield('content')
        <!-- end: Page Content -->
        <!-- Footer -->
        <footer id="footer">            
            <div class="copyright-content">
                <div class="container">
                    <div class="copyright-text text-center">&copy; 2022 CKSTJV - Purple Line Project. All Rights Reserved.<a href="#" target="_blank" rel="noopener"></a> </div>
                </div>
            </div>
        </footer>
        <!-- end: Footer -->
    </div>
    <!-- end: Body Inner -->
    <!-- Scroll top -->
    <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>
    <!--Plugins-->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!--Template functions-->
    <script src="{{ asset('assets/js/functions.js') }}"></script>
    {{-- custum functions --}}
    <script>
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
            alert(msg);
        }
    </script>
    {{-- for active tab --}}
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
    {{-- for display modal detail --}}
    <script>
        $(document).on("click", ".open-ViewTodo", function () {
        //var regid = $('#todolink').data('todo').regid;
        //var regid = $('[id^=todolink]').data('todo').regid;
        //window.alert(regid); 
        var regid = $(this).data('todo').regid;
        var crossref = $(this).data('todo').crossref;
        var subject = $(this).data('todo').subject;
        var rn = $(this).data('todo').rn;
        //window.alert(rn);
        //$(".modal-body #regid").val( "'cdcs.viewpdf', ['id' => " + regid + "]" );
        document.getElementById("mbdRegID").innerHTML = "<a href='" + rn + "' target='_blank'>" + regid + "</a>";
        document.getElementById("mbdCrossRef").innerHTML = "Sender Ref : " + crossref;
        document.getElementById("mbdSubject").innerHTML = "Subject : " + subject;
        });
    </script>
    <script>
        $(document).on("click", ".open-ViewTodoOut", function () {
        var regid = $(this).data('todo').regidout;
        var subject = $(this).data('todo').subjectout;
        var rn = $(this).data('todo').rnout;
        document.getElementById("mbdRegID_Out").innerHTML = "<a href='" + rn + "' target='_blank'>" + regid + "</a>";
        document.getElementById("mbdSubject_Out").innerHTML = "Subject : " + subject;
        });
    </script>
</body>

</html>