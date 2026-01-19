<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Customer Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Essential non-inlineable CSS */
        .menu-item:active { background-color: #f1f5f9 !important; transform: scale(0.98); }
        /* Smooth scrolling for the whole page */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Inter', sans-serif; color: #1e293b; overflow-x: hidden;">

    <!-- FIXED TOP HEADER -->
    <div style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000;">
        @include('partials.header')
    </div>

    {{-- Ensure sidebar is present so the header toggle works --}}
    @include('partials.sidebar')

    <!-- MAIN SCROLLABLE CONTAINER -->
    <!-- Note the padding-bottom: 120px; this is the secret to fixing the footer overlap -->
    <div style="padding: 75px 15px; max-width: 500px; margin: 0 auto -70px; min-height: 100vh; box-sizing: border-box;">
        
        <!-- MODERN PROFILE CARD -->
        <div style="background: white; border-radius: 24px; padding: 30px 20px; text-align: center; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid rgba(255,255,255,0.8); margin-bottom: 25px;">
            <div style="width: 90px; height: 90px; margin: 0 auto 15px; border-radius: 50%; padding: 3px; background: linear-gradient(135deg, #046c9f, #60a5fa);">
                <div style="width: 100%; height: 100%; border-radius: 50%; background: #fff; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 2px solid white;">
                    @if(Auth::check() && Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" alt="User" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fa-solid fa-user" style="font-size: 2.2rem; color: #cbd5e0;"></i>
                    @endif
                </div>
            </div>
            <h2 style="margin: 0; font-size: 1.3rem; font-weight: 700; color: #0f172a;">{{ Auth::check() ? Auth::user()->name : 'Guest User' }}</h2>
            <p style="margin: 5px 0 0; font-size: 0.85rem; color: #64748b; font-weight: 500;">{{ Auth::check() ? 'Premium Member' : 'Welcome' }}</p>
        </div>

        <!-- SETTINGS GROUP -->
        <div style="margin-bottom: 25px;">
            <p style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-left: 10px; margin-bottom: 10px;">Personal Settings</p>
            <div style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid #f1f5f9;">
                <a href="#" class="menu-item" style="display: flex; align-items: center; justify-content: space-between; padding: 15px; text-decoration: none; border-bottom: 1px solid #f8fafc; transition: 0.2s;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #e0f2fe; color: #0369a1; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-wallet"></i></div>
                        <span style="font-size: 0.95rem; font-weight: 600; color: #334155;">My Wallet</span>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e0; font-size: 0.8rem;"></i>
                </a>
                <a href="{{ route('account.show') }}" class="menu-item" style="display: flex; align-items: center; justify-content: space-between; padding: 15px; text-decoration: none;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-circle-user"></i></div>
                        <span style="font-size: 0.95rem; font-weight: 600; color: #334155;">Account Details</span>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e0; font-size: 0.8rem;"></i>
                </a>
            </div>
        </div>

        <!-- VENDOR GROUP -->
        <div style="margin-bottom: 25px;">
            <p style="font-size: 0.7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.5px; margin-left: 10px; margin-bottom: 10px;">Vendor Hub</p>
            <div style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid #f1f5f9;">
                <a href="/vendor" class="menu-item" style="display: flex; align-items: center; justify-content: space-between; padding: 15px; text-decoration: none; border-bottom: 1px solid #f8fafc;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-store"></i></div>
                        <span style="font-size: 0.95rem; font-weight: 600; color: #334155;">Our Business</span>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e0; font-size: 0.8rem;"></i>
                </a>
                <a href="{{ route('refer.earn') }}" class="menu-item" style="display: flex; align-items: center; justify-content: space-between; padding: 15px; text-decoration: none;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 38px; height: 38px; border-radius: 10px; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-gift"></i></div>
                        <span style="font-size: 0.95rem; font-weight: 600; color: #334155;">Refer & Earn</span>
                    </div>
                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e0; font-size: 0.8rem;"></i>
                </a>
            </div>
        </div>

        <!-- LOGOUT / EXIT -->
        @if(Auth::check())
        <div onclick="document.getElementById('logout-form').submit()" class="menu-item" style="background: white; border-radius: 20px; padding: 15px; display: flex; align-items: center; gap: 15px; cursor: pointer; border: 1px solid #fee2e2; margin-bottom: 40px;">
            <div style="width: 38px; height: 38px; border-radius: 10px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
            <span style="font-size: 0.95rem; font-weight: 600; color: #ef4444;">Sign Out</span>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        @endif

        <!-- THE FOOTER -->
        <!-- We wrap it in a div to ensure it has its own spacing within the scroll -->
         

    </div>

    <!-- FIXED BOTTOM NAVIGATION -->
    <!-- Ensure your partial 'bottom_nav' is set to position: fixed; bottom: 0; -->
      @include('partials.footer-mobile')
      @include('partials.footer-modern')

    <script src="js/script.js"></script>
</body>
</html>