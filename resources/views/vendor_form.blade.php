<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Become a Vendor | BookingYard</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --primary: #0077b6;       /* Brand Blue */
            --primary-dark: #023e8a;
            --bg-body: #f1f5f9;       /* Slate 100 */
            --bg-card: #ffffff;
            --text-main: #0f172a;     /* Slate 900 */
            --text-muted: #64748b;    /* Slate 500 */
            --border: #e2e8f0;
            --danger: #ef4444;
            --success: #10b981;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* --- Layout --- */
        .wrap {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-title { font-size: 1.75rem; font-weight: 700; color: var(--text-main); margin: 0; }
        .header-sub { color: var(--text-muted); margin-top: 8px; font-size: 1rem; }

        .layout-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: start;
        }

        /* --- Cards --- */
        .card {
            background: var(--bg-card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            padding: 30px;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }
        
        .step-badge {
            background: var(--primary);
            color: white;
            width: 28px; height: 28px;
            border-radius: 50%;
            display: grid; place-items: center;
            font-size: 0.85rem;
            font-weight: 700;
        }

        /* --- Form Elements --- */
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 20px; }
        
        label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: #334155;
        }
        .req { color: var(--danger); }
        .hint { font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; display: block; }

        /* Input with Icon Wrapper */
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 0.95rem; pointer-events: none;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 16px 12px 42px; /* Left padding for icon */
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--text-main);
            background: #fff;
            transition: all 0.2s ease;
        }
        /* Style for inputs without icons */
        .no-icon input, .no-icon select, .no-icon textarea { padding-left: 14px; }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.1);
        }

        /* --- Image Dropzone --- */
        .dropzone {
            border: 2px dashed var(--border);
            border-radius: 12px;
            background: #f8fafc;
            padding: 24px;
            text-align: center;
            position: relative;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 160px;
        }
        .dropzone:hover { border-color: var(--primary); background: #eff6ff; }
        
        .dropzone-input { position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; }
        
        .preview-area img {
            max-width: 100%; max-height: 140px; border-radius: 8px; object-fit: contain;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .upload-placeholder i { font-size: 2rem; color: var(--primary); margin-bottom: 8px; }
        .upload-placeholder p { margin: 0; font-weight: 600; font-size: 0.9rem; }

        /* --- Buttons --- */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem;
            cursor: pointer; border: none; transition: 0.2s;
        }
        .btn-primary { background: var(--primary); color: white; width: 100%; box-shadow: 0 4px 6px rgba(0, 119, 182, 0.2); }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        
        .btn-outline { background: white; border: 1px solid var(--border); color: var(--text-main); }
        .btn-outline:hover { background: #f8fafc; border-color: #cbd5e1; }

        .btn-sm { padding: 8px 14px; font-size: 0.85rem; height: 100%; }

        /* --- Chips for Other Services --- */
        .chip-container { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
        .chip {
            background: #e0f2fe; color: #0369a1;
            padding: 6px 12px; border-radius: 20px;
            font-size: 0.85rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .chip-remove {
            background: rgba(255,255,255,0.5); border: none;
            width: 18px; height: 18px; border-radius: 50%;
            display: grid; place-items: center; cursor: pointer; color: #0369a1;
        }
        .chip-remove:hover { background: #fff; color: #dc2626; }

        /* --- Sticky Sidebar --- */
        .sticky-sidebar {
            position: sticky;
            top: 20px;
        }
        .progress-box { background: var(--bg-card); padding: 20px; border-radius: var(--radius); border: 1px solid var(--border); }
        .progress-header { display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 700; font-size: 0.9rem; }
        .progress-bar-bg { width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 100%; background: var(--success); width: 0%; transition: width 0.4s ease; }
        
        .tip-list { list-style: none; padding: 0; margin: 16px 0 0; }
        .tip-list li {
            position: relative; padding-left: 24px; margin-bottom: 12px; font-size: 0.85rem; color: var(--text-muted); line-height: 1.4;
        }
        .tip-list li::before {
            content: '\f0eb'; font-family: 'Font Awesome 6 Free'; font-weight: 400;
            position: absolute; left: 0; top: 2px; color: #eab308;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .layout-grid { grid-template-columns: 1fr; }
            .sticky-sidebar { order: -1; position: relative; top: 0; margin-bottom: 20px; }
            .form-grid-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
    <div class="wrap">
        
        <!-- Header -->
        <div class="header-section">
            <h1 class="header-title">Create Vendor Profile</h1>
            <div class="header-sub">Setup your business profile to start receiving bookings.</div>
        </div>

        <div class="layout-grid">
            
            <!-- Main Form Column -->
            <form id="serviceForm" method="POST" action="{{ route('vendor.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- 1. Basic Details -->
                <div class="card">
                    <h2 class="section-title"><span class="step-badge">1</span> Business Details</h2>
                    
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label>Service / Business Name <span class="req">*</span></label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-store input-icon"></i>
                                <input type="text" id="serviceName" name="service_name" placeholder="e.g. Rahul's Electricals" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tagline <span class="hint">(Optional)</span></label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-tag input-icon"></i>
                                <input type="text" id="subtitle" name="subtitle" placeholder="e.g. Best service in town" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group no-icon">
                        <label>Short Description</label>
                        <textarea id="serviceDescription" name="description" rows="3" placeholder="Describe your experience and specialties..."></textarea>
                    </div>

                    <div class="form-group no-icon">
                        <label>Cover Image <span class="req">*</span></label>
                        <div class="dropzone" id="dropzoneArea">
                            <input type="file" id="serviceImage" name="image" accept="image/*" class="dropzone-input" />
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <p>Click or Drag image here</p>
                                <span class="hint">JPG, PNG or WebP (Max 2MB)</span>
                            </div>
                            <div class="preview-area" id="imagePreview" style="display:none;"></div>
                        </div>
                    </div>
                </div>

                <!-- 2. Location -->
                <div class="card">
                    <h2 class="section-title"><span class="step-badge">2</span> Location & Area</h2>
                    
                    <div class="form-group">
                        <label>Pincode <span class="req">*</span></label>
                        <div style="display: flex; gap: 10px;">
                            <div class="input-wrap" style="flex:1;">
                                <i class="fa-solid fa-map-pin input-icon"></i>
                                <input type="text" id="pinCode" name="pin_code" placeholder="110001" maxlength="6" inputmode="numeric" required />
                            </div>
                            <button type="button" class="btn btn-outline btn-sm" id="fetchLocationBtn">
                                <i class="fa-solid fa-location-crosshairs"></i> Detect
                            </button>
                        </div>
                        <span class="hint" id="pincodeHint">Enter PIN to auto-fill City & State.</span>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label>City</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-city input-icon"></i>
                                <input type="text" id="city" name="city" readonly style="background:#f8fafc;" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-flag input-icon"></i>
                                <input type="text" id="state" name="state" readonly style="background:#f8fafc;" />
                            </div>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label>Area / Locality</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-building input-icon"></i>
                                <input type="text" id="area" name="area" placeholder="e.g. Connaught Place" list="areaSuggestions" />
                                <datalist id="areaSuggestions"></datalist>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Street / Landmark</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-road input-icon"></i>
                                <input type="text" id="street" name="street" placeholder="e.g. Near Metro Station" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Service Details -->
                <div class="card">
                    <h2 class="section-title"><span class="step-badge">3</span> Services & Pricing</h2>
                    
                    <div class="form-grid-2">
                        <div class="form-group no-icon">
                            <label>Category <span class="req">*</span></label>
                            <select id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="Home Service">Home Service</option>
                                <option value="Event">Event</option>
                                <option value="Cabs">Cabs</option>
                                <option value="Hotels">Hotels</option>
                                <option value="Working Professionals">Working Professionals</option>
                            </select>
                        </div>
                        <div class="form-group no-icon">
                            <label>Primary Service <span class="req">*</span></label>
                            <select id="service" name="service" required>
                                <option value="">Select Service</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label>Base Price (₹)</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-indian-rupee-sign input-icon"></i>
                                <input type="number" id="basePrice" name="base_price" placeholder="500" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Discount (%)</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-percent input-icon"></i>
                                <input type="number" id="discountPercent" name="discount_percent" placeholder="0" max="100" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Additional Services <span class="hint">(Tags)</span></label>
                        <div style="display:flex; gap:10px;">
                            <div class="input-wrap" style="flex:1;">
                                <i class="fa-solid fa-plus input-icon"></i>
                                <input type="text" id="otherServiceInput" placeholder="Type and press Add" />
                            </div>
                            <button type="button" class="btn btn-outline btn-sm" id="addOtherServiceBtn">Add</button>
                        </div>
                        <div id="otherServicesList" class="chip-container"></div>
                    </div>
                </div>

                <!-- 4. Contact -->
                <div class="card">
                    <h2 class="section-title"><span class="step-badge">4</span> Contact Info</h2>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label>Phone Number <span class="req">*</span></label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-phone input-icon"></i>
                                <input type="tel" id="contactNumber" name="contact_number" required placeholder="9876543210" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>WhatsApp <span class="hint">(Optional)</span></label>
                            <div class="input-wrap">
                                <i class="fa-brands fa-whatsapp input-icon"></i>
                                <input type="tel" id="whatsappNumber" name="whatsapp_number" placeholder="9876543210" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" required placeholder="you@example.com" />
                        </div>
                    </div>
                </div>

                <!-- Submit Action -->
                <div style="display:flex; gap:16px; margin-bottom:40px;">
                    <button type="submit" class="btn btn-primary">Create Vendor Profile</button>
                    <button type="button" class="btn btn-outline" onclick="history.back()">Cancel</button>
                </div>
                
                <!-- Hidden Location Inputs -->
                <input type="hidden" name="latitude" id="latitude" />
                <input type="hidden" name="longitude" id="longitude" />
            </form>

            <!-- Sidebar: Sticky Progress -->
            <aside class="sticky-sidebar">
                <div class="progress-box">
                    <div class="progress-header">
                        <span>Profile Strength</span>
                        <span id="completeness">0%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-fill" id="completenessBar"></div>
                    </div>
                    
                    <ul class="tip-list">
                        <li><strong>High quality images</strong> attract 3x more customers.</li>
                        <li><strong>Accurate Pincode</strong> helps local customers find you easily.</li>
                        <li><strong>Discounts</strong> help you stand out from competitors.</li>
                    </ul>
                </div>
            </aside>

        </div>
    </div>

    <script>
        // --- 1. Category & Service Logic ---
        const category = document.getElementById('category');
        const service = document.getElementById('service');
        const serviceOptions = {
            'Home Service': ['Plumber','Electrician','Cleaner','Gardener','Painter','Carpenter','Pest Control'],
            'Event': ['Sound System','Photographer','Catering','Decorator','Tent House','DJ'],
            'Cabs': ['Bike Taxi','Auto','Car Rental','SUV','Bus','Driver'],
            'Rental': ['3BHK','2BHK','1BHK', 'GuestHouse', 'PG', 'Others'],
            'Working Professionals': ['Lawyer','CA','Tutor','Yoga Instructor','Beautician']
        };

        category.addEventListener('change', () => {
            const selected = category.value;
            service.innerHTML = '<option value="">Select Service</option>';
            if (serviceOptions[selected]) {
                serviceOptions[selected].forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s; opt.textContent = s;
                    service.appendChild(opt);
                });
            }
            updateCompleteness();
        });

        // --- 2. Image Upload Logic ---
        const serviceImage = document.getElementById('serviceImage');
        const imagePreview = document.getElementById('imagePreview');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');

        serviceImage.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = evt => {
                    imagePreview.innerHTML = `<img src="${evt.target.result}" alt="Preview">`;
                    imagePreview.style.display = 'block';
                    uploadPlaceholder.style.display = 'none';
                    updateCompleteness();
                };
                reader.readAsDataURL(file);
            }
        });

        // --- 3. Location Fetch Logic ---
        const pinCodeInput = document.getElementById('pinCode');
        const cityInput = document.getElementById('city');
        const stateInput = document.getElementById('state');
        const areaSuggestions = document.getElementById('areaSuggestions');
        const fetchLocationBtn = document.getElementById('fetchLocationBtn');
        const pincodeHint = document.getElementById('pincodeHint');

        pinCodeInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').slice(0,6); // Numbers only
            if(this.value.length === 6) fetchPincodeDetails(this.value);
        });

        function fetchPincodeDetails(pin) {
            pincodeHint.textContent = 'Searching...';
            pincodeHint.style.color = 'var(--primary)';
            
            fetch(`https://api.postalpincode.in/pincode/${pin}`)
                .then(r => r.json())
                .then(data => {
                    if (data[0].Status === 'Success') {
                        const office = data[0].PostOffice[0];
                        cityInput.value = office.District;
                        stateInput.value = office.State;
                        
                        // Populate Area Datalist
                        areaSuggestions.innerHTML = '';
                        data[0].PostOffice.forEach(o => {
                            const opt = document.createElement('option');
                            opt.value = o.Name;
                            areaSuggestions.appendChild(opt);
                        });
                        
                        pincodeHint.textContent = `Found: ${office.District}, ${office.State}`;
                        pincodeHint.style.color = 'var(--success)';
                        updateCompleteness();
                    } else {
                        pincodeHint.textContent = 'Invalid Pincode';
                        pincodeHint.style.color = 'var(--danger)';
                    }
                })
                .catch(() => { pincodeHint.textContent = 'Error fetching details'; });
        }

        fetchLocationBtn.addEventListener('click', () => {
            if (!navigator.geolocation) return alert('Geolocation not supported');
            
            const originalText = fetchLocationBtn.innerHTML;
            fetchLocationBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            fetchLocationBtn.disabled = true;

            navigator.geolocation.getCurrentPosition(async (pos) => {
                const { latitude, longitude } = pos.coords;
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;

                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`);
                    const data = await res.json();
                    const addr = data.address;

                    if(addr.postcode) {
                        pinCodeInput.value = addr.postcode.replace(/\D/g,''); // clean pin
                        fetchPincodeDetails(pinCodeInput.value);
                    }
                    if(addr.city || addr.town) cityInput.value = addr.city || addr.town;
                    if(addr.state) stateInput.value = addr.state;
                    
                } catch(e) { console.error(e); }
                
                fetchLocationBtn.innerHTML = originalText;
                fetchLocationBtn.disabled = false;
            }, () => {
                alert('Location permission denied.');
                fetchLocationBtn.innerHTML = originalText;
                fetchLocationBtn.disabled = false;
            });
        });

        // --- 4. Tags / Other Services ---
        const otherInput = document.getElementById('otherServiceInput');
        const addBtn = document.getElementById('addOtherServiceBtn');
        const list = document.getElementById('otherServicesList');

        addBtn.addEventListener('click', addTag);
        otherInput.addEventListener('keypress', (e) => { if(e.key === 'Enter') { e.preventDefault(); addTag(); } });

        function addTag() {
            const val = otherInput.value.trim();
            if(!val) return;
            
            const chip = document.createElement('div');
            chip.className = 'chip';
            chip.innerHTML = `<span>${val}</span><button type="button" class="chip-remove"><i class="fa-solid fa-xmark"></i></button>`;
            
            chip.querySelector('.chip-remove').onclick = () => chip.remove();
            
            // Hidden input for form submission
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'other_services[]';
            hidden.value = val;
            chip.appendChild(hidden);

            list.appendChild(chip);
            otherInput.value = '';
        }

        // --- 5. Completeness Meter ---
        function updateCompleteness() {
            let score = 0;
            // Weighted fields
            if(document.getElementById('serviceName').value) score += 15;
            if(document.getElementById('serviceDescription').value) score += 10;
            if(imagePreview.innerHTML) score += 20;
            if(pinCodeInput.value.length === 6) score += 15;
            if(document.getElementById('city').value) score += 5;
            if(category.value) score += 10;
            if(service.value) score += 10;
            if(document.getElementById('contactNumber').value) score += 15;

            const finalScore = Math.min(score, 100) + '%';
            document.getElementById('completeness').textContent = finalScore;
            document.getElementById('completenessBar').style.width = finalScore;
        }

        // Monitor inputs for progress
        document.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('input', updateCompleteness);
            el.addEventListener('change', updateCompleteness);
        });
    </script>
</body>
</html>