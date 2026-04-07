<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/icon.ico.jpg') }}">
        <meta name="Description" content="Book your day to day on door services with BookingYard . It is Indian on door service plateform that have thousands of happy Customer.">
        <meta name="keywords" content="Bookingyard, BookingYard, booking.com, booking, bookmyshow, booking yard, founder of bookingyard, bookingyard company, skynet bookingyards, skynet, skynet company, bookingyards company">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BookingYard</title>
         
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
         
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        rel="stylesheet"
    />
    </head>
<body>
   
  @include('partials.header')

  <!-- Sidebar Menu -->
  @include('partials.sidebar')
  

  <!-- Notice Board Modal -->
<!-- <div id="notice-board" class="modal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeNoticeBoard()">&times;</span>
      <h2>Thank You!</h2>
      <p>Thank you for showing your interest. The app is about to launch soon. Stay tuned!</p>
    </div>
  </div> -->

  <!-- Pop-up Message Structure -->
<!-- <div id="popupMessage" class="popup hidden">
  <div class="popup-content">
    <p>We apologize for any inconvenience caused. We are working to improve your experience on BookingYard.</p>
    <button onclick="closePopup()">Close</button>
  </div>
</div> -->

<script>
  // Show the pop-up message after 5 seconds
  setTimeout(() => {
    const popupMessage = document.getElementById('popupMessage');
    if (popupMessage) {
        popupMessage.classList.remove('hidden');
    }
  }, 5000);

  // Function to close the pop-up
  function closePopup() {
    const popupMessage = document.getElementById('popupMessage');
    if (popupMessage) {
        popupMessage.classList.add('hidden');
    }
  }
</script>
 

