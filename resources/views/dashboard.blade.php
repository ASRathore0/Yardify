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
    document.getElementById('popupMessage').classList.remove('hidden');
  }, 5000);

  // Function to close the pop-up
  function closePopup() {
    document.getElementById('popupMessage').classList.add('hidden');
  }
</script>
 

<section class="hero" id="home">
  <div class="container">
    <h2>Book Anything, Anywhere, Anytime</h2>
    <p>Find what you need today!</p>
  </div>
</section>
 
<div class="search-container">
  <div class="search-bar">
    <button id="toggleButto" class="toggle-butto">
      <i class="fas fa-chevron-down"> |</i>
    </button>
    <input
      type="text"
      id="searchInput"
      placeholder="Search your city..."
      class="search-input"
      oninput="filterCities()"
      onclick="toggleCityPopup(); scrollIntoViewSmooth()"
    />
    <span class="geo-btn" onclick="getCurrentLocation()"><i class="fas fa-map-marker-alt"></i></span>
  </div>
</div>

<div id="cityPopup" class="city-popup hidden">
  <div class="popup-header">
    <p>Currently we are serving in these cities:</p>
    <button id="closePopup" class="close-popup" onclick="toggleCityPopup()">&times;</button>
  </div>
  <div class="city-list" id="cityList">
      
  </div>
</div>

