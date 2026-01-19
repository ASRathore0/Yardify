<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>1X1 — Quick Links</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    @include('partials.header')

  @include('partials.sidebar')

    <section class="hero" id="home">
        <div class="container">
            <h2>Book Anything, Anytime Seamlessly</h2>
            <p>Welcome to 1X1</p>
            <p>"One User! One I'd"</p>
        </div>
    </section>

    <section class="service-section">
      <!-- Quick Commerce -->
      <div class="category">
        <div class="category-header">
          <h2>Quick Commerce</h2>
          <button class="view-all" onclick="viewAll('quick-commerce')">View All &rarr;</button>
        </div>
        <div class="icon-row">
          <a href="https://www.zepto.com" class="service-icon" target="_blank">
            <img src="/image/zepto.jpeg" alt="Zepto">
            <span>Zepto</span>
          </a>
          <a href="https://www.blinkit.com" class="service-icon" target="_blank">
            <img src="/image/blinkit1.jpg" alt="Blinkit">
            <span>Blinkit</span>
          </a>
          <a href="https://www.bigbasket.com" class="service-icon" target="_blank">
            <img src="/image/bigbasket.png" alt="BigBasket">
            <span>BigBasket</span>
          </a>
        </div>
      </div>

      <!-- Food Sites -->
      <div class="category">
        <div class="category-header">
          <h2>Food Sites</h2>
          <button class="view-all" onclick="viewAll('food-sites')">View All &rarr;</button>
        </div>
        <div class="icon-row">
          <a href="https://www.zomato.com" class="service-icon" target="_blank">
            <img src="/image/zomato1.avif" alt="Zomato">
            <span>Zomato</span>
          </a>
          <a href="https://www.swiggy.com" class="service-icon" target="_blank">
            <img src="/image/swigy.png" alt="Swiggy">
            <span>Swiggy</span>
          </a>
          <a href="https://www.foodpanda.com" class="service-icon" target="_blank">
            <img src="/image/foodpanda.jpeg" alt="Foodpanda">
            <span>Foodpanda</span>
          </a>
        </div>
      </div>

      <!-- Cab Services -->
      <div class="category">
        <div class="category-header">
          <h2>Cab Services</h2>
          <button class="view-all" onclick="viewAll('cab-services')">View All &rarr;</button>
        </div>
        <div class="icon-row">
          <a href="https://www.ola.com" class="service-icon" target="_blank">
            <img src="/image/ola.webp" alt="OLA">
            <span>OLA</span>
          </a>
          <a href="https://www.uber.com" class="service-icon" target="_blank">
            <img src="/image/uber.jpeg" alt="Uber">
            <span>Uber</span>
          </a>
          <a href="https://www.indrive.com" class="service-icon" target="_blank">
            <img src="/image/indrive.jpeg" alt="Indrive">
            <span>Indrive</span>
          </a>
        </div>
      </div>

      <!-- Traveling -->
      <div class="category">
        <div class="category-header">
          <h2>Traveling</h2>
          <button class="view-all" onclick="viewAll('traveling')">View All &rarr;</button>
        </div>
        <div class="icon-row">
          <a href="https://www.oyorooms.com" class="service-icon" target="_blank">
            <img src="/image/oyo1.png" alt="OYO">
            <span>OYO</span>
          </a>
          <a href="https://www.booking.com" class="service-icon" target="_blank">
            <img src="/image/booking1.png" alt="Booking">
            <span>Booking</span>
          </a>
          <a href="https://www.makemytrip.com" class="service-icon" target="_blank">
            <img src="/image/makemytrip.png" alt="BookingYard">
            <span>MakeMyTrip</span>
          </a>
        </div>
      </div>
    </section>

    <script src="/assets/script.js"></script>
    <script src="/assets/script1.js"></script>
    <script>
      function viewAll(category) {
        // placeholder behaviour: scroll to top and alert category
        window.scrollTo({top:0, behavior:'smooth'});
      }
    </script>

     @include('partials.footer-mobile')
     @include('partials.footer-modern')

  <script src="js/script.js"></script>
  <script src="js/script1.js"></script>
  </body>
</html>