<style>
  /* Modern Dashboard Revamp CSS */
  body {
      background-color: #f7f9fc;
  }
  .modern-header {
      background: linear-gradient(135deg, #046c9f 0%, #034d71 100%);
      padding: 30px 20px 45px;
      color: #fff;
      position: relative;
      /* margin-top: 10px; If there's a fixed top navbar */
      /* -webkit-mask-image: linear-gradient(to bottom, black 70%, transparent 50%); */
      /* mask-image: linear-gradient(to bottom, black 70%, transparent 100%); */
  }
  .modern-header h2 {
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0;
  }
  .modern-header p {
      font-size: 1rem;
      opacity: 0.9;
      margin: 5px 0 20px;
  }
  
  .modern-search-container {
      margin: -25px 20px 20px;
      position: relative;
      z-index: 10;
  }
  .modern-search-bar {
      display: flex;
      align-items: center;
      background: #fff;
      border-radius: 16px;
      padding: 8px 16px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  }
  .modern-search-bar input {
      border: none;
      outline: none;
      width: 100%;
      padding: 10px;
      font-size: 0.95rem;
  }
  .modern-search-bar .geo-btn {
      color: #046c9f;
      padding: 8px;
      border-radius: 50%;
      cursor: pointer;
      background: #eef9ff;
  }
  
  .section-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #1e293b;
      margin: 20px 20px 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
  }
  .section-title a {
      font-size: 0.85rem;
      color: #046c9f;
      text-decoration: none;
      font-weight: 600;
  }
  
  /* Round Icons Categories */
  .round-categories {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      padding: 0 20px ;
      gap: 20px 10px;
  }
  
  .round-category-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      border: none;
      background: none;
      padding: 0;
      width: 100%;
  }
  .round-category-icon {
      width: 55px;
      height: 55px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      transition: all 0.2s ease;
  }
  /* Remove the active border box to just show icon */
  .round-category-item:hover .round-category-icon {
      transform: scale(1.05);
  }
  .round-category-text {
      font-size: 0.75rem;
      font-weight: 500;
      color: #64748b;
      text-align: center;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 70px;
  }
  
  /* Popular Services Horizontal List */
  .popular-services {
      display: flex;
      overflow-x: auto;
      padding: 0 20px 10px;
      gap: 15px;
      scrollbar-width: none;
  }
  .popular-services::-webkit-scrollbar { display: none; }
  
  .popular-card {
      min-width: 110px;
      /* background: #ffffff;
      border: 1px solid #e2e8f0; */
      border-radius: 16px;
      padding: 20px 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      transition: transform 0.2s;
      box-shadow: 0 4px 10px rgba(0,0,0,0.02);
  }
  .popular-card:hover {
      transform: translateY(-2px);
  }
  .popular-card img {
      width: 45px;
      height: 45px;
      object-fit: contain;
  }
  .popular-card span {
      font-size: 0.85rem;
      font-weight: 600;
      color: #1e293b;
      text-align: center;
      line-height: 1.2;
  }
  
  /* Promo Banner */
  .promo-banner {
      margin: 25px 20px;
      background: linear-gradient(45deg, #046c9f, #ff8e53);
      border-radius: 20px;
      padding: 20px;
      color: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 15px rgba(255,107,107,0.3);
  }
  .promo-content h3 {
      font-size: 1.2rem;
      margin: 0 0 5px;
      font-weight: 800;
  }
  .promo-content p {
      font-size: 0.85rem;
      margin: 0;
      opacity: 0.9;
  }
  .promo-btn {
      background: #fff;
      color: #046c9f;
      border: none;
      padding: 8px 16px;
      border-radius: 20px;
      font-weight: 700;
      font-size: 0.8rem;
      cursor: pointer;
  }

  /* Why Choose Us Modern */
  .modern-why-section {
      padding: 0 20px 0;
  }
  .modern-features-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
  }
  .modern-feature-card {
      background: #fff;
      border-radius: 16px;
      padding: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
      border: 1px solid #f1f5f9;
  }
  .modern-feature-card .icon {
      background: #eef9ff;
      color: #046c9f;
      width: 40px;
      height: 40px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
  }
  .modern-feature-card h3 {
      font-size: 0.85rem;
      font-weight: 700;
      margin: 0;
      color: #1e293b;
      line-height: 1.3;
  }
  .modern-feature-card p {
      font-size: 0.75rem;
      color: #64748b;
      margin: 0;
      line-height: 1.4;
  }

  /* Quality Assured Banner */
  .modern-quality-banner {
      margin: 25px 20px;
      background: linear-gradient(135deg, #046c9f 0%, #5eaccd 100%);
      border-radius: 20px;
      padding: 20px;
      color: #fff;
      display: flex;
      align-items: center;
      gap: 15px;
      box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
  }
  .modern-quality-icon {
      background: rgba(255,255,255,0.2);
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
  }
  .modern-quality-text h3 {
      margin: 0 0 5px;
      font-size: 1.1rem;
      font-weight: 800;
  }
  .modern-quality-text p {
      margin: 0;
      font-size: 0.8rem;
      opacity: 0.9;
  }

  /* Testimonials */
  .modern-testimonials {
      padding: 0 20px 30px;
      display: flex;
      overflow-x: auto;
      gap: 15px;
      scrollbar-width: none;
  }
  .modern-testimonials::-webkit-scrollbar { display: none; }
  .modern-testimonial-card {
      min-width: 280px;
      background: #fff;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.03);
      border: 1px solid #f1f5f9;
  }
  .modern-testimonial-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 12px;
  }
  .modern-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      background: #eef9ff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: #046c9f;
      font-size: 1.1rem;
  }
  .modern-user-info h4 {
      margin: 0;
      font-size: 0.9rem;
      color: #1e293b;
      font-weight: 700;
  }
  .modern-stars {
      color: #fbbf24;
      font-size: 0.75rem;
      margin-top: 4px;
  }
  .modern-quote {
      font-size: 0.85rem;
      color: #475569;
      margin: 0;
      line-height: 1.6;
      font-style: italic;
  }

  /* Top Services Card Style (Demo) */
  .top-services-list {
      display: flex;
      overflow-x: auto;
      padding: 0 20px 20px;
      gap: 15px;
      scrollbar-width: none;
  }
  .top-services-list::-webkit-scrollbar { display: none; }
  
  .top-service-card {
      min-width: 260px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.06);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      position: relative;
      border: 1px solid #f1f5f9;
  }
  .top-service-image {
      width: 100%;
      height: 150px;
      position: relative;
  }
  .top-service-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
  }
  .discount-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: #ef4444;
      color: #fff;
      padding: 4px 8px;
      border-radius: 6px;
      font-size: 0.7rem;
      font-weight: 800;
      letter-spacing: 0.5px;
      text-transform: uppercase;
  }
  .top-service-body {
      padding: 15px;
  }
  .top-service-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 5px;
  }
  .top-service-title {
      font-size: 1.05rem;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
  }
  .top-service-price {
      font-size: 1rem;
      font-weight: 700;
      color: #046c9f;
      margin: 0;
  }
  .top-service-subtitle {
      font-size: 0.8rem;
      color: #64748b;
      margin: 0 0 10px;
  }
  .top-service-rating-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 12px;
  }
  .rating-badge {
      background-color: #f0fdf4;
      color: #16a34a;
      padding: 3px 6px;
      border-radius: 4px;
      font-size: 0.75rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 3px;
  }
  .review-count {
      font-size: 0.8rem;
      color: #64748b;
  }
  .top-service-footer {
      border-top: 1px dashed #e2e8f0;
      padding-top: 12px;
      display: flex;
      align-items: flex-start;
      gap: 8px;
      font-size: 0.8rem;
      color: #64748b;
      line-height: 1.4;
  }
  .top-service-footer i {
      color: #046c9f;
      margin-top: 2px;
  }
  
  /* Auto-playing Ad Slider Styles */
  .ad-slider-container {
      position: relative;
      overflow: hidden;
      margin: 0 20px 20px;
      border-radius: 16px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      height: 180px;
  }
  .ad-slider {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
  }
  .ad-slide {
      min-width: 100%;
      height: 100%;
      position: relative;
      background-color: #f1f5f9;
      display: flex;
      align-items: center;
      justify-content: center;
  }
  .ad-slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
  }
  /* Refined Gradients */
  .ad-slide.bg-1 { background: linear-gradient(135deg, #0e7490 0%, #38bdf8 100%); }
  .ad-slide.bg-2 { background: linear-gradient(135deg, #ea580c 0%, #fbbf24 100%); }
  .ad-slide.bg-3 { background: linear-gradient(135deg, #047857 0%, #34d399 100%); }
  
  .ad-slide-content {
      position: absolute;
      left: 24px;
      top: 50%;
      transform: translateY(-50%);
      color: #fff;
      max-width: 70%;
      text-shadow: 0 2px 5px rgba(0,0,0,0.15);
  }
  .ad-slide-content h3 {
      font-size: 1.55rem;
      line-height: 1.2;
      margin: 0 0 6px;
      font-weight: 900;
      letter-spacing: -0.5px;
  }
  .ad-slide-content p {
      margin: 0 0 14px;
      font-size: 0.95rem;
      opacity: 0.95;
      font-weight: 500;
  }
  .ad-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: #fff;
      padding: 6px 16px;
      border-radius: 999px;
      font-size: 0.75rem;
      font-weight: 800;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      transition: transform 0.2s, box-shadow 0.2s;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      text-shadow: none;
  }
  .ad-btn:active {
      transform: scale(0.95);
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }
  .ad-indicators {
      position: absolute;
      bottom: 12px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 6px;
      background: rgba(0,0,0,0.2);
      padding: 4px 8px;
      border-radius: 12px;
      backdrop-filter: blur(4px);
  }
  .ad-indicators .dot {
      width: 6px;
      height: 6px;
      background: rgba(255,255,255,0.5);
      border-radius: 50%;
      transition: 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  }
  .ad-indicators .dot.active {
      background: rgba(255,255,255,1);
      width: 18px;
      border-radius: 4px;
  }
</style>

<section class="modern-header" id="home">
  <h2>Hey, {{ Auth::check() ? Auth::user()->name : 'Guest' }} 👋</h2>
  <p>Find services, buy & sell items, or rent what you need!</p>
</section>

<div class="modern-search-container">
  <div class="modern-search-bar">
    <i class="fas fa-search" style="color: #94a3b8; padding: 0 10px;"></i>
    <input type="text" id="searchInput" value="{{ auth()->check() && auth()->user()->city ? auth()->user()->city : session('user_location', '') }}"
      placeholder="Search for services or your city..."
      class="search-input"
      onclick="window.location.href='{{ route('explore') }}?focus=search'"
    />
    <span class="geo-btn" onclick="getCurrentLocation()"><i class="fas fa-map-marker-alt"></i></span>
  </div>

  <div id="cityPopup" class="city-popup hidden" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 100; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); margin-top: 10px;">
    <div class="popup-header" style="padding: 15px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
      <p style="margin: 0; font-size: 0.9rem; font-weight: 600;">Currently serving cities:</p>
      <button id="closePopup" class="close-popup" onclick="toggleCityPopup()" style="background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer;">&times;</button>
    </div>
    <div class="city-list" id="cityList" style="max-height: 250px; overflow-y: auto; padding: 10px;">
    </div>
  </div>
</div>

<!-- Professional Ad Slider (Amazon/Flipkart Style) -->
<div class="ad-slider-container" id="adSliderContainer">
    <div class="ad-slider" id="adSlider">
        @foreach($banners as $index => $banner)
        @php
            $btnColorMap = [
                'text-blue-600' => '#046c9f',
                'text-orange-600' => '#ea580c',
                'text-emerald-600' => '#059669',
            ];
            $btnColor = $btnColorMap[$banner['color'] ?? ''] ?? '#0284c7';
        @endphp
        <!-- Slide {{ $index + 1 }} -->
        <div class="ad-slide {{ empty($banner['image']) ? ($banner['bg'] ?? 'bg-1') : '' }}">
            
            @if(!empty($banner['image']))
                <img src="{{ asset('storage/' . $banner['image']) }}" alt="{{ $banner['title'] ?? 'Ad Banner' }}" style="position: absolute; top:0; left:0; width: 100%; height: 100%; object-fit: cover; z-index: 1; border-radius: 16px;">
                <!-- Subtle dark overlay to make text readable -->
                <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.1) 80%, transparent 100%); z-index: 2; border-radius:16px;"></div>
            @endif

            <div class="ad-slide-content" style="z-index: 3;">
                <h3>{{ $banner['title'] ?? '' }}</h3>
                <p>{{ $banner['subtitle'] ?? '' }}</p>
                <div class="ad-btn" style="color: {{ $btnColor }};" onclick="window.location.href='{{ url($banner['link'] ?? '#') }}'">
                    {{ $banner['btn_text'] ?? 'Explore' }} <i class="fas fa-chevron-right" style="margin-left: 6px; font-size: 0.6rem;"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="ad-indicators" id="adIndicators">
        @foreach($banners as $index => $banner)
            <span class="dot {{ $index === 0 ? 'active' : '' }}"></span>
        @endforeach
    </div>
</div>

<!-- Hero Actions -->
<div style="display:flex; justify-content: space-between; padding: 0 20px 20px; gap: 12px;">
    <button onclick="window.location.href='{{ route('explore') }}'" style="flex:1; background: #e0f7fa; color: #00838f; border:none; padding:16px 10px; border-radius:16px; font-weight:800; display:flex; flex-direction:column; align-items:center; gap:10px; cursor:pointer; box-shadow:0 4px 10px rgba(0,131,143,0.1); transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
        <div style="background:#fff; width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.05);"><i class="fas fa-tools" style="font-size:1.3rem;"></i></div>
        <span style="font-size:0.8rem; line-height:1.2;">Book<br>Services</span>
    </button>
    <button onclick="window.location.href='{{ route('one_x_one') }}'" style="flex:1; background: #e8f5e9; color: #2e7d32; border:none; padding:16px 10px; border-radius:16px; font-weight:800; display:flex; flex-direction:column; align-items:center; gap:10px; cursor:pointer; box-shadow:0 4px 10px rgba(46,125,50,0.1); transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
        <div style="background:#fff; width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.05);"><i class="fas fa-shopping-bag" style="font-size:1.3rem;"></i></div>
        <span style="font-size:0.8rem; line-height:1.2;">Buy &<br>Sell</span>
    </button>
    <button onclick="window.location.href='{{ route('one_x_one') }}?category=rent'" style="flex:1; background: #fff3e0; color: #e65100; border:none; padding:16px 10px; border-radius:16px; font-weight:800; display:flex; flex-direction:column; align-items:center; gap:10px; cursor:pointer; box-shadow:0 4px 10px rgba(230,81,0,0.1); transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
        <div style="background:#fff; width:45px; height:45px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,0.05);"><i class="fas fa-key" style="font-size:1.3rem;"></i></div>
        <span style="font-size:0.8rem; line-height:1.2;">Rent<br>Things</span>
    </button>
</div>

<div class="section-title">
  <span>Categories</span>
  <a href="{{ route('explore') }}">See All</a>
</div>

<div class="round-categories">
  <!-- Row 1 -->
  <button class="round-category-item" onclick="window.location.href='{{ route('explore') }}?category=homes'">
    <div class="round-category-icon" style="background-color: #e8f0fe; color: #1a73e8;"><i class="fas fa-home"></i></div>
    <div class="round-category-text">Home Ser...</div>
  </button>
  <button class="round-category-item" onclick="window.location.href='{{ route('explore') }}?category=cabs'">
    <div class="round-category-icon" style="background-color: #e6f4ea; color: #34a853;"><i class="fas fa-car"></i></div>
    <div class="round-category-text">Cabs</div>
  </button>
  <button class="round-category-item" onclick="window.location.href='{{ route('explore') }}?category=event'">
    <div class="round-category-icon" style="background-color: #f3e8fc; color: #9c27b0;"><i class="far fa-calendar-alt"></i></div>
    <div class="round-category-text">Events</div>
  </button>
  <button class="round-category-item" onclick="window.location.href='{{ route('explore') }}?category=Rental'">
    <div class="round-category-icon" style="background-color: #fef0e6; color: #ff9800;"><i class="fas fa-bed"></i></div>
    <div class="round-category-text">Hotels</div>
  </button>

  <!-- Row 2 -->
  <button class="round-category-item" onclick="window.location.href='{{ route('explore') }}?category=Rental'">
    <div class="round-category-icon" style="background-color: #fce8e6; color: #e53935;"><i class="fas fa-building"></i></div>
    <div class="round-category-text">Rentals</div>
  </button>
  <button class="round-category-item" onclick="window.location.href='{{ route('explore') }}?category=Working'">
    <div class="round-category-icon" style="background-color: #e0f7fa; color: #00bcd4;"><i class="fas fa-user-cog"></i></div>
    <div class="round-category-text">Professio...</div>
  </button>
  <button class="round-category-item" onclick="window.location.href='{{ route('explore') }}?category=Working'">
    <div class="round-category-icon" style="background-color: #fce4ec; color: #e91e63;"><i class="fas fa-spa"></i></div>
    <div class="round-category-text">Beauty</div>
  </button>
  <button class="round-category-item" onclick="window.location.href='{{ route('explore') }}?category=event'">
    <div class="round-category-icon" style="background-color: #fff3e0; color: #ff5722;"><i class="fas fa-utensils"></i></div>
    <div class="round-category-text">Catering</div>
  </button>
</div>

<div class="section-title">
  <span>Popular Sub Categories</span>
</div>

<div class="popular-services">
  @if(isset($categories) && count($categories) > 0)
    @foreach($categories as $category)
      <div class="popular-card service-box" data-target="{{ $category['link'] ?? '' }}">
        <img src="{{ Str::startsWith($category['image'] ?? '', 'image/') ? asset($category['image']) : asset('storage/' . ($category['image'] ?? '')) }}" alt="{{ $category['title'] ?? '' }}">
        <span>{{ $category['title'] ?? '' }}</span>
      </div>
    @endforeach
  @else
    <!-- Fallback if missing -->
    <div class="popular-card service-box" data-target="Plumber">
      <img src="{{ asset('image/plumber.png') }}" alt="Plumber">
      <span>Plumber</span>
    </div>
  @endif
</div>

<div class="promo-banner">
  <div class="promo-content">
    <h3>20% OFF</h3>
    <p>On your first booking</p>
  </div>
  <button class="promo-btn" onclick="window.location.href='{{ route('explore') }}'">Book Now</button>
</div>


<div class="section-title">
  <span>Most Booked Services</span>
</div>

<!-- Top Services Demo Cards -->
<div class="top-services-list">
  @if(isset($services) && count($services) > 0)
    @foreach($services as $service)
      <div class="top-service-card" onclick="window.location.href='{{ url($service['link'] ?? '#') }}'" style="cursor:pointer;">
        <div class="top-service-image">
          @if(!empty($service['badge']))
            <span class="discount-badge">{{ $service['badge'] }}</span>
          @endif
          <img src="{{ Str::startsWith($service['image'] ?? '', 'image/') ? asset($service['image']) : asset('storage/' . ($service['image'] ?? '')) }}" alt="{{ $service['title'] ?? '' }}">
        </div>
        <div class="top-service-body">
          <div class="top-service-header">
            <h4 class="top-service-title">{{ $service['title'] ?? '' }}</h4>
            <p class="top-service-price">{{ $service['price'] ?? '' }}</p>
          </div>
          <p class="top-service-subtitle">{{ $service['subtitle'] ?? '' }}</p>
          <div class="top-service-rating-row">
            <span class="rating-badge">{{ $service['rating'] ?? '0.0' }} <i class="fas fa-star"></i></span>
            <span class="review-count">• {{ $service['reviews'] ?? '0 Reviews' }}</span>
          </div>
          <div class="top-service-footer">
            <i class="fas fa-map-marker-alt"></i>
            <span>{{ $service['footer'] ?? '' }}</span>
          </div>
        </div>
      </div>
    @endforeach
  @else
    <p style="padding: 20px; color: #64748b; font-size: 0.9rem;">No services listed yet.</p>
  @endif
</div>
  
<div class="section-title" style="margin-top: 30px;">
  <span>Why BookingYard?</span>
</div>

<section class="modern-why-section">
  <div class="modern-features-grid">
    <div class="modern-feature-card">
      <div class="icon"><i class="fas fa-bolt"></i></div>
      <h3>30 Min Service</h3>
      <p>Quick response for all needs.</p>
    </div>
    <div class="modern-feature-card">
      <div class="icon"><i class="fas fa-shield-alt"></i></div>
      <h3>No Hidden Charges</h3>
      <p>Transparent pricing, no surprises.</p>
    </div>
    <div class="modern-feature-card">
      <div class="icon"><i class="fas fa-handshake"></i></div>
      <h3>Direct Deal</h3>
      <p>No intermediaries, fair interactions.</p>
    </div>
    <div class="modern-feature-card">
      <div class="icon"><i class="fas fa-heart"></i></div>
      <h3>Health Insurance</h3>
      <p>We care for vendor well-being.</p>
    </div>
  </div>
</section>

<div class="modern-quality-banner">
  <div class="modern-quality-icon"><i class="fas fa-medal"></i></div>
  <div class="modern-quality-text">
    <h3>100% Quality Assured</h3>
    <p>Not satisfied? We offer a 6-hour warranty.</p>
  </div>
</div>

<div class="section-title">
  <span>What Our Users Say</span>
</div>

<section class="modern-testimonials">
  <div class="modern-testimonial-card">
    <div class="modern-testimonial-header">
      <div class="modern-avatar">HC</div>
      <div class="modern-user-info">
        <h4>Happy Customer</h4>
        <div class="modern-stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
      </div>
    </div>
    <p class="modern-quote">"An amazing platform! I found exactly what I needed in just a few clicks. The vendor was professional and on time."</p>
  </div>
  
  <div class="modern-testimonial-card">
    <div class="modern-testimonial-header">
      <div class="modern-avatar">RS</div>
      <div class="modern-user-info">
        <h4>Rahul Sharma</h4>
        <div class="modern-stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
        </div>
      </div>
    </div>
    <p class="modern-quote">"Loved the direct dealing feature. No hidden charges and complete transparency. Highly recommend BookingYard."</p>
  </div>
</section>

  

  @include('partials.footer-mobile')
  @include('partials.footer-modern')

<script src="js/script.js"></script>
<script src="js/script1.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
      // Ad Slider Logic
      const adSlider = document.getElementById("adSlider");
      const adContainer = document.getElementById("adSliderContainer");
      const adDots = document.querySelectorAll("#adIndicators .dot");
      let currentAdIndex = 0;
      const totalAdSlides = adDots.length;
      let adInterval;
      let startX = 0;
      let endX = 0;

      function updateAdSlide(index) {
          adSlider.style.transform = `translateX(-${index * 100}%)`;
          adDots.forEach(dot => dot.classList.remove("active"));
          adDots[index].classList.add("active");
      }

      function nextAdSlide() {
          currentAdIndex = (currentAdIndex + 1) % totalAdSlides;
          updateAdSlide(currentAdIndex);
      }

      function startAdInterval() {
          adInterval = setInterval(nextAdSlide, 4000); // 4 seconds per slide
      }

      function resetAdInterval() {
          clearInterval(adInterval);
          startAdInterval();
      }

      // Initialize
      if (adSlider && totalAdSlides > 0) {
          startAdInterval();
      }

      // Swipe support
      if (adContainer) {
          adContainer.addEventListener("touchstart", function(e) {
              startX = e.changedTouches[0].screenX;
              clearInterval(adInterval);
          });
          adContainer.addEventListener("touchend", function(e) {
              endX = e.changedTouches[0].screenX;
              handleAdSwipe();
              startAdInterval();
          });
      }

      function handleAdSwipe() {
          const threshold = 40;
          if (endX < startX - threshold) {
              // swipe left (next)
              currentAdIndex = (currentAdIndex + 1) % totalAdSlides;
              updateAdSlide(currentAdIndex);
          } else if (endX > startX + threshold) {
              // swipe right (prev)
              currentAdIndex = (currentAdIndex - 1 + totalAdSlides) % totalAdSlides;
              updateAdSlide(currentAdIndex);
          }
      }
  });
</script>

<!-- <script>
     document.addEventListener("DOMContentLoaded", function () {
      if (window.innerWidth > 768) { 
          // Redirect desktop users to desktop.html
          window.location.href = "/assets/desktop.html";
      }
     });
</script> -->

</body>
</html>
