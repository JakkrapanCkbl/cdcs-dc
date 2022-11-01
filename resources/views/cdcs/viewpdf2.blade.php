<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CKSTJV | CDCS-DC</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
     <div class="container">
        {{asset($fullpath);}}
       <object width="100%" height="900px" type="application/pdf" data="{{asset($fullpath);}}?#zoom=100&scrollbar=1&toolbar=1&navpanes=1">
    </div>
</body>
</html>