<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Service Profile | BookingYard</title>
  
  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <style>
    :root {
      --brand: #0077b6;
      --brand-hover: #023e8a;
      --bg-body: #f8fafc;
      --bg-surface: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border: #e2e8f0;
      --shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
      --radius: 12px;
    }

    * { box-sizing: border-box; }
    
    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg-body);
      color: var(--text-main);
      margin: 0;
      padding-bottom: 60px;
    }

    /* --- Navigation (Consistent with Dashboard) --- */
    header { background: #1e293b; color: white; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; }
    .brand-area { display: flex; align-items: center; gap: 10px; font-weight: 700; }
    .nav-btn { color: rgba(255,255,255,0.8); text-decoration: none; font-size: 0.9rem; transition: 0.2s; }
    .nav-btn:hover { color: white; }

    /* --- Layout --- */
    .container {
      max-width: 850px;
      margin: 30px auto;
      padding: 0 20px;
    }

    .page-header {
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .page-title { margin: 0; font-size: 1.5rem; font-weight: 700; color: var(--text-main); }
    .breadcrumb { color: var(--text-muted); font-size: 0.9rem; margin-top: 4px; }

    /* --- Forms & Cards --- */
    .form-card {
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      overflow: hidden;
      margin-bottom: 24px;
    }

    .card-header {
      background: #f8fafc;
      padding: 16px 24px;
      border-bottom: 1px solid var(--border);
      font-weight: 600;
      color: var(--text-main);
      display: flex; align-items: center; gap: 10px;
    }
    .card-header i { color: var(--brand); }

    .card-body { padding: 24px; }

    /* Grid System for Inputs */
    .row-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    
    .form-group { margin-bottom: 20px; }
    .form-group:last-child { margin-bottom: 0; }
    
    label { display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 8px; color: #334155; }
    
    /* Input Styling */
    .input-wrap { position: relative; }
    .input-icon {
      position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
      color: var(--text-muted); font-size: 0.9rem;
    }
    
    input, textarea, select {
      width: 100%;
      padding: 12px 14px 12px 40px; /* Space for icon */
      border: 1px solid var(--border);
      border-radius: 8px;
      font-family: inherit;
      font-size: 0.95rem;
      color: var(--text-main);
      transition: all 0.2s;
      background: #fff;
    }
    input:focus, textarea:focus {
      outline: none;
      border-color: var(--brand);
      box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.1);
    }
    /* Standard padding for inputs without icons */
    .no-icon input, .no-icon textarea { padding-left: 14px; }

    /* --- Custom File Upload (Dropzone Style) --- */
    .file-upload-wrapper {
      position: relative;
      border: 2px dashed var(--border);
      border-radius: 12px;
      background: #f8fafc;
      padding: 30px;
      text-align: center;
      transition: 0.2s;
    }
    .file-upload-wrapper:hover { border-color: var(--brand); background: #eff6ff; }
    
    .file-input {
      position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;
    }
    .upload-icon { font-size: 2rem; color: var(--brand); margin-bottom: 10px; }
    .upload-text { font-weight: 600; color: var(--text-main); }
    .upload-hint { font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; }

    /* --- Action Buttons --- */
    .form-actions {
      display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;
    }
    .btn {
      padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-primary { background: var(--brand); color: white; transition: 0.2s; }
    .btn-primary:hover { background: var(--brand-hover); box-shadow: 0 4px 12px rgba(0, 119, 182, 0.2); }
    .btn-secondary { background: white; border: 1px solid var(--border); color: var(--text-main); }
    .btn-secondary:hover { background: #f1f5f9; }

    /* Responsive */
    @media(max-width: 768px) {
      .row-grid { grid-template-columns: 1fr; }
      .form-actions { flex-direction: column-reverse; }
      .btn { width: 100%; justify-content: center; }
    }
  </style>
</head>
<body>

  <!-- Top Nav (Simplified for Edit Page) -->
  <header>
    <div class="brand-area">
      <i class="fa-solid fa-shapes"></i> Vendor Panel
    </div>
    <a href="{{ route('vendor.dashboard') }}" class="nav-btn">
      <i class="fa-solid fa-xmark"></i> Close
    </a>
  </header>

  <div class="container">
    
    <!-- Page Header -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Edit Service Profile</h1>
        <div class="breadcrumb">Update your service details and public information</div>
      </div>
    </div>

    <!-- Submit to the specific vendor update route when editing a vendor, otherwise use profile fallback -->
    @if(isset($vendor) && isset($vendor->id))
      <form method="POST" action="{{ route('vendor.update', $vendor) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    @else
      <form method="POST" action="{{ route('vendor.profile.post') }}" enctype="multipart/form-data">
        @csrf
    @endif

      <!-- Section 1: Basic Information -->
      <div class="form-card">
        <div class="card-header"><i class="fa-regular fa-id-card"></i> Service Details</div>
        <div class="card-body">
          <div class="row-grid">
            <div class="form-group">
              <label>Service Name (Business Name)</label>
              <div class="input-wrap">
                <i class="fa-solid fa-store input-icon"></i>
                <input type="text" name="service_name" value="{{ old('service_name', $vendor->service_name) }}" required placeholder="e.g. Rahul's Plumbing">
              </div>
            </div>
            <div class="form-group">
              <label>Tagline / Subtitle</label>
              <div class="input-wrap">
                <i class="fa-solid fa-tag input-icon"></i>
                <input type="text" name="subtitle" value="{{ old('subtitle', $vendor->subtitle) }}" placeholder="e.g. Expert repairs in 30 mins">
              </div>
            </div>
          </div>
          <div class="form-group no-icon">
            <label>Description</label>
            <textarea name="description" rows="4" placeholder="Tell customers about your experience and specialties...">{{ old('description', $vendor->description) }}</textarea>
          </div>
        </div>
      </div>

      <!-- Section 2: Pricing & Image -->
      <div class="row-grid">
        <!-- Pricing Card -->
        <div class="form-card">
          <div class="card-header"><i class="fa-solid fa-indian-rupee-sign"></i> Pricing</div>
          <div class="card-body">
            <div class="form-group">
              <label>Base Price (Starting from)</label>
              <div class="input-wrap">
                <i class="fa-solid fa-indian-rupee-sign input-icon"></i>
                <input type="number" min="0" name="base_price" value="{{ old('base_price', $vendor->base_price) }}" placeholder="0.00">
              </div>
            </div>
            <div class="form-group">
              <label>Discount Percentage</label>
              <div class="input-wrap">
                <i class="fa-solid fa-percent input-icon"></i>
                <input type="number" min="0" max="100" name="discount_percent" value="{{ old('discount_percent', $vendor->discount_percent) }}" placeholder="0">
              </div>
            </div>
          </div>
        </div>

        <!-- Image Upload Card -->
        <div class="form-card">
          <div class="card-header"><i class="fa-regular fa-image"></i> Cover Image</div>
          <div class="card-body">
            <div class="file-upload-wrapper">
              <input type="file" name="image" accept="image/*" class="file-input">
              <div class="upload-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
              <div class="upload-text">Click to upload image</div>
              <div class="upload-hint">SVG, PNG, JPG or GIF (Max. 2MB)</div>
            </div>
            @if($vendor->image_url)
              <div style="margin-top:10px; font-size:0.85rem; color:#16a34a;">
                <i class="fa-solid fa-check"></i> Current image active
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Section 3: Location -->
      <div class="form-card">
        <div class="card-header"><i class="fa-solid fa-map-location-dot"></i> Service Location</div>
        <div class="card-body">
          <div class="row-grid">
            <div class="form-group">
              <label>Street / Building</label>
              <div class="input-wrap">
                <i class="fa-solid fa-road input-icon"></i>
                <input name="street" value="{{ old('street', $vendor->street) }}">
              </div>
            </div>
            <div class="form-group">
              <label>Area / Locality</label>
              <div class="input-wrap">
                <i class="fa-solid fa-map-pin input-icon"></i>
                <input name="area" value="{{ old('area', $vendor->area) }}">
              </div>
            </div>
            <div class="form-group">
              <label>Landmark</label>
              <div class="input-wrap">
                <i class="fa-solid fa-monument input-icon"></i>
                <input name="landmark" value="{{ old('landmark', $vendor->landmark) }}">
              </div>
            </div>
            <div class="form-group">
              <label>City</label>
              <div class="input-wrap">
                <i class="fa-solid fa-city input-icon"></i>
                <input name="city" value="{{ old('city', $vendor->city) }}">
              </div>
            </div>
            <div class="form-group">
              <label>State</label>
              <div class="input-wrap">
                <i class="fa-solid fa-flag input-icon"></i>
                <input name="state" value="{{ old('state', $vendor->state) }}">
              </div>
            </div>
            <div class="form-group">
              <label>Pincode</label>
              <div class="input-wrap">
                <i class="fa-solid fa-hashtag input-icon"></i>
                <input name="pin_code" value="{{ old('pin_code', $vendor->pin_code) }}">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="form-actions">
        <a href="{{ route('vendor.dashboard') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-check"></i> Save Changes
        </button>
      </div>

    </form>
  </div>
</body>
</html>