
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="CKSTJV" />
    <meta name="description" content="CDCS-DC">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/CKPL-icon16.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Document title -->
    <title>CKSTJV | CDCS-DC</title>
    <!-- Stylesheets & Fonts -->
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- Bootstrap datetpicker css -->
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Body Inner -->
    <div class="body-inner">
        <!-- Page Content -->
        <section id="page-content" class="background-light">
        <div class="container">
            <div class="grid-layout grid-3-columns" data-item="grid-item" data-margin="10">
                <div class="grid-item">
                        <!--Modal Box-->
                        <div class="widget text-left border-box p-cb">
                            <h4>{{ $id }}</h4>
                            <p>{{ $contents[0] }}</p>
                            <p>วันที่ : {{ date('d-m-Y', strtotime($contents[1])) }}</p>
                            <p>{{ $subject }}</p>
                            <!--Modal trigger button-->
                            <a href="{{ $fullpath }}" class="btn btn-shadow btn-rounded btn-iconed" type="submit">View PDF</a>
                            {{-- <a href="{{ url()->previous() }}" class="btn btn-shadow btn-rounded btn-iconed" type="submit">Close</a> --}}
                            <a href="#" class="btn btn-shadow btn-rounded btn-iconed" type="submit" onclick="closeWin()">Close</a>
                            <!--End: Modal trigger button-->
                        </div>
                        <!--End: Modal Box-->
                    </div>
            </div>
        </div>
    </section>
       
    </div>
    <!-- end: Body Inner -->
    <!-- Scroll top -->
    <a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>
    <!--Plugins-->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!--Template functions-->
    <script src="{{ asset('assets/js/functions.js') }}"></script>
    <script>
        function closeWin() {
            window.close();
        }
    </script>
</body>

</html>