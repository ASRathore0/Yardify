<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/icon.ico.jpg') }}">
    <meta name="Description" content="Book your day to day on door services with BookingYard . It is Indian on door service platform that have thousands of happy Customer.">
    <meta name="keywords" content="Bookingyard, BookingYard, booking.com, booking, bookmyshow, booking yard, founder of bookingyard, bookingyard company, skynet bookingyards, skynet, skynet company, bookingyards company">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore BookingYard</title>

    <link rel="stylesheet" href="{{ asset('css/stylee.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

<style>
  /* Modern Explore App CSS */
  body {
      background-color: #ffffff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .explore-container {
      padding: 15px;
      margin-top: 15px; Adjust according to top navbar
  }
  
  /* Search Bar Area */
  .search-wrapper {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 25px;
      position: relative;
  }
  .search-box {
      flex: 1;
      display: flex;
      align-items: center;
      background: #f4f6f8;
      border-radius: 30px;
      padding: 12px 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.02);
      position: relative;
  }
  .search-box i {
      color: #046c9f;
      font-size: 1.1rem;
  }
  .search-box input {
      border: none;
      background: none;
      outline: none;
      width: 100%;
      margin-left: 10px;
      font-size: 1rem;
      color: #333;
  }
  .city-dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      width: calc(100% - 60px); /* Account for filter button gap */
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      margin-top: 8px;
      max-height: 250px;
      overflow-y: auto;
      z-index: 100;
      display: none;
      border: 1px solid #e2e8f0;
  }
  .city-item {
      padding: 12px 20px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 10px;
      color: #475569;
      transition: background 0.2s;
  }
  .city-item i {
      color: #cbd5e1;
  }
  .city-item:hover {
      background: #f8fafc;
      color: #0ea5e9;
  }
  .city-item:hover i {
      color: #0ea5e9;
  }
  .filter-btn {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: #eef9ff;
      color: #046c9f;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
  }
  
  /* Category Pills */
  .category-pills {
      display: flex;
      gap: 12px;
      overflow-x: auto;
      padding-bottom: 10px;
      margin-bottom: 15px;
      -ms-overflow-style: none;
      scrollbar-width: none;
  }
  .category-pills::-webkit-scrollbar {
      display: none;
  }
  .pill {
      padding: 12px 24px;
      border-radius: 25px;
      font-size: 0.95rem;
      font-weight: 600;
      white-space: nowrap;
      border: none;
      cursor: pointer;
      background: #f4f6f8;
      color: #333;
      transition: all 0.3s;
  }
  .pill.active {
      background: #046c9f;
      color: #fff;
  }
  
  /* Subcategories Grid */
  .subcategories-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px;
  }
  .subcat-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
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
  .subcat-card:hover {
      transform: translateY(-2px);
  }
  .subcat-card img {
      width: 45px;
      height: 45px;
      object-fit: contain;
  }
  .subcat-card span {
      font-size: 0.85rem;
      font-weight: 600;
      color: #1e293b;
      text-align: center;
      line-height: 1.2;
  }
  .hidden {
      display: none !important;
  }
</style>

