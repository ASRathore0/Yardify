<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor Services</title>
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#f8fafc;margin:0;color:#0f172a}
    .wrap{max-width:980px;margin:18px auto;padding:12px}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 2px 12px rgba(2,8,23,.04);padding:12px}

    /* Layout */
    .two-col-grid{display:grid;grid-template-columns:1fr 340px;gap:16px;align-items:start}
    .card-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;margin-top:6px}

    /* Card menu */
    .card-menu { position:absolute; top:10px; right:10px; z-index:30; }
    .menu-button { background: rgba(255,255,255,0.9); border:1px solid #e6eef6; width:34px; height:34px; border-radius:50%; display:grid; place-items:center; cursor:pointer; }
    .menu-dropdown { position:absolute; top:44px; right:0; background:#fff; border:1px solid #e6eef6; box-shadow:0 6px 18px rgba(2,8,23,.08); border-radius:8px; display:none; min-width:140px; }
    .menu-dropdown.show{ display:block; }
    .menu-dropdown form, .menu-dropdown a { display:block; padding:8px 12px; color:#0f172a; text-decoration:none; }
    .menu-dropdown form button{ background:none;border:none;color:#0f172a;padding:0;margin:0;text-align:left;width:100%;cursor:pointer }
    .menu-dropdown a:hover, .menu-dropdown form button:hover{ background:#f8fafc }

    /* Service card */
    .service-card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;overflow:hidden;box-shadow:0 6px 18px rgba(2,8,23,.06);display:flex;flex-direction:column}
    .service-image{position:relative;height:140px;overflow:hidden;background:#f3f4f6;display:flex;align-items:center;justify-content:center}
    .service-image img{width:100%;height:100%;object-fit:cover;display:block}
    .service-body{padding:12px;display:flex;flex-direction:column;gap:8px}
    .service-actions{display:flex;gap:8px;align-items:center}
    .service-actions form input{padding:8px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px}

    /* Profile preview */
    .profile-wrapper{margin-top:12px}
    .profile-card .profile-img{width:100%;height:160px;object-fit:cover;display:block}

    /* Buttons */
    .btn{border:none;padding:8px 10px;border-radius:8px;font-weight:800;cursor:pointer}
    .btn-save{background:#10b981;color:#fff}
    .btn-delete{background:#ef4444;color:#fff}
    .btn-add{background:#0ea5e9;color:#fff;padding:10px 14px;border-radius:10px}

    /* Small screens */
    @media (max-width:800px){
      .two-col-grid{grid-template-columns:1fr}
      .card-grid{grid-template-columns:1fr}
      .service-image{height:180px}
      .service-actions{flex-direction:column;align-items:stretch}
      .service-actions form{width:100%;display:flex}
      .service-actions form input{flex:1;width:100%}
      .service-actions form button{margin-top:0}
      .profile-wrapper{margin-top:6px}
      .wrap{padding:10px}
    }
  </style>
</head>
<body>
  @include('vendor.partials.nav')
  <div class="wrap">
    <div>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
        <h2 style="margin:0;">Your Businesses</h2>
        <a href="{{ route('vendor.form') }}" class="btn btn-add" style="text-decoration:none;">Add Business</a>
      </div>

      @if(isset($vendors) && $vendors->count())
        <div class="card-grid">
          @foreach($vendors as $vendor)
            <div class="service-card" style="position:relative;">
              <div class="card-menu">
                <div class="menu-button" onclick="this.nextElementSibling.classList.toggle('show')">⋯</div>
                <div class="menu-dropdown" aria-hidden="true">
                  <a href="{{ route('vendor.edit', $vendor) }}">Edit</a>
                  <form method="POST" action="{{ route('vendor.destroy', $vendor) }}" class="confirm-delete" data-vendor-name="{{ addslashes($vendor->service_name) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                  </form>
                </div>
              </div>
              <div class="service-image">
                <img src="{{ $vendor->image_url ?? asset('image/Booking.jpg') }}" alt="{{ $vendor->service_name }}">
                @if($vendor->discount_percent)
                  <div style="position:absolute;left:12px;top:12px;background:#ef4444;color:#fff;padding:6px 10px;border-radius:18px;font-weight:700;font-size:12px;">FLAT {{ $vendor->discount_percent }}% OFF</div>
                @endif
              </div>
              <div class="service-body">
                <div style="display:flex;justify-content:space-between;align-items:start;gap:8px;">
                  <div>
                    <div style="font-size:16px;font-weight:800;color:#0f172a">{{ $vendor->service_name }}</div>
                    @if($vendor->subtitle)
                      <div style="font-size:13px;color:#64748b;margin-top:4px;">{{ $vendor->subtitle }}</div>
                    @endif
                  </div>
                  <div style="color:#0ea5e9;font-weight:800;font-size:16px">₹{{ $vendor->base_price ?? 0 }}</div>
                </div>

                <div style="display:flex;align-items:center;gap:8px;color:#64748b;font-size:13px;">
                  <div style="background:#f0fdf4;color:#15803d;padding:6px 8px;border-radius:8px;font-weight:700;display:inline-flex;align-items:center;gap:6px;">{{ number_format($vendor->rating ?? 5,1) }} <span style="font-size:12px;color:#065f46;">★</span></div>
                  <div>• {{ $vendor->bookings->count() ?? 0 }} Reviews</div>
                </div>

                <div style="color:#64748b;font-size:13px;">
                  <i class="fa-solid fa-location-dot" style="color:#0ea5e9;margin-right:8px"></i>
                  {{ $vendor->street ? $vendor->street.', ' : '' }}{{ $vendor->area }}, {{ $vendor->city }} @if($vendor->pin_code) - {{ $vendor->pin_code }}@endif
                </div>

                @if($vendor->services->count())
                  <div style="margin-top:8px;display:flex;flex-wrap:wrap;gap:6px;">
                    @foreach($vendor->services as $s)
                      <div style="font-size:12px;background:#f1f5f9;color:#475569;padding:6px 8px;border-radius:8px;border:1px solid #e2e8f0;">{{ $s->name }}</div>
                    @endforeach
                  </div>
                @endif

              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="card" style="padding:20px;text-align:center;color:#64748b;">No businesses found — create a vendor profile to add your first business.</div>
      @endif
    </div>
  </div>
  <!-- Confirmation modal (hidden by default) -->
  <div id="confirmModal" style="display:none;position:fixed;inset:0;z-index:2000;align-items:center;justify-content:center;">
    <div id="confirmOverlay" style="position:absolute;inset:0;background:rgba(2,6,23,0.6);"></div>
    <div style="position:relative;z-index:2010;width:300px;background:#fff;border-radius:12px;box-shadow:0 12px 40px rgba(2,8,23,.6);overflow:hidden;font-family:system-ui;padding:18px;text-align:left;">
      <div style="font-weight:800;font-size:16px;margin-bottom:8px;">Confirm delete</div>
      <div id="confirmMessage" style="color:#374151;font-size:14px;margin-bottom:16px;">Are you sure?</div>
      <div style="display:flex;justify-content:flex-end;gap:8px;">
        <button id="confirmCancel" type="button" style="padding:8px 12px;border-radius:8px;border:1px solid #e5e7eb;background:#fff;">Cancel</button>
        <button id="confirmOk" type="button" style="padding:8px 12px;border-radius:8px;background:#ef4444;color:#fff;border:none;">Delete</button>
      </div>
    </div>
  </div>
</body>
<script>
  // Close menu dropdowns when clicking outside
  document.addEventListener('click', function(e){
    document.querySelectorAll('.menu-dropdown.show').forEach(function(dd){
      if (!dd.contains(e.target) && !dd.previousElementSibling.contains(e.target)) dd.classList.remove('show');
    });
  });

  // Confirmation modal logic
  (function(){
    const modal = document.getElementById('confirmModal');
    const overlay = document.getElementById('confirmOverlay');
    const msg = document.getElementById('confirmMessage');
    const btnOk = document.getElementById('confirmOk');
    const btnCancel = document.getElementById('confirmCancel');
    let pendingForm = null;

    function showConfirmation(form, vendorName){
      pendingForm = form;
      msg.textContent = 'Delete "' + vendorName + '"? This action cannot be undone.';
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
      btnOk.focus();
    }
    function hideConfirmation(){ pendingForm = null; modal.style.display = 'none'; document.body.style.overflow = ''; }

    document.querySelectorAll('form.confirm-delete').forEach(function(f){
      f.addEventListener('submit', function(ev){
        ev.preventDefault();
        const name = f.getAttribute('data-vendor-name') || 'this business';
        showConfirmation(f, name);
      });
    });

    btnCancel.addEventListener('click', hideConfirmation);
    overlay.addEventListener('click', hideConfirmation);
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') hideConfirmation(); });

    btnOk.addEventListener('click', function(){
      if (pendingForm) pendingForm.submit();
    });
  })();
</script>
</html>

