const fs = require('fs');
let c = fs.readFileSync('resources/views/user/bookings.blade.php', 'utf8');

c = c.replace(/<x-app-layout>/, `<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - BookingYard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    @include('partials.header')
    @include('partials.sidebar')
    <div class="mt-20"></div>`);

c = c.replace(/<\/x-app-layout>/, `    @include('partials.footer-mobile')
    @include('partials.footer-modern')
</body>
</html>`);

fs.writeFileSync('resources/views/user/bookings.blade.php', c);
console.log('Fixed my-bookings view layout');