<body>
  @include('partials.header')
  @include('partials.sidebar')
    
  <div class="explore-container">
    <!-- Search Bar -->
    <div class="search-wrapper">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" autocomplete="off" value="{{ auth()->check() && auth()->user()->city ? auth()->user()->city : session('user_location', '') }}" placeholder="Search services by city..." {{ request('focus') === 'search' ? 'autofocus' : '' }}>
      </div>
      <div class="city-dropdown" id="cityDropdown"></div>
      <button class="filter-btn" onclick="getCurrentLocation()" title="Use current location">
        <i class="fas fa-map-marker-alt"></i>
      </button>
    </div>

    @php
      $activeCategory = request('category', 'homes');
    @endphp

    <!-- Category Pills -->
    <div class="category-pills">
      <button class="pill {{ $activeCategory === 'homes' ? 'active' : '' }}" onclick="switchCategory('homes', this)">Home Services</button>
      <button class="pill {{ $activeCategory === 'cabs' ? 'active' : '' }}" onclick="switchCategory('cabs', this)">Cabs</button>
      <button class="pill {{ $activeCategory === 'event' ? 'active' : '' }}" onclick="switchCategory('event', this)">Events</button>
      <button class="pill {{ $activeCategory === 'Rental' ? 'active' : '' }}" onclick="switchCategory('Rental', this)">Rentals</button>
      <button class="pill {{ $activeCategory === 'Working' ? 'active' : '' }}" onclick="switchCategory('Working', this)">Professionals</button>
    </div>

    <!-- Subcategories Grid -->
    <div id="categories-container">
      <!-- Home Service Grid -->
      <div class="subcategories-grid {{ $activeCategory !== 'homes' ? 'hidden' : '' }}" id="homes">
          <div class="subcat-card" data-target="Plumber"><img src="image/plumber.png" alt="Plumber"><span>Plumber</span></div>
          <div class="subcat-card" data-target="Electrician"><img src="image/electrician.png" alt="Electrician"><span>Electrician</span></div>
          <div class="subcat-card" data-target="Cleaner"><img src="image/Cleaner.png" alt="Cleaner"><span>Cleaner</span></div>
          <div class="subcat-card" data-target="Gardener"><img src="image/Gardener.png" alt="Gardener"><span>Gardener</span></div>
          <div class="subcat-card" data-target="Painter"><img src="image/Painter.png" alt="Painter"><span>Painter</span></div>
          <div class="subcat-card" data-target="Carpenter"><img src="image/carpenter.png" alt="Carpenter"><span>Carpenter</span></div>
          <div class="subcat-card" data-target="Pest"><img src="image/_Pest.png" alt="Pest Control"><span>Pest Control</span></div>
          <div class="subcat-card" data-target="Tution"><img src="image/_Teacher.png" alt="Tuition Tutor"><span>Tuition Tutor</span></div>
          <div class="subcat-card" data-target="Mineral" ><img src="image/Water.png" alt="Mineral Water"><span>Mineral Water</span></div>
      </div>

      <!-- Event Grid -->
      <div class="subcategories-grid {{ $activeCategory !== 'event' ? 'hidden' : '' }}" id="event">
          <div class="subcat-card" data-target="dj" ><img src="image/Sound.png" alt="Sound"><span>Sound</span></div>
          <div class="subcat-card" data-target="Photographer" ><img src="image/Photographer.png" alt="Photographer"><span>Photographer</span></div>
          <div class="subcat-card" data-target="Catering" ><img src="image/catering.png" alt="Catering"><span>Catering</span></div>
          <div class="subcat-card" data-target="Decorator" ><img src="image/Decorator.png" alt="Decorator"><span>Decorator</span></div>
          <div class="subcat-card" data-target="Tent" ><img src="image/Tent.png" alt="Tent House"><span>Tent House</span></div>
          <div class="subcat-card" data-target="Chef" ><img src="image/Chef.png" alt="Chef"><span>Chef</span></div>
          <div class="subcat-card" data-target="Jaimala" ><img src="image/Jaimala.png" alt="Jaimala Stage"><span>Jaimala Stage</span></div>
          <div class="subcat-card" data-target="Mineral" ><img src="image/Water.png" alt="Mineral Water"><span>Mineral Water</span></div>
          <div class="subcat-card" data-target="Vehicles" ><img src="image/Rath.png" alt="Vehicles"><span>Vehicles</span></div>
      </div>

      <!-- Cabs Grid -->
      <div class="subcategories-grid {{ $activeCategory !== 'cabs' ? 'hidden' : '' }}" id="cabs">
          <div class="subcat-card" data-target="Bike"><img src="image/Bike.png" alt="Bike"><span>Bike</span></div>
          <div class="subcat-card" data-target="Toto"><img src="image/Toto.png" alt="Toto"><span>Toto</span></div>
          <div class="subcat-card" data-target="Auto"><img src="image/Auto.png" alt="Auto"><span>Auto</span></div>
          <div class="subcat-card" data-target="Car"><img src="image/cab.png" alt="Car"><span>Car</span></div>
          <div class="subcat-card" data-target="Scorpio"><img src="image/SUV.png" alt="SUV"><span>SUV</span></div>
          <div class="subcat-card" data-target="Pikup"><img src="image/Pikup.png" alt="Pikup"><span>Pikup</span></div>
          <div class="subcat-card" data-target="Tractor"><img src="image/Tractor.png" alt="Tractor"><span>Tractor</span></div>
          <div class="subcat-card" data-target="Bus"><img src="image/Bus.png" alt="Bus"><span>Bus</span></div>
          <div class="subcat-card" data-target="Other"><img src="image/Driver.png" alt="Other"><span>Other</span></div>  
      </div>

       <!-- Hotels Grid -->
      <div class="subcategories-grid {{ $activeCategory !== 'Rental' ? 'hidden' : '' }}" id="Rental">
          <div class="subcat-card" data-target="3BHK"><img src="image/3BHK.png" alt="3BHK"><span>3BHK</span></div>
          <div class="subcat-card" data-target="2BHK"><img src="image/2BHK.png" alt="2BHK"><span>2BHK</span></div>
          <div class="subcat-card" data-target="1BHK"><img src="image/1BHK.png" alt="1BHK"><span>1BHK</span></div>
          <div class="subcat-card" data-target="Guesthouse"><img src="image/Guest.png" alt="Guesthouse"><span>Guesthouse</span></div>
          <div class="subcat-card" data-target="PG"><img src="image/PG.png" alt="PG"><span>PG</span></div>
          <div class="subcat-card" data-target="Others"><img src="image/hotel.png" alt="Others"><span>Others</span></div>
      </div>  

      <!-- Working Professional Grid -->
      <div class="subcategories-grid {{ $activeCategory !== 'Working' ? 'hidden' : '' }}" id="Working">
          <div class="subcat-card" data-target="Health"><img src="image/Physiotherapist.png" alt="Health and Wellness"><span>Health and Wellness</span></div>
          <div class="subcat-card" data-target="Tution"><img src="image/_Teacher.png" alt="Tutors and Educators"><span>Tutors and Educators</span></div>
          <div class="subcat-card" data-target="Technology"><img src="image/Technology.png" alt="Technology Services"><span>Technology Services</span></div>
          <div class="subcat-card" data-target="Legal"><img src="image/Legal.png" alt="Legal and Finance"><span>Legal and Finance</span></div>
          <div class="subcat-card" data-target="Estate"><img src="image/Estate.png" alt="Estate Agent"><span>Estate Agent</span></div>
          <div class="subcat-card" data-target="Beauty"><img src="image/Massage.png" alt="Beauty and Grooming"><span>Beauty and Grooming</span></div>
          <div class="subcat-card" data-target="massage"><img src="image/Massage.png" alt="Massage & Spa"><span>Massage & Spa</span></div>
          <div class="subcat-card" data-target="Tractor"><img src="image/Yoga.png" alt="Yoga & Trainer"><span>Yoga & Trainer</span></div>
          <div class="subcat-card" data-target="Tattoo"><img src="image/Tattoo.png" alt="Tattoo Artists"><span>Tattoo Artists</span></div>
      </div>
    </div> <!-- End categories-container -->

    <!-- Dynamic Vendors Rendered Here -->
    <h3 style="margin-top: 25px; padding-bottom: 10px; border-bottom: 2px solid #eef9ff; color: #1e293b;">Available Services Near You</h3>
    <div id="explore-vendors-container" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:20px; margin-top: 15px; margin-bottom: 40px;">
    </div>
    
    <!-- Status Modal / Toasts -->
    <div id="booking-toast" style="display:none; position:fixed; bottom:20px; right:20px; background:#10b981; color:#fff; padding:12px 24px; border-radius:8px; box-shadow:0 10px 15px -3px rgba(0,0,0,0.1); z-index:9999;"></div>


  </div>

  @include('partials.footer-mobile')
  @include('partials.footer-modern')

  <script>
    // Tab switching for categories
    function switchCategory(categoryId, btnElement) {
        // Remove active class from all pills
        const pills = document.querySelectorAll('.category-pills .pill');
        pills.forEach(pill => pill.classList.remove('active'));
        
        // Add active class to clicked pill or find the matching pill
        if(btnElement) {
            btnElement.classList.add('active');
        } else {
            const targetPill = document.querySelector(`.category-pills .pill[onclick*="'${categoryId}'"]`);
            if (targetPill) targetPill.classList.add('active');
        }

        // Hide all grids
        const grids = document.querySelectorAll('.subcategories-grid');
        grids.forEach(grid => grid.classList.add('hidden'));

        // Show selected grid
        const selectedGrid = document.getElementById(categoryId);
        if (selectedGrid) {
            selectedGrid.classList.remove('hidden');
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);
        
        // Handle search focus redirection
        if (params.get('focus') === 'search') {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                // Use a short timeout to ensure the element is focusable after rendering
                setTimeout(() => {
                    searchInput.focus();
                    searchInput.select();
                }, 100);
            }
        }

        // Handle subcategory (service) loading
        const service = params.get('service');
        if (service) {
            const subcat = document.querySelector(`.subcat-card[data-target="${service}"]`);
            if (subcat) {
                // Determine the parent grid and switch to it automatically
                const parentGrid = subcat.closest('.subcategories-grid');
                if (parentGrid && parentGrid.id) {
                    switchCategory(parentGrid.id);
                }
                
                // Add brief visual highlight
                subcat.style.border = "2px solid #046c9f";
                subcat.style.transform = "translateY(-5px)";
                setTimeout(() => { 
                    subcat.style.border = ""; 
                    subcat.style.transform = "";
                }, 1500);
            }
        }
    });
