<!DOCTYPE html>
<html>
<head>
	<title>WordPress License Server</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{ @url('/assets/css/index.css') }}?ver={{ @config('app.version') }}">
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/fa-5.0.10-solid-min.css"> -->
</head>
<body>
	@yield('content')

	<script type="text/javascript" src="{{ @url('/assets/js/index.js') }}?ver={{ @config('app.version') }}"></script>
</body>
</html>