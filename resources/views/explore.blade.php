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
        :root {
            --primary-color: #046c9f;
            --primary-hover: #035680;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f3f4f6;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .explore-hero {
            background: #046c9f;
            color: #fff;
            padding: 80px 20px 60px;
            text-align: center;
            margin-top: 30px; /* Header height offset */
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        .explore-hero h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .explore-hero p {
            font-size: 1.125rem;
            color: #d1d5db;
            max-width: 600px;
            margin: 0 auto;
        }

        .explore-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .explore-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            padding: 4rem 1rem 1rem 1rem;
            margin-top: -40px;
        }

        .explore-card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }

        .explore-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .explore-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-color);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: left;
        }

        .explore-card:hover::before {
            transform: scaleX(1);
        }

        .icon-wrapper {
            width: 60px;
            height: 60px;
            background: #e0f2fe;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .icon-wrapper i {
            font-size: 1.75rem;
            color: var(--primary-color);
        }

        .explore-card h3 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .explore-card p {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .card-link {
            color: var(--primary-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.2s ease;
        }

        .explore-card:hover .card-link {
            gap: 12px;
        }
        
        @media (max-width: 768px) {
            .explore-hero {
                padding: 60px 20px 40px;
            }
            .explore-hero h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

  @include('partials.header')

  @include('partials.sidebar')

    <main>
        <section class="explore-hero" id="home">
            <div class="explore-container">
                <h2>Your Own Space</h2>
                <p>Choose a feature to continue — Rent Houses or Expense Management.</p>
            </div>
        </section>

        <div class="explore-container">
            <div class="explore-grid">
                <a href="/rent-houses" class="explore-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="card-content">
                        <h3>Your Space</h3>
                        <p>Search and list rental properties, view details, and List directly.</p>
                        <span class="card-link">Go to Rent Houses <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>

                <a href="/expense-management" class="explore-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="card-content">
                        <h3>Your Expense</h3>
                        <p>Track, categorize and manage your bookings' expenses in one place.</p>
                        <span class="card-link">Open Expense Management <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>

                <a href="/vendor" class="explore-card">
                    <div class="icon-wrapper">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="card-content">
                        <h3>Become Vendor</h3>
                        <p>Join as a vendor to list your services, manage bookings, and grow your business.</p>
                        <span class="card-link">Get Started <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </main>

  @include('partials.footer-mobile')

  <script src="js/script.js"></script>
  <script src="js/script1.js"></script>
</body>
</html>
