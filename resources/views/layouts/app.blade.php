<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title', 'BookingYard')</title>
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/icon.ico.jpg') }}">
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
	@include('partials.header')
	@include('partials.sidebar')

	<main style="padding-top:10px">
		@yield('content')
	</main>

	@include('partials.footer-mobile')

	<script src="{{ asset('js/script.js') }}"></script>
	<script src="{{ asset('js/script1.js') }}"></script>
</body>
</html>
