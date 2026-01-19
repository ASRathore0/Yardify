<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor Dashboard | BookingYard</title>
  
  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  
  <style>
    /* --- CSS Variables & Reset --- */
    :root {
      --brand: #0077b6;       /* BookingYard Blue */
      --brand-dark: #023e8a;
      --brand-soft: #e0f2fe;
      --bg-body: #f8fafc;
      --bg-surface: #ffffff;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border: #e2e8f0;
      --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --radius: 16px;
    }

    * { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: var(--bg-body); margin: 0; color: var(--text-main); -webkit-font-smoothing: antialiased; }
    a { text-decoration: none; color: inherit; }

    /* --- Header & Navigation --- */
    .top-header { background: #1e293b; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; }
    .user-info { display: flex; align-items: center; gap: 12px; }
    .avatar-box { width: 40px; height: 40px; border-radius: 50%; background: #334155; overflow: hidden; border: 2px solid rgba(255,255,255,0.2); display: grid; place-items: center; }
    
    .nav-scroller { background: white; border-bottom: 1px solid var(--border); padding: 10px 20px; display: flex; gap: 8px; overflow-x: auto; }
    .nav-item { padding: 8px 16px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; color: var(--text-muted); display: flex; align-items: center; gap: 8px; white-space: nowrap; transition: 0.2s; }
    .nav-item.active { background: var(--brand-soft); color: var(--brand); box-shadow: 0 0 0 1px #bae6fd; }
    .nav-item:hover:not(.active) { background: #f1f5f9; color: var(--text-main); }

    /* --- Hero Background --- */
    .hero-bg { background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%); padding: 40px 20px 100px; text-align: center; color: white; }
    .hero-bg h1 { margin: 0; font-size: 1.75rem; font-weight: 700; }
    
    /* --- Main Layout Grid --- */
    .layout-grid {
      max-width: 1050px;
      margin: -70px auto 40px; /* Overlap effect */
      padding: 0 20px;
      display: grid;
      grid-template-columns: 2fr 1fr; /* 2 parts Left, 1 part Right */
      gap: 24px;
      position: relative; 
      z-index: 10;
    }

    /* --- General Card Style --- */
    .card { background: var(--bg-surface); border-radius: var(--radius); box-shadow: var(--shadow-card); overflow: hidden; border: 1px solid rgba(255,255,255,0.6); }

    /* --- Left Column: KPIs & Controls --- */
    .kpi-row { display: grid; grid-template-columns: repeat(3, 1fr); border-bottom: 1px solid var(--border); }
    .kpi-cell { padding: 24px 16px; text-align: center; border-right: 1px solid var(--border); }
    .kpi-cell:last-child { border-right: none; }
    .kpi-icon { width: 44px; height: 44px; margin: 0 auto 10px; background: var(--brand-soft); color: var(--brand); border-radius: 12px; display: grid; place-items: center; font-size: 1.2rem; }
    .kpi-num { font-size: 1.5rem; font-weight: 800; color: var(--text-main); line-height: 1; }
    .kpi-txt { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted); margin-top: 5px; letter-spacing: 0.5px; }

    .btn-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 24px; }
    .action-card { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 16px; display: flex; flex-direction: column; gap: 8px; transition: 0.2s; }
    .action-card:hover { transform: translateY(-3px); border-color: var(--brand); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); }
    .action-card.primary { background: var(--brand); border-color: var(--brand); color: white; }
    .action-card.primary .sub-text { color: rgba(255,255,255,0.8); }
    .main-text { font-weight: 700; font-size: 0.95rem; }
    .sub-text { font-size: 0.8rem; color: var(--text-muted); }

    /* --- Right Column: Profile Card Styling --- */
    .profile-img-container { position: relative; height: 180px; background: #cbd5e1; }
    .profile-img { width: 100%; height: 100%; object-fit: cover; }
    .discount-tag { position: absolute; top: 12px; left: 12px; background: #ef4444; color: white; font-weight: 700; font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
    
    .profile-details { padding: 20px; }
    .profile-header-row { display: flex; justify-content: space-between; align-items: start; margin-bottom: 4px; }
    .service-title { margin: 0; font-size: 1.15rem; font-weight: 700; color: var(--text-main); }
    .service-price { font-weight: 800; color: var(--brand); font-size: 1.1rem; }
    
    .rating-badge { display: inline-flex; align-items: center; gap: 4px; background: #f0fdf4; color: #15803d; padding: 4px 8px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; }
    
    .location-row { display: flex; gap: 8px; color: var(--text-muted); font-size: 0.85rem; margin-top: 12px; line-height: 1.4; }
    
    .tag-cloud { margin-top: 16px; display: flex; flex-wrap: wrap; gap: 6px; }
    .tag { font-size: 0.75rem; background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 6px; border: 1px solid #e2e8f0; font-weight: 500; }

    /* Empty State */
    .empty-card { padding: 30px; text-align: center; color: var(--text-muted); border: 2px dashed var(--border); background: #f8fafc; }

    /* Responsive */
    @media (max-width: 900px) {
      .layout-grid { grid-template-columns: 1fr; margin-top: -50px; }
      .kpi-row { grid-template-columns: 1fr; } 
      .kpi-cell { border-right: none; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; text-align: left; }
      .kpi-icon { order: 2; margin: 0; }
    }
  </style>
</head>
<body>

  @include('vendor.partials.nav')

  <!-- 2. Hero Section -->
  <div class="hero-bg">
    <h1>Vendor Dashboard</h1>
    <div style="opacity:0.9; margin-top:6px;">Manage your business bookings & profile</div>
  </div>

  <!-- 3. Main Grid Content -->
  <div class="layout-grid">
    
    <!-- LEFT COLUMN: Stats & Controls -->
    <div>
      <div class="card">
        <!-- KPI Stats -->
        <div class="kpi-row">
          <div class="kpi-cell">
            <div class="kpi-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="kpi-num">{{ $bookings->count() }}</div>
            <div class="kpi-txt">Total Bookings</div>
          </div>
          <div class="kpi-cell">
            <div class="kpi-icon"><i class="fa-solid fa-briefcase"></i></div>
            <div class="kpi-num">{{ isset($vendors) ? $vendors->count() : $services->count() }}</div>
            <div class="kpi-txt">Active Services</div>
          </div>
          <div class="kpi-cell">
            <div class="kpi-icon"><i class="fa-solid fa-wallet"></i></div>
            <div class="kpi-num">₹{{ number_format($transactions->where('type','credit')->sum('amount') - $transactions->where('type','debit')->sum('amount')) }}</div>
            <div class="kpi-txt">Wallet Balance</div>
          </div>
        </div>

        <!-- Action Grid -->
        <div class="btn-grid">
          <a href="{{ route('vendor.bookings') }}" class="action-card primary">
            <i class="fa-solid fa-list-check" style="font-size:1.4rem;"></i>
            <div>
              <div class="main-text">View Bookings</div>
              <div class="sub-text">Manage incoming orders</div>
            </div>
          </a>
          <a href="{{ route('vendor.services') }}" class="action-card">
            <i class="fa-solid fa-plus-circle" style="color:var(--brand); font-size:1.4rem;"></i>
            <div>
              <div class="main-text">Manage Services</div>
              <div class="sub-text">Add or edit services</div>
            </div>
          </a>
          <a href="{{ route('vendor.transactions') }}" class="action-card">
            <i class="fa-solid fa-file-invoice-dollar" style="color:#64748b; font-size:1.4rem;"></i>
            <div>
              <div class="main-text">Transactions</div>
              <div class="sub-text">Check earnings</div>
            </div>
          </a>
          <a href="{{ route('vendor.form') }}" class="action-card">
            <i class="fa-solid fa-store" style="color:#64748b; font-size:1.4rem;"></i>
            <div>
              <div class="main-text">Add Business</div>
              <div class="sub-text">Add another existing Business</div>
            </div>
          </a>
        </div>
      </div>

      <!-- Tips Box -->
      <div style="background:#fff; border:1px dashed var(--border); border-radius:12px; padding:20px; margin-top:20px;">
        <div style="font-weight:700; color:#ca8a04; margin-bottom:10px;"><i class="fa-regular fa-lightbulb"></i> Pro Tips</div>
        <ul style="padding-left:20px; margin:0; color:#475569; font-size:0.9rem;">
          <li style="margin-bottom:6px">Complete your profile to appear in search results.</li>
          <li>Respond to bookings quickly to improve your rating.</li>
        </ul>
      </div>
    </div>

    <!-- RIGHT COLUMN: Profile Preview (All Businesses) -->
    <div>
      @if(isset($vendors) && $vendors->count())
        <div style="display:grid;gap:12px;">
          @foreach($vendors as $v)
            <div class="card" style="overflow:hidden;">
              <div class="profile-img-container">
                <img class="profile-img" src="{{ $v->image_url ?? asset('image/Booking.jpg') }}" alt="Service image">
                @if($v->discount_percent)
                  <div class="discount-tag">FLAT {{ $v->discount_percent }}% OFF</div>
                @endif
              </div>
              <div class="profile-details">
                <div class="profile-header-row">
                  <h2 class="service-title">{{ $v->service_name }}</h2>
                  <div class="service-price">₹{{ $v->base_price ?? 0 }}</div>
                </div>

                @if($v->subtitle)
                  <div style="font-size:0.85rem; color:#64748b; margin-bottom:8px;">{{ $v->subtitle }}</div>
                @endif

                <div style="display:flex; align-items:center; gap:8px; font-size:0.85rem; color:#64748b;">
                  <div class="rating-badge">{{ number_format($v->rating ?? 5,1) }} <i class="fa-solid fa-star" style="font-size:0.7rem"></i></div>
                  <span>• {{ $v->bookings->count() }} Reviews</span>
                </div>

                <hr style="border:0; border-top:1px dashed var(--border); margin:12px 0;">

                <div class="location-row">
                  <i class="fa-solid fa-location-dot" style="color:var(--brand); margin-top:2px;"></i>
                  <div>
                    {{ $v->street ? $v->street.', ' : '' }}{{ $v->area }}, {{ $v->city }} @if($v->pin_code) - {{ $v->pin_code }}@endif
                  </div>
                </div>

                @if($v->services->count())
                  <div class="tag-cloud">
                    @foreach($v->services->take(5) as $s)
                      <div class="tag">{{ $s->name }}</div>
                    @endforeach
                    @if($v->services->count() > 5)
                      <div class="tag">+{{ $v->services->count() - 5 }} more</div>
                    @endif
                  </div>
                @endif

              </div>
            </div>
          @endforeach
        </div>
      @else
        <!-- Empty State for Profile -->
        <div class="card empty-card">
          <i class="fa-solid fa-store" style="font-size:2.5rem; margin-bottom:12px; color:#cbd5e1;"></i>
          <div style="font-weight:600; color:var(--text-main);">Profile Incomplete</div>
          <div style="font-size:0.9rem; margin:6px 0 16px;">Set up your profile to start getting bookings.</div>
          <a href="{{ route('vendor.form') }}" style="display:inline-block; background:var(--brand); color:#fff; padding:8px 16px; border-radius:8px; font-size:0.9rem; font-weight:600;">Create Profile</a>
        </div>
      @endif
    </div>

  </div>
</body>
</html>