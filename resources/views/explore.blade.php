<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/icon.ico.jpg') }}">
    <meta name="Description" content="Book your day to day on door services with BookingYard . It is Indian on door service platform that have thousands of happy Customer.">
    <meta name="keywords" content="Bookingyard, BookingYard, booking.com, booking, bookmyshow, booking yard, founder of bookingyard, bookingyard company, skynet bookingyards, skynet, skynet company, bookingyards company">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore — BookingYard</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

    <style>
        .cards{display:flex;gap:16px;max-width:900px;margin:24px auto;flex-wrap:wrap;justify-content:center}
        .card{background:#fff;border-radius:8px;box-shadow:0 6px 18px rgba(20,20,30,0.06);flex:1 1 280px;min-width:260px;padding:28px;text-align:left}
        .card h3{margin:0 0 10px}
        .card p{color:#6b7280;margin:0 0 18px}
        .card a{display:inline-block;padding:10px 14px;background:#046c9f;color:#fff;border-radius:6px;text-decoration:none}
    </style>
</head>
<body>

  @include('partials.header')

  @include('partials.sidebar')

    <main>
        <section class="hero" id="home">
            <div class="container">
                <h1>Explore BookingYard</h1>
                <p>Choose a feature to continue — Rent Houses or Expense Management.</p>
            </div>
        </section>

        <div class="container" style="padding:24px 16px">
            <div class="cards">
        <section class="card">
            <h3>Rent Houses</h3>
            <p>Search and list rental properties, view details, and book directly.</p>
            <a href="/rent-houses">Go to Rent Houses</a>
        </section>

        <section class="card">
            <h3>Expense Management</h3>
            <p>Track, categorize and manage your bookings' expenses in one place.</p>
            <a href="/expense-management">Open Expense Management</a>
        </section>
            </div>
        </div>
    </main>

  @include('partials.footer-mobile')

  <script src="js/script.js"></script>
  <script src="js/script1.js"></script>
</body>
</html>