<script>
  function toggleCityPopup() {
    const cityPopup = document.getElementById('cityPopup');
    cityPopup.classList.toggle('hidden');
  }

  function filterCities() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const cityItems = document.querySelectorAll('.city-item');
    cityItems.forEach(item => {
      const cityName = item.getAttribute('data-city').toLowerCase();
      if (cityName.includes(input)) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  }

  function selectCity(city) {
    document.getElementById('searchInput').value = city;
    toggleCityPopup();
  }

  function scrollIntoViewSmooth() {
    document.getElementById('searchInput').scrollIntoView({ behavior: "smooth",  block: "start" });
  }
</script>
    
  <div class="service-categories">
    <div class="scroll-container">
      <button onclick="selectCategory(this, 'homes')" class="category-btn active">Home services</button>
      <button onclick="selectCategory(this, 'event')" class="category-btn">Event</button>
      <button onclick="selectCategory(this, 'cabs')" class="category-btn">Cabs</button>
      <button onclick="selectCategory(this, 'Rental')" class="category-btn">Rental</button>
      <button onclick="selectCategory(this, 'Working')" class="category-btn">Working Professionals</button>
      <!-- <button onclick="selectCategory(this, 'Health')" class="category-btn">Health & Wellness</button> -->
    </div>
  </div>
 
  
    
<!-- Service Grids -->
<div id="categories-container">
 
  <!-- Home Service Grid -->
  <div class="service-grid" id="homes" data-category="homes">
      <div class="service-box" data-target="Plumber"><img src="image/plumber.avif" alt="Plumber"><span>Plumber</span></div>
      <div class="service-box" data-target="Electrician"><img src="image/electition.webp" alt="Electrician"><span>Electrician</span></div>
      <div class="service-box" data-target="Cleaner"><img src="image/cleaner.jpg" alt="Cleaner"><span>Cleaner</span></div>
      <div class="service-box" data-target="Gardener"><img src="image/gardener.jpeg" alt="Gardener"><span>Gardener</span></div>
      <div class="service-box" data-target="Painter"><img src="image/Painter.jpg" alt="Painter"><span>Painter</span></div>
      <div class="service-box" data-target="Carpenter"><img src="image/Carpenter.jpg" alt="Repairer"><span>Carpenter</span></div>
      <div class="service-box" data-target="Pest"><img src="image/Pest Control.jpeg" alt="Repairer"><span>Pest Control</span></div>
      <div class="service-box" data-target="Tution"><img src="image/teacher.jpeg" alt="Repairer"><span>Tution Teacher</span></div>
      <div class="service-box" data-target="Mineral" ><img src="image/Mineral.jpg" alt="Mineral"><span>Mineral Water</span></div>
  </div>

  <!-- Event Grid -->
  <div class="service-grid hidden" id="event" data-category="event">
    <div class="service-box" data-target="dj" ><img src="image/sound.jpeg" alt="DJ"><span>Sound</span></div>
    <div class="service-box" data-target="Photographer" ><img src="image/photo.jpeg" alt="Photographer"><span>Photographer</span></div>
    <div class="service-box" data-target="Catering" ><img src="image/waiter.jpeg" alt="Catering"><span>Catering</span></div>
    <div class="service-box" data-target="Decorator" ><img src="image/decoration.jpeg" alt="Decorator"><span>Decorator</span></div>
    <div class="service-box" data-target="Tent" ><img src="image/tent.jpeg" alt="Tent"><span>Tent House</span></div>
    <div class="service-box" data-target="Chef" ><img src="image/halwai.jpeg" alt="Sound"><span>Chef</span></div>
    <div class="service-box" data-target="Jaimala" ><img src="image/JaiMala Stage.jpg" alt="Jaimala"><span>Jaimala Stage</span></div>
    <div class="service-box" data-target="Mineral" ><img src="image/Mineral.jpg" alt="Mineral"><span>Mineral Water</span></div>
    <div class="service-box" data-target="Vehicles" ><img src="image/car.jpeg" alt="Vehicles"><span>Vehicles</span></div>
</div>

  <!-- Cabs Grid -->
  <div class="service-grid hidden" id="cabs" data-category="cabs">
    <div class="service-box" data-target="Bike"><img src="image/Bike.webp" alt="Bike"><span>Bike</span></div>
    <div class="service-box" data-target="Toto"><img src="image/Toto.avif" alt="Van"><span>Toto</span></div>
    <div class="service-box" data-target="Auto"><img src="image/Auto.webp" alt="Auto"><span>Auto</span></div>
    <div class="service-box" data-target="Car"><img src="image/car.jpg" alt="Car"><span>Car</span></div>
    <div class="service-box" data-target="Scorpio"><img src="image/SUV.jpg" alt="Scorpio"><span>SUV</span></div>
    <div class="service-box" data-target="Pikup"><img src="image/Pikup.jpg" alt="Van"><span>Pikup</span></div>
    <div class="service-box" data-target="Tractor"><img src="image/Tractor.webp" alt="Van"><span>Tractor</span></div>
    <div class="service-box" data-target="Bus"><img src="image/Bus.webp" alt="Van"><span>Bus</span></div>
    <div class="service-box" data-target="Other"><img src="image/Taxi.jpg" alt="Taxi"><span>Other</span></div>  
  </div>

   <!-- Hotels Grid -->
  <div class="service-grid hidden" id="Rental" data-category="Rental">
      <div class="service-box" data-target="3BHK"><img src="image/5-star.jpg" alt="5-star"><span>3BHK</span></div>
      <div class="service-box" data-target="2BHK"><img src="image/4-star.webp" alt="4-star"><span>2BHK</span></div>
      <div class="service-box" data-target="1BHK"><img src="image/3-star.webp" alt="3-star"><span>1BHK</span></div>
       <div class="service-box" data-target="Guesthouse"><img src="image/Guesthouse.jpg" alt="Guesthouse"><span>Guesthouse</span></div>
      <div class="service-box" data-target="PG"><img src="image/PG.jpg" alt="Hostel"><span>PG</span></div>
       <div class="service-box" data-target="Others"><img src="image/othe.jpg" alt="Hostel"><span>Others</span></div>
  </div>  

  <!-- Working Professional Grid -->
  <div class="service-grid hidden" id="Working" data-category="Working">
    <div class="service-box" data-target="Health"><img src="image/HealthWellness.png" alt="Health and Wellness"><span>Health and Wellness</span></div>
    <div class="service-box" data-target="Tution"><img src="image/Tutors and Educators.jpg" alt="Tutors and Educators"><span>Tutors and Educators</span></div>
    <div class="service-box" data-target="Technology"><img src="image/Technology Services.jpg" alt="Technology Services"><span>Technology Services</span></div>
    <div class="service-box" data-target="Legal"><img src="image/Legal and Financial Services.webp" alt="egal and Financial Services"><span>Legal and Finance</span></div>
    <div class="service-box" data-target="Estate"><img src="image/estate.jpeg" alt="Estate Agent"><span>Estate Agent</span></div>
    <div class="service-box" data-target="Beauty"><img src="image/bride.jpeg" alt="Beauty and Grooming"><span>Beauty and Grooming</span></div>
    <div class="service-box" data-target="massage"><img src="image/massage.webp" alt="Massage & Spa"><span>Massage & Spa</span></div>
    <div class="service-box" data-target="Tractor"><img src="image/yoga.jpeg" alt="Yoga & Trainer"><span>Yoga & Trainer</span></div>
    <div class="service-box" data-target="Tattoo"><img src="image/Tattoo.webp" alt="Tattoo Artists"><span>Tattoo Artists</span></div>
  </div>
 
@include('layouts.services')
<section class="why-bookingyard">
    <h2>Why BookingYard?</h2>
  
    <div class="feature">
      <div class="feature-icon"><i class="fas fa-cog"></i></div>
      <div class="feature-text">
        <h3>Service Available within 30 Min</h3>
        <p>Quick response time for all your booking needs.</p>
      </div>
    </div>
    <div class="feature">
      <div class="feature-icon"><i class="fas fa-check-circle"></i></div>
      <div class="feature-text">
        <h3>No Hidden Charges</h3>
        <p>Transparent pricing with no surprises.</p>
      </div>
    </div>
  
    <div class="feature">
      <div class="feature-icon"><i class="fas fa-phone-volume"></i></div>
      <div class="feature-text">
        <h3>Direct Deal with Vendors</h3>
        <p>No intermediaries, ensuring direct and fair interactions.</p>
      </div>
    </div>
  
    <div class="feature">
      <div class="feature-icon"><i class="fas fa-desktop"></i></div>
      <div class="feature-text">
        <h3>Easy Interface</h3>
        <p>User-friendly design for a seamless booking experience.</p>
      </div>
    </div>
  
    <div class="feature">
      <div class="feature-icon"><i class="fas fa-medkit"></i></div>
      <div class="feature-text">
        <h3>Health Insurance for Vendors</h3>
        <p>We care for our vendors' well-being and security.</p>
      </div>
    </div>
  
    <div class="feature">
      <div class="feature-icon"><i class="fas fa-arrow-up"></i></div>
      <div class="feature-text">
        <h3>Empowering Local Businesses</h3>
        <p>Supporting and promoting local vendors and services.</p>
      </div>
    </div>

    
  </section>
 
  <section class="quality-assured">
    <div class="quality-icon">
      <img src="image/service.png" alt="Quality Assured" />
    </div>
    <h3>100% Quality Assured</h3>
    <p>If you are not satisfied with our work, we offer a 6-hour warranty.</p>
  </section>
   
<section class="testimonials" id="testimonials">
    <div class="container">
        <h2 style="color: #046c9f;">What Our Users Say</h2>
        <blockquote>
            <p>"An amazing platform! I found exactly what I needed."</p>
            <cite>- Happy Customer</cite>
        </blockquote>
    </div>
</section>

  <script>
    // Render vendor cards dynamically from API
    function slugify(s){ return (s||'').toString().toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,''); }

    async function loadVendorsForSelection() {
      try{
        const city = document.getElementById('searchInput')?.value || '';
        const activeBtn = document.querySelector('.service-categories .category-btn.active');
        const categoryMap = { homes: 'Home Service', event: 'Event', cabs: 'Cabs', hotels: 'Hotels', Working: 'Working Professionals' };
        const categoryKey = activeBtn ? activeBtn.getAttribute('onclick')?.match(/'(.*?)'/)?.[1] : '';
        const category = categoryMap[categoryKey] || '';
        // Find selected service type from visible grid click context (fallback none)
        // prefer explicit last click, otherwise fall back to query params
        const urlParams = new URLSearchParams(window.location.search);
        const selectedTarget = window._lastServiceTarget || (urlParams.get('service') || '');
        const params = new URLSearchParams();
        if (selectedTarget) params.append('service', selectedTarget);
        if (category) params.append('category', category);
        if (city) params.append('city', city);
        const url = `{{ route('vendors.search') }}?${params.toString()}`;
        console.log('[loadVendorsForSelection] fetching', url);
        const res = await fetch(url);
        const list = await res.json();
        console.log('[loadVendorsForSelection] got', list && list.length ? list.length : 0, 'vendors');
        // Add any vendor cities to the city popup so newly-created vendor cities are searchable
        try {
          (function addCitiesToPopup(vendors){
            const cityListEl = document.getElementById('cityList');
            if (!cityListEl || !vendors || !vendors.length) return;
            vendors.forEach(v => {
              const c = (v.city||'').toString().trim();
              if (!c) return;
              const exists = Array.from(cityListEl.querySelectorAll('.city-item')).some(el => (el.getAttribute('data-city')||'').toLowerCase() === c.toLowerCase());
              if (!exists) {
                const div = document.createElement('div');
                div.className = 'city-item';
                div.setAttribute('data-city', c);
                // attach click handler to select city
                div.setAttribute('onclick', `selectCity('${c.replace(/'/g, "\\'")}')`);
                div.innerHTML = `<i class="fas fa-city city-icon"></i><div class="city-name-container">${c}</div>`;
                cityListEl.appendChild(div);
              }
            });
          })(list);
        } catch(e){ /* noop */ }
        const container = document.getElementById('dynamic-services-container');
        // Keep existing static cards; append DB results at top
        const mountId = 'db-vendors';
        let mount = document.getElementById(mountId);
        if (!mount){ mount = document.createElement('div'); mount.id = mountId; /* make wrapper transparent to grid */ mount.style.display = 'contents'; container.prepend(mount); }
        if (!list || !Array.isArray(list) || list.length === 0) {
          mount.innerHTML = `<div class="no-results" style="padding:16px;background:#fff3f2;border:1px solid #fee2e2;border-radius:8px;margin:8px 0;color:#991b1b">No vendors found.</div>`;
        } else {
          mount.innerHTML = list.map(v => {
          const svc = v.service || v.title || '';
          const svcSlug = slugify(svc);
          return `
          <div class="service-card" onclick="showButtons(this)" data-card-id="vendor-${v.id}" data-address="${(v.address||'').replace(/"/g,'&quot;')}" data-contact="${(v.contact||'').replace(/"/g,'&quot;')}" data-services='${JSON.stringify(v.services||[]).replace(/'/g,'&#39;') }' data-service-slug="${svcSlug}" data-city="${(v.city||'').replace(/"/g,'&quot;')}">
            <div class="service-image">
              <img src="${v.image || '{{ asset('image/Booking.jpg') }}'}" alt="${v.title}">
              ${v.discount ? `<span class="offer-tag">Flat ${v.discount}% OFF</span>` : ''}
            </div>
            <div class="service-details">
              <h3>${v.title}</h3>
              ${v.subtitle ? `<p id="fad">${v.subtitle}</p>` : ''}
              <p class="location">${[v.area, v.city].filter(Boolean).join(', ')}</p>
              <div class="service-meta">
                <span class="rating">${(Number(v.rating) || 0).toFixed(1)}★</span>
                ${v.price ? `<span class="price">₹${Number(v.price)}</span>` : ''}
                <span class="distance"><i class="fas fa-map-marker-alt"></i>Nearby</span>
              </div>
            </div>
            <div class="details hidden"></div>
          </div>
        `}).join('');

        // Ensure image fallback and keep service slug dataset for filtering
        mount.querySelectorAll('.service-card').forEach(el => {
          const img = el.querySelector('img');
          if (img && (!img.getAttribute('src') || img.getAttribute('src') === '')) {
            img.setAttribute('src', '{{ asset('image/Booking.jpg') }}');
          }
        });
        }
        return list || [];
      } catch(err){ console.error('Failed to load vendors', err); return []; }
    }

    // Capture which service tile user picked
    (function hookServiceBoxClicks(){
      document.querySelectorAll('.service-box').forEach(box => {
        box.addEventListener('click', () => {
          window._lastServiceTarget = box.getAttribute('data-target') || '';
          // Delay to let existing UI update, then load
          setTimeout(loadVendorsForSelection, 200);
        });
      });
    })();

    // Populate city popup with all vendor cities on load
    (function populateCityList(){
      try {
        const url = `{{ route('vendors.cities') }}`;
        fetch(url).then(r => r.json()).then(list => {
          const cityListEl = document.getElementById('cityList');
          if (!cityListEl || !Array.isArray(list)) return;
          list.forEach(c => {
            if (!c) return;
            const exists = Array.from(cityListEl.querySelectorAll('.city-item')).some(el => (el.getAttribute('data-city')||'').toLowerCase() === c.toLowerCase());
            if (!exists) {
              const div = document.createElement('div');
              div.className = 'city-item';
              div.setAttribute('data-city', c);
              div.setAttribute('onclick', `selectCity('${c.replace(/'/g, "\\'")}')`);
              div.innerHTML = `<i class="fas fa-city city-icon"></i><div class="city-name-container">${c}</div>`;
              cityListEl.appendChild(div);
            }
          });
        }).catch(()=>{/* noop */});
      } catch(e) { /* noop */ }
    })();

    // If page loaded with ?service=... or ?city=... or ?category=..., reflect that in UI and load vendors
    (function applyUrlPrefill(){
      const params = new URLSearchParams(window.location.search);
      const svc = params.get('service');
      const city = params.get('city');
      const category = params.get('category');
      // If page opened with a city that's not yet in the popup, add it so the vendor can find themselves
      if (city) {
        try {
          const cityListEl = document.getElementById('cityList');
          if (cityListEl) {
            const found = Array.from(cityListEl.querySelectorAll('.city-item')).some(el => (el.getAttribute('data-city')||'').toLowerCase() === city.toLowerCase());
            if (!found) {
              const div = document.createElement('div');
              div.className = 'city-item';
              div.setAttribute('data-city', city);
              div.setAttribute('onclick', `selectCity('${city.replace(/'/g, "\\'")}')`);
              div.innerHTML = `<i class="fas fa-city city-icon"></i><div class="city-name-container">${city}</div>`;
              document.getElementById('cityList').appendChild(div);
            }
          }
        } catch(e) { /* noop */ }
      }
      if (city && document.getElementById('searchInput')) document.getElementById('searchInput').value = city;
      if (svc) {
        // try to find a matching service-box and simulate a click to highlight UI
        const boxes = Array.from(document.querySelectorAll('.service-box'));
        const match = boxes.find(b => (b.getAttribute('data-target')||'').toLowerCase() === svc.toLowerCase() || (b.textContent||'').toLowerCase().includes(svc.toLowerCase()));
        if (match) {
          match.classList.add('selected');
          window._lastServiceTarget = match.getAttribute('data-target') || '';
        } else {
          window._lastServiceTarget = svc;
        }
      }
      if (category) {
        // click the matching category button if available
        const catMap = { 'home service':'homes','event':'event','cabs':'cabs','hotels':'hotels','working professionals':'Working' };
        const key = (category||'').toString().toLowerCase();
        const elemId = catMap[key];
        if (elemId) {
          const btn = Array.from(document.querySelectorAll('.service-categories .category-btn')).find(b => b.getAttribute('onclick')?.includes(elemId));
          if (btn) btn.classList.add('active');
        }
      }
      if (svc || city || category) setTimeout(loadVendorsForSelection, 300);
    })();

    // Also reload when city is picked/changed or category changes
    const si = document.getElementById('searchInput');
    if (si) si.addEventListener('change', () => setTimeout(loadVendorsForSelection, 200));

    // Hook category buttons
    document.querySelectorAll('.service-categories .category-btn').forEach(btn => {
      btn.addEventListener('click', () => setTimeout(loadVendorsForSelection, 200));
    });

    // Initial try: disabled to avoid showing all services by default
    // Services will load only after the user selects a service, city, or uses the search input.
    // document.addEventListener('DOMContentLoaded', () => setTimeout(loadVendorsForSelection, 500));
  </script>

  @include('partials.footer-mobile')

<script src="js/script.js"></script>
<script src="js/script1.js"></script>

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
