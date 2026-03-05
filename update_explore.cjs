const fs = require('fs');

let file = 'resources/views/explore.blade.php';
let content = fs.readFileSync(file, 'utf8');

// Insert a container for vendors and script to fetch them
let HTML_INSERT = `
    <!-- Dynamic Vendors Rendered Here -->
    <h3 style="margin-top: 25px; padding-bottom: 10px; border-bottom: 2px solid #eef9ff; color: #1e293b;">Available Services Near You</h3>
    <div id="explore-vendors-container" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:20px; margin-top: 15px; margin-bottom: 40px;">
    </div>
    
    <!-- Status Modal / Toasts -->
    <div id="booking-toast" style="display:none; position:fixed; bottom:20px; right:20px; background:#10b981; color:#fff; padding:12px 24px; border-radius:8px; box-shadow:0 10px 15px -3px rgba(0,0,0,0.1); z-index:9999;"></div>

`;

content = content.replace('</div> <!-- End categories-container -->', `</div> <!-- End categories-container -->\n${HTML_INSERT}`);

let SCRIPT_INSERT = `
  <script>
    async function fetchVendorsAndRender() {
       const city = document.getElementById('searchInput')?.value || '';
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

       let url = '/vendors/search?city=' + encodeURIComponent(city) + '&category=' + encodeURIComponent(category);
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
               return \`
               <div style="background:#fff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display:flex; flex-direction:column;">
                   <div style="height:160px; background:#f1f5f9; position:relative;">
                       <img src="\${v.image || '/image/Booking.jpg'}" style="width:100%; height:100%; object-fit:cover;">
                       \${v.discount ? \`<span style="position:absolute; top:10px; left:10px; background:#ef4444; color:#fff; font-size:12px; font-weight:bold; padding:4px 8px; border-radius:4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">\${v.discount}% OFF</span>\` : ''}
                   </div>
                   <div style="padding: 16px; flex:1; display:flex; flex-direction:column;">
                       <h4 style="margin: 0 0 6px 0; color: #1e293b; font-size: 1.1rem; line-height:1.2;">\${v.title}</h4>
                       <div style="color: #64748b; font-size: 0.85rem; margin-bottom: 12px;">\${v.city}, \${v.area}</div>
                       
                       <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 15px; background: #f8fafc; padding:8px; border-radius:8px;">
                           <div>
                               <div style="font-size: 0.75rem; color: #64748b;">Starting from</div>
                               <div style="font-weight: bold; color: #0077b6; font-size: 1.1rem;">₹\${v.price || '--'}</div>
                           </div>
                           <div style="text-align:right;">
                               <div style="font-size: 0.75rem; color: #64748b;">Rating</div>
                               <div style="font-weight: bold; color: #1e293b; display:flex; align-items:center; gap:4px; justify-content:flex-end;">
                                   <i class="fas fa-star" style="color:#eab308; font-size:0.8rem;"></i> \${v.rating || 'New'}
                               </div>
                           </div>
                       </div>
                       
                       <div style="margin-top:auto;">
                           <button onclick="bookVendor(\${v.id}, '\${v.title.replace(/'/g, "\\'")}', '\${(v.price||0)}')" style="width:100%; padding:12px; background:#0ea5e9; color:#fff; border:none; border-radius:8px; font-weight:600; font-size:1rem; cursor:pointer; transition:0.2s;" onmouseover="this.style.background='#0284c7'" onmouseout="this.style.background='#0ea5e9'">
                               Book Now
                           </button>
                       </div>
                   </div>
               </div>
               \`;
           }).join('');

           container.innerHTML = html;
       } catch (err) {
           console.error(err);
       }
    }

    async function bookVendor(vendorId, serviceName, basePrice) {
        // Need to ask user for schedule date/time using a simple prompt
        const dateStr = prompt(\`Booking \${serviceName}\\nWhen do you need this service? (YYYY-MM-DD HH:MM)\`, new Date().toISOString().slice(0,16).replace('T',' '));
        if (!dateStr) return; // User cancelled

        const notes = prompt(\`Any special request or notes? (Optional)\`, '');

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
        if (s) {
            s.addEventListener('change', fetchVendorsAndRender);
        }

        // Load initially
        setTimeout(fetchVendorsAndRender, 300);
    });
  </script>
`;

content = content.replace('</body>', `${SCRIPT_INSERT}\n</body>`);

fs.writeFileSync(file, content, 'utf8');
console.log('explore.blade.php updated!');
