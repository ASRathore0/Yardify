<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookingYard — Expense Management</title>
    <style>
        /* Prevent UI flicker/double-render while Vite starts */
        html { visibility: hidden; opacity: 0; }
    </style>
    <noscript><style>html { visibility: visible; opacity: 1; }</style></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Fallback to reveal UI after 300ms in case local Vite server is delayed
        setTimeout(() => { document.documentElement.style.visibility = 'visible'; document.documentElement.style.opacity = '1'; }, 300);
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/stylee.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <main>
        @yield('content')
    </main>
</body>
</html>