</script>

  <script src="js/script.js"></script>
  <script src="js/script1.js"></script>

  <script>
    async function fetchVendorsAndRender() {
       const city = document.getElementById('searchInput')?.value || '';

       // Cache the city in localStorage so it remembers user's manual or auto-detected location
       if (city) {
           localStorage.setItem('user_saved_location', city);
       }

       const activePill = document.querySelector('.category-pills .pill.active');
       
       let category = '';
       if (activePill) {
           const map = { 'homes': 'Home Service', 'cabs': 'Cabs', 'event': 'Event', 'Rental': 'Hotels', 'Working': 'Working Professionals' };
           Object.keys(map).forEach(key => {
               if (activePill.getAttribute('onclick').includes(key)) category = map[key];
           });
       }

       const urlParams = new URL(window.location.href);
       let service = urlParams.searchParams.get('service') || '';

       let url = '/api/vendors?city=' + encodeURIComponent(city) + '&category=' + encodeURIComponent(category);
       if (service) url += '&service=' + encodeURIComponent(service);

       try {
           const container = document.getElementById('explore-vendors-container');
           container.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 20px; color:#64748b;">Loading local professionals...</div>';
           
           const res = await fetch(url);
           const vendors = await res.json();
           
           if (!vendors || vendors.length === 0) {
               container.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 20px; border: 1px dashed #cbd5e1; border-radius: 12px; color:#64748b; background:#f8fafc;">No professionals found in this area for this category. Try changing your location or category.</div>';
               return;
           }

           let csrfToken = '';
           const metaRow = document.querySelector('meta[name="csrf-token"]');
           if(metaRow) csrfToken = metaRow.getAttribute('content');

           const html = vendors.map(v => {
               return `
               <div style="background:#fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display:flex; flex-direction:column;">
                   <div style="height:160px; background:#f1f5f9; position:relative;">
                       <img src="${v.image || '/image/Booking.jpg'}" style="width:100%; height:100%; object-fit:cover;">
                       ${v.discount ? `<span style="position:absolute; top:10px; left:10px; background:#ef4444; color:#fff; font-size:12px; font-weight:bold; padding:4px 8px; border-radius:4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">${v.discount}% OFF</span>` : ''}
                   </div>
                   <div style="padding: 16px; flex:1; display:flex; flex-direction:column;">
                       <h4 style="margin: 0 0 6px 0; color: #1e293b; font-size: 1.1rem; line-height:1.2;">${v.title}</h4>
                       <div style="color: #64748b; font-size: 0.85rem; margin-bottom: 12px;">${v.city}, ${v.area}</div>
                       
                       <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px; background: #f8fafc; padding:8px; border-radius:8px;">
                           <div>
                               <div style="font-size: 0.75rem; color: #64748b;">Starting from</div>
                               <div style="font-weight: bold; color: #0077b6; font-size: 1.1rem;">₹${v.price || '--'}</div>
                           </div>
                           <div style="text-align:right;">
                               <div style="font-size: 0.75rem; color: #64748b;">Rating</div>
                               <div style="font-weight: bold; color: #1e293b; display:flex; align-items:center; gap:4px; justify-content:flex-end;">
                                   <i class="fas fa-star" style="color:#eab308; font-size:0.8rem;"></i> ${v.rating || 'New'}
                               </div>
                           </div>
                       </div>
                       
                       <div style="margin-top:auto;">
                           <button onclick="window.location.href='/professional/' + ${v.id}" style="width:100%; padding:12px; background:#0ea5e9; color:#fff; border:none; border-radius:8px; font-weight:600; font-size:1rem; cursor:pointer; transition:0.2s;" onmouseover="this.style.background='#0284c7'" onmouseout="this.style.background='#0ea5e9'">
                               View & Book
                           </button>
                       </div>
                   </div>
               </div>
               `;
           }).join('');

           container.innerHTML = html;
       } catch (err) {
           console.error(err);
       }
    }

    async function bookVendor(vendorId, serviceName, basePrice) {
        // Need to ask user for schedule date/time using a simple prompt
        const dateStr = prompt(`Booking ${serviceName}\nWhen do you need this service? (YYYY-MM-DD HH:MM)`, new Date().toISOString().slice(0,16).replace('T',' '));
        if (!dateStr) return; // User cancelled

        const notes = prompt(`Any special request or notes? (Optional)`, '');

        try {
            const res = await fetch('/bookings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    vendor_id: vendorId,
                    service_name: serviceName,
                    scheduled_at: dateStr,
                    notes: notes
                })
            });

            if (res.status === 401) {
                alert('Please log in to book a service.');
                window.location.href = '/login';
                return;
            }

            const data = await res.json();
            if (data.success) {
                const toast = document.getElementById('booking-toast');
                toast.textContent = data.success;
                toast.style.display = 'block';
                setTimeout(() => toast.style.display = 'none', 4000);
            } else if (data.error) {
                alert(data.error);
            } else {
                alert('Booking created! Awaiting vendor approval.');
            }
        } catch(e) {
            console.error(e);
            alert('Something went wrong. Could not book at this time.');
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        // Override switchCategory to also load vendors
        const originalSwitch = window.switchCategory;
        if (typeof originalSwitch === 'function') {
            window.switchCategory = function(cat, btn) {
                originalSwitch(cat, btn);
                fetchVendorsAndRender();
            };
        }

        // Add event listener to search box
        const s = document.getElementById('searchInput');
        const dropdown = document.getElementById('cityDropdown');
        let citiesList = [];

        if (s) {
            // Restore from localStorage if available (overrides session to keep the user's last true search)
            const savedCity = localStorage.getItem('user_saved_location');
            // If savedCity exists, use it. But don't overwrite if Laravel gave us something and savedCity is empty.
            if (savedCity && savedCity.trim() !== '') {
                s.value = savedCity;
            }

            // Fetch cities list on load
            fetch('/api/vendor-cities')
                .then(res => res.json())
                .then(data => { citiesList = data; })
                .catch(err => console.error("Error fetching cities", err));

            // Function to render dropdown
            const renderDropdown = (query = '') => {
                const q = query.toLowerCase();
                const filtered = citiesList.filter(city => city && city.toLowerCase().includes(q));
                
                if (filtered.length === 0) {
                    dropdown.style.display = 'none';
                    return;
                }

                dropdown.innerHTML = filtered.map(city => `
                    <div class="city-item" onclick="selectCity('${city.replace(/'/g, "\\'")}')">
                        <i class="fas fa-map-marker-alt"></i> ${city}
                    </div>
                `).join('');
                dropdown.style.display = 'block';
            };

            // Show options on focus
            s.addEventListener('focus', () => {
                renderDropdown(s.value);
            });

            // Filter options on typing
            s.addEventListener('input', () => {
                renderDropdown(s.value);
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!s.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });

            // Re-fetch vendors if user hits Enter
            s.addEventListener('change', fetchVendorsAndRender);
        }

        // Make selectCity available globally so onclick works
        window.selectCity = function(city) {
            if (s) {
                s.value = city;
                dropdown.style.display = 'none';
                fetchVendorsAndRender();
            }
        };

        // Load initially
        setTimeout(fetchVendorsAndRender, 300);
    });
  </script>

</body>
</html>
