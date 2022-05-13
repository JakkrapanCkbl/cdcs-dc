<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>IT HOME</title>
</head>
<body>
	<h4>IT HOME</h4>
	<h4>Welcome {{ Auth::guard('it')->user()->LoginName }}</h4>
	<a href="{{ route('it.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
	<form action="{{ route('it.logout') }}" id="logout-form" method="post">@csrf</form>
	
</iframe>
</body>
</html>