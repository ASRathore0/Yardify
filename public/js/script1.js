  
document.addEventListener("DOMContentLoaded", function () {
  // Get the current page path
  const currentPath = window.location.pathname;

  // Map of page paths to button IDs
  const pathToIdMap = {
    "/index.html": "explore-button",
    "/": "home-button",
    "/assets/other.html": "cart-button",
    "/assets/login.html": "profile-button",
    // Add more mappings as needed
  };

  // Find the corresponding button ID for the current path
  const activeButtonId = pathToIdMap[currentPath];

  // If a match is found, add the 'active' class to the button with that ID
  if (activeButtonId) {
    const activeButton = document.getElementById(activeButtonId);
    if (activeButton) {
      activeButton.classList.add("active");
    }
  }
});
 
// Get the user's current location without an API key
function getCurrentLocation() {
    const locationInput = document.getElementById('searchInput');
    if (!navigator.geolocation) {
        console.warn('Geolocation not supported, falling back to IP lookup');
        return fallbackToIp();
    }

    const start = Date.now();
    const opts = { enableHighAccuracy: false, timeout: 5000, maximumAge: 600000 };

    navigator.geolocation.getCurrentPosition(
        position => {
            const took = Date.now() - start;
            console.log('getCurrentPosition success in', took, 'ms');
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            const nearestLocation = findNearestLocation(userLat, userLng);

            if (nearestLocation) {
                if (locationInput) locationInput.value = nearestLocation.name;
                if (typeof window.loadVendorsForSelection === 'function') {
                    setTimeout(window.loadVendorsForSelection, 250);
                }
            } else {
                console.log('No nearby supported city found; falling back to IP-based city');
                fallbackToIp();
            }
        },
        (err) => {
            console.warn('getCurrentPosition failed', err);
            // try a quick IP-based lookup as fallback
            fallbackToIp();
        },
        opts
    );
}

// Return nearest supported location (within maxDistanceKm), or null
function findNearestLocation(lat, lng, maxDistanceKm = 200) {
    const locations = [
        { name: 'Delhi', lat: 28.7041, lng: 77.1025 },
        { name: 'Ludhiana', lat: 30.9010, lng: 75.8573 },
        { name: 'Khanna', lat: 30.6868, lng: 76.2169 },
        { name: 'Patna', lat: 25.5941, lng: 85.1376 },
        { name: 'Siwan', lat: 26.2204, lng: 84.3564 },
        { name: 'Maharajganj', lat: 27.1000, lng: 83.4833 },
        { name: 'Gopalganj', lat: 26.4739, lng: 84.4490 },
        { name: 'Mirganj', lat: 26.2966, lng: 84.7374 }
    ];

    function toRad(deg){ return deg * Math.PI / 180; }
    function haversine(aLat, aLng, bLat, bLng){
        const R = 6371; // km
        const dLat = toRad(bLat - aLat);
        const dLon = toRad(bLng - aLng);
        const lat1 = toRad(aLat);
        const lat2 = toRad(bLat);
        const sinDLat = Math.sin(dLat/2);
        const sinDLon = Math.sin(dLon/2);
        const a = sinDLat*sinDLat + sinDLon*sinDLon * Math.cos(lat1) * Math.cos(lat2);
        return 2 * R * Math.asin(Math.sqrt(a));
    }

    let best = null;
    let bestDist = Infinity;
    locations.forEach(loc => {
        const d = haversine(lat, lng, loc.lat, loc.lng);
        if (d < bestDist) { bestDist = d; best = loc; }
    });
    return bestDist <= maxDistanceKm ? best : null;
}

function fallbackToIp() {
    const locationInput = document.getElementById('searchInput');
    // Use a lightweight public IP geolocation service to get approximate city
    return fetch('https://ipapi.co/json/')
        .then(r => r.ok ? r.json() : Promise.reject('ip lookup failed'))
        .then(data => {
            const city = (data.city || data.region || '').toString().trim();
            const lat = data.latitude || data.lat || null;
            const lon = data.longitude || data.lon || data.longitude || null;
            if (city && locationInput) {
                locationInput.value = city;
                console.log('Filled city from IP lookup:', city);
            }
            if (lat && lon) {
                const nearest = findNearestLocation(Number(lat), Number(lon));
                if (nearest && locationInput) locationInput.value = nearest.name;
            }
            if (typeof window.loadVendorsForSelection === 'function') setTimeout(window.loadVendorsForSelection, 250);
            return true;
        })
        .catch(err => {
            console.warn('IP fallback failed', err);
            return false;
        });
}

