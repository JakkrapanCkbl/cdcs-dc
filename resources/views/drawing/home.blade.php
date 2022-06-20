<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Drawing HOME</title>
</head>
<body>
	<h4>Drawing HOME</h4>
	<h4>Welcome {{ Auth::guard('drawing')->user()->LoginName }}</h4>
	<a href="{{ route('drawing.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
	<form action="{{ route('drawing.logout') }}" id="logout-form" method="post">@csrf</form>
	
</iframe>
</body>
</html>