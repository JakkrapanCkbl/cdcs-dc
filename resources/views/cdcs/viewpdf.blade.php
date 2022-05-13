<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CKSTJV | CDCS-DC</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        {{-- <h4>id = {{ $id }}</h4>
        <h4>fullpath = {{ $fullpath }}</h4>
        <h4>{{ Auth::user()->ViewConfidential }}</h4> --}}
        
        <embed src="{{ asset($fullpath).'#zoom=100&scrollbar=1&toolbar=1&navpanes=1' }}" type="application/pdf" width="100%" height="900px" />
        
        
        {{-- @php
        {{  $isFolder = is_dir("\\\\172.18.50.10\\cdcs-ppls");
            var_dump($isFolder); //TRUE
        }}
        @endphp --}}
        {{-- <a href="{{ URL('file://///172.18.50.10/cdcs-ppls/docs/00-2022/PLS1-00-IB-BUDG-00001/PLS1-00-IB-BUDG-00001-742266341.pdf') }}" target="_blank">here</a> --}}
        {{-- <embed src="//172.18.50.10/cdcs-ppls/docs/00-2022/PLS1-00-IB-BUDG-00001/PLS1-00-IB-BUDG-00001-742266341.pdf#zoom=100&scrollbar=1&toolbar=1&navpanes=1" type="application/pdf" width="100%" height="900px" /> --}}
        {{-- storage/cdcs-ppls/docs/01-2022/PLS1-01-IM-CONT-00018/PLS1-01-IM-CONT-00018-30APR22-01.pdf --}}
        
        
    </div>
</body>
</html>