//  ----------------------------

document.addEventListener("DOMContentLoaded", () => {
    const toggleButton = document.getElementById("toggleButto");
    const cityPopup = document.getElementById("cityPopup");
    const closePopup = document.getElementById("closePopup");
    const cityItems = document.querySelectorAll(".city-item") || [];
    const searchInput = document.getElementById("searchInput");
    const serviceBoxes = document.querySelectorAll(".service-box") || [];
    const servicesSection = document.querySelector(".services-section");
    const servicesHeading = servicesSection ? servicesSection.querySelector("h2") : null;

  // Popup message container
  const resultPopup = document.createElement("div");
  resultPopup.id = "resultPopup";
  resultPopup.style.position = "fixed";
  resultPopup.style.top = "50%";
  resultPopup.style.left = "50%";
  resultPopup.style.transform = "translate(-50%, -50%)";
  resultPopup.style.backgroundColor = "#f8d7da";
  resultPopup.style.color = "#721c24";
  resultPopup.style.padding = "20px";
  resultPopup.style.border = "1px solid #f5c6cb";
  resultPopup.style.borderRadius = "8px";
  resultPopup.style.boxShadow = "0px 4px 6px rgba(0, 0, 0, 0.1)";
  resultPopup.style.display = "none";
  resultPopup.style.zIndex = "9999";
  resultPopup.style.fontSize = "16px";
  document.body.appendChild(resultPopup);

    // Toggle popup visibility on toggle button click (guarded)
    if (toggleButton && cityPopup && cityPopup.classList) {
        toggleButton.addEventListener("click", () => {
            if (cityPopup.classList.contains("hidden")) {
                cityPopup.classList.remove("hidden");
            } else {
                cityPopup.classList.add("hidden");
            }
        });
    }

    // Close popup on close button click (guarded)
    if (closePopup && cityPopup && cityPopup.classList) {
        closePopup.addEventListener("click", () => {
            cityPopup.classList.add("hidden");
        });
    }

    // Fill city name in the search box when a city is clicked (guarded)
    if (cityItems && cityItems.length && searchInput) {
        cityItems.forEach((city) => {
            city.addEventListener("click", () => {
                const cityName = city.getAttribute("data-city");
                if (cityName && searchInput) searchInput.value = cityName;
                if (cityPopup && cityPopup.classList) cityPopup.classList.add("hidden");
            });
        });
    }

// Helper to extract a card's location text robustly
function getCardLocation(card) {
    const locEl = card.querySelector('.service-details .location') || card.querySelector('.service-details p:nth-child(3)');
    return (locEl ? locEl.innerText : '').trim();
}

// Helper to filter and show matching cards
function slugify(s){ return (s||'').toString().toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,''); }

function filterServiceCards(selectedService, locationName, serviceName) {
    const targetSlug = slugify(selectedService);
    const lcLocation = (locationName || '').toString().toLowerCase();
    const cards = document.querySelectorAll('.service-card');
    let foundMatch = false;
    cards.forEach((card) => card.classList.add('hidden'));
    cards.forEach((card) => {
        const cardServiceSlug = (card.dataset.serviceSlug || slugify(card.getAttribute('id') || '')).toString().toLowerCase();
        // try multiple sources for location: visible text, dataset.city, dataset.address
        const cardLocationRaw = getCardLocation(card) || card.dataset.city || card.dataset.address || '';
        const cardLocation = (cardLocationRaw || '').toString().toLowerCase();
        const serviceMatches = cardServiceSlug === targetSlug;
        const locationMatches = !lcLocation || (cardLocation && cardLocation.includes(lcLocation));
        if (serviceMatches && locationMatches) {
            card.classList.remove('hidden');
            foundMatch = true;
        }
    });
    if (foundMatch) {
        const header = document.querySelector('header');
        const headerHeight = header ? header.offsetHeight : 0;
        if (servicesSection) {
            const sectionTop = servicesSection.getBoundingClientRect().top + window.scrollY;
            const offsetPosition = sectionTop - headerHeight;
            window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
        }
    } else if (serviceName && locationName) {
        // Double-check: allow short delay for async loader to finish before showing message
        const maybeLoader = typeof window.loadVendorsForSelection === 'function' ? window.loadVendorsForSelection() : null;
        if (maybeLoader && typeof maybeLoader.then === 'function') {
            // If loader yields results later, don't show the message prematurely
            maybeLoader.then(list => {
                if (!Array.isArray(list) || list.length === 0) {
                    showPopup(`Currently we're unable to serve a ${serviceName} in ${locationName}. We'll serve soon. Stay tuned!`);
                }
            }).catch(() => showPopup(`Currently we're unable to serve a ${serviceName} in ${locationName}. We'll serve soon. Stay tuned!`));
        } else {
            showPopup(`Currently we're unable to serve a ${serviceName} in ${locationName}. We'll serve soon. Stay tuned!`);
        }
    }
}

// Show matching services when a service box is clicked
serviceBoxes.forEach((box) => {
    box.addEventListener("click", () => {
        const locationName = searchInput.value.trim();
        const selectedService = box.getAttribute("data-target");
        const serviceName = box.querySelector("span").textContent;

        if (!locationName) {
            showPopup("Please select a location first!");
            return;
        }

        // Update the heading with the selected service and location (guarded)
        if (servicesHeading) servicesHeading.textContent = `${serviceName} in ${locationName}`;

        // Run quick filter for static cards immediately
        filterServiceCards(selectedService, locationName, serviceName);
        // Trigger dashboard dynamic loader if present, then filter again when load completes
        if (typeof window.loadVendorsForSelection === 'function') {
            // call loader and after it resolves re-run filter so dynamic cards are included
            try {
                const p = window.loadVendorsForSelection();
                if (p && typeof p.then === 'function') {
                    p.then(() => filterServiceCards(selectedService, locationName, serviceName));
                } else {
                    // loader didn't return a promise - fallback timeout
                    setTimeout(() => filterServiceCards(selectedService, locationName, serviceName), 500);
                }
            } catch (e) {
                setTimeout(() => filterServiceCards(selectedService, locationName, serviceName), 500);
            }
        } else {
            // Fallback: re-run filter after a short delay to account for any async inserts
            setTimeout(() => filterServiceCards(selectedService, locationName, serviceName), 500);
        }
    });
});

  // Function to show popup messages
  function showPopup(message, bgColor = "#f8d7da", textColor = "#721c24") {
      resultPopup.textContent = message;
      resultPopup.style.backgroundColor = bgColor;
      resultPopup.style.color = textColor;
      resultPopup.style.display = "block";

      // Hide popup after 3 seconds
      setTimeout(() => {
          resultPopup.style.display = "none";
      }, 2500);
  }
});

// ---------------------------

function showButtons(card) {
    // Ensure we have a buttons container (create one if missing)
    const buttons = ensureButtonsContainer();
    if (!card) return;

    // If the buttons are already appended to this card, toggle visibility
    if (buttons && card.contains(buttons)) {
        buttons.classList.toggle('hidden');
        return;
    }

    // Remove buttons from any previous card and append to the current one
    document.querySelectorAll('.service-card').forEach(c => c.querySelector('.buttons')?.remove());
    if (buttons) {
        buttons.classList.remove('hidden');
        card.appendChild(buttons);
    }

    // Update common action buttons to target this specific card
    try {
        const cardId = card.getAttribute('data-card-id');
        if (cardId && buttons) {
            const btns = buttons.querySelectorAll('button');
            if (btns[0]) btns[0].setAttribute('onclick', `makeCall('${cardId}')`);
            if (btns[1]) btns[1].setAttribute('onclick', `openWhatsApp('${cardId}')`);
            if (btns[2]) btns[2].setAttribute('onclick', `openGoogleMaps('${cardId}')`);
        }
    } catch (e) { /* noop */ }
}

// Ensure a shared .buttons container exists, create minimal buttons if missing
function ensureButtonsContainer() {
    let buttons = document.querySelector('.buttons');
    if (buttons) return buttons;
    buttons = document.createElement('div');
    buttons.className = 'buttons hidden';
    buttons.style.position = 'absolute';
    buttons.style.zIndex = '9999';
    buttons.innerHTML = `
        <button type="button">Call</button>
        <button type="button">WhatsApp</button>
        <button type="button">Directions</button>
    `;
    document.body.appendChild(buttons);
    return buttons;
}

// ------------------------------------

 // Example details for each card
 const cardDetails = {
   
};

document.addEventListener("DOMContentLoaded", function () {
    let activeCard = null; // Keep track of the currently selected card

    // Select all service cards
    document.querySelectorAll(".service-card").forEach(card => {
        card.addEventListener("click", function () {
            const cardId = card.getAttribute("data-card-id");
            const buttonsContainer = document.querySelector(".buttons");

            // If the same card is clicked again, toggle visibility
            if (activeCard === cardId) {
                buttonsContainer.classList.add("hidden"); // Hide buttons
                activeCard = null; // Reset active card
            } else {
                // Update the common buttons' functionality
                buttonsContainer.querySelector("button:nth-child(1)").setAttribute("onclick", `makeCall('${cardId}')`);
                buttonsContainer.querySelector("button:nth-child(2)").setAttribute("onclick", `openWhatsApp('${cardId}')`);
                buttonsContainer.querySelector("button:nth-child(3)").setAttribute("onclick", `openGoogleMaps('${cardId}')`);

                // Show buttons
                buttonsContainer.classList.remove("hidden");
                activeCard = cardId; // Set the clicked card as active
            }
        });
    });
});

// Function to make a call
function makeCall(cardId) {
    let phoneNumber = cardDetails[cardId]?.contact;
    if (!phoneNumber) {
        const cardEl = document.querySelector(`.service-card[data-card-id="${cardId}"]`);
        phoneNumber = cardEl?.dataset.contact || "";
    }
    if (phoneNumber) {
        window.location.href = `tel:${phoneNumber}`;
    } else {
        alert("Phone number not available.");
    }
}

// Function to open WhatsApp chat
function openWhatsApp(cardId) {
    let phoneNumber = cardDetails[cardId]?.contact || "";
    if (!phoneNumber) {
        const cardEl = document.querySelector(`.service-card[data-card-id="${cardId}"]`);
        phoneNumber = cardEl?.dataset.contact || "";
    }
    if (phoneNumber) {
        window.location.href = `https://wa.me/${phoneNumber.replace("+", "")}`;
    } else {
        alert("WhatsApp number not available.");
    }
}

// Function to open Google Maps for directions
function openGoogleMaps(cardId) {
    let address = cardDetails[cardId]?.address || "";
    if (!address) {
        const cardEl = document.querySelector(`.service-card[data-card-id="${cardId}"]`);
        address = cardEl?.dataset.address || "";
    }
    if (address) {
        const encodedAddress = encodeURIComponent(address);
        window.open(`https://www.google.com/maps/search/?api=1&query=${encodedAddress}`, "_blank");
    } else {
        alert("Address not available.");
    }
}

function showDetails(event, button) {
  event.stopPropagation(); // Prevent parent click event

  // Get the parent card
  const card = button.closest('.service-card');
  const cardId = card.getAttribute('data-card-id'); // Fetch unique card identifier

  // Get the details section within the card
  const detailsDiv = card.querySelector('.details');

  // Check if details are already visible
  if (!detailsDiv.classList.contains('hidden')) {
      detailsDiv.classList.add('hidden');
      detailsDiv.innerHTML = ""; // Clear the details
  } else {
      // Populate details dynamically (fallback to dataset for dynamic vendor cards)
      let details = cardDetails[cardId];
      if (!details) {
          try {
              const addr = card.dataset.address || '';
              const services = card.dataset.services ? JSON.parse(card.dataset.services) : [];
              details = { address: addr, services };
          } catch (_) { /* noop */ }
      }

      if (details) {
          detailsDiv.innerHTML = `
              <div class="address">
                  <p><b>Address:</b></p>
                  <p>${details.address || 'Not available'}</p>
              </div>
              <div class="services">
                  <h3>Services</h3>
                  <ul>
                      ${(details.services || []).map(service => `<li><i class=\"fas fa-check-circle\"></i> ${service}</li>`).join('')}
                  </ul>
              </div>
          `;
          detailsDiv.classList.remove('hidden');
      } else {
          detailsDiv.innerHTML = `<p>Details not available.</p>`;
          detailsDiv.classList.remove('hidden');
      }
  }
}
