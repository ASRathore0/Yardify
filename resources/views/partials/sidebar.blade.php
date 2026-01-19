<!-- 1. Backdrop -->
<div id="sidebarBackdrop" onclick="window.bookingyardToggleSidebar()" 
     style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); z-index: 9998; opacity: 0; visibility: hidden; transition: all 0.4s ease;">
</div>

<!-- Load Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Custom CSS for the "Branch" lines and elevated items -->
<style>
    .menu-item-parent {
        display: flex; align-items: center; gap: 12px; padding: 14px 16px; 
        text-decoration: none; color: #475569; border-radius: 12px; 
        font-weight: 600; margin-bottom: 4px; transition: 0.3s; cursor: pointer;
    }
    
    /* The "Dashboard" style elevated card when active or open */
    .menu-item-parent.active, .menu-item-parent[aria-expanded="true"] {
        background: #a2caf3; /* Light version of the image's card */
        color: #0f172a;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Container for the submenu branches */
    .submenu-container {
        position: relative;
        margin-left: 26px; /* Align vertical line under the parent icon */
        padding-left: 20px;
        border-left: 1px solid #e2e8f0; /* The vertical line */
        margin-bottom: 10px;
        margin-top: -4px;
    }

    .submenu-item {
        position: relative;
        display: flex; align-items: center; gap: 10px; padding: 10px 0; 
        text-decoration: none; color: #64748b; font-size: 0.9rem;
        font-weight: 500; transition: 0.2s;
    }

    /* The horizontal branch line */
    .submenu-item::before {
        content: "";
        position: absolute;
        left: -20px;
        top: 50%;
        width: 15px;
        height: 1px;
        background: #e2e8f0;
    }

    .submenu-item:hover { color: #0ea5e9; }
    
    /* Selected sub-item (like 'Statistic' in your image) */
    .submenu-item.active-sub {
        color: #0ea5e9;
        font-weight: 700;
        background: #f0f9ff;
        border-radius: 8px;
        padding-left: 10px;
        margin-left: -5px;
    }
</style>

<aside id="mainSidebar" 
       style="position: fixed; top: 0; left: 0; width: 280px; height: 100vh; background: #eef9ff; color: #1e293b; display: flex; flex-direction: column; transform: translateX(-100%); transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 20px 0 50px rgba(0,0,0,0.1); z-index: 9999; border-right: 1px solid #f1f5f9; font-family: 'Inter', sans-serif;">
    
    <!-- Sidebar Header -->
    <div style="padding: 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f8fafc;">
        @if(Auth::check())
            <a href="{{ route('profile') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #0f172a;">
                <div style="width: 40px; height: 40px; background: #e2e8f0; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover; display:block;">
                    @else
                        <span style="font-weight:800; color:#0ea5e9;">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</span>
                    @endif
                </div>
                <div style="display:flex; flex-direction:column; line-height:1;">
                    <span style="font-weight:800; font-size:1rem; color:#0f172a;">{{ Auth::user()->name }}</span>
                    <span style="font-size:0.75rem; color:#64748b;">View profile</span>
                </div>
            </a>
        @else
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 1.2rem; color: #0f172a;">
                <span>Booking<span style="color: #0ea5e9;">Yard</span></span>
            </div>
        @endif
        <button onclick="window.bookingyardToggleSidebar()" style="background: #f1f5f9; border: none; width: 32px; height: 32px; border-radius: 50%; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center;">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- Navigation Content -->
    <nav style="flex: 1; padding: 20px 16px; overflow-y: auto;">
        
        <p style="font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.2px; margin: 0 0 10px 12px;">Menu</p>

        <!-- Home Item -->
        <a href="/" class="menu-item-parent {{ url()->current() === url('/') ? 'active' : '' }}">
            <i class="fa-solid fa-house" style="width: 20px;"></i>
            <span>Home</span>
        </a>

        <!-- Services Parent -->
        <a href="#" id="servicesToggle" role="button" aria-expanded="false" class="menu-item-parent" onclick="event.preventDefault(); window.bookingyardToggleServices();">
            <i class="fa-solid fa-briefcase" style="width: 20px;"></i>
            <span>Services</span>
            <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 0.7rem; transition: 0.3s;"></i>
        </a>

        <!-- Services Submenu (The "Branch" style) -->
        <div id="servicesSubmenu" class="submenu-container" style="display: none;">
            <a href="#" class="submenu-item"><span>Home Services</span></a>
            <a href="#" class="submenu-item"><span>Event</span></a>
            <a href="#" class="submenu-item"><span>Cab</span></a>
            <a href="#" class="submenu-item"><span>Rental</span></a>
            <a href="#" class="submenu-item"><span>Working Professional</span></a>
        </div>

        <!-- Expenses Item -->
        <a href="/expense-management" class="menu-item-parent {{ request()->is('expense-management*') ? 'active' : '' }}">
            <i class="fa-solid fa-wallet" style="width: 20px;"></i>
            <span>Expenses</span>
        </a>

        <!-- Vendor Parent -->
        <a href="" id="vendorToggle" role="button" aria-expanded="false" class="menu-item-parent" onclick="event.preventDefault(); window.bookingyardToggleVendor();">
            <i class="fa-solid fa-store" style="width: 20px;"></i>
            <span>Vendor</span>
            <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 0.7rem;"></i>
        </a>

        <!-- Vendor Submenu (The "Branch" style) -->
        <div id="vendorSubmenu" class="submenu-container" style="display: none;">
            <a href="/vendor/dashboard" class="submenu-item {{ request()->is('vendor/dashboard') ? 'active-sub' : '' }}">
                <span>Dashboard</span>
            </a>
            <a href="/vendor" class="submenu-item {{ request()->is('vendor') ? 'active-sub' : '' }}">
                <span>List Businesses</span>
            </a>
        </div>

        <p style="font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1.2px; margin: 25px 0 10px 12px;">Company</p>

        <a href="#" class="menu-item-parent">
            <i class="fa-solid fa-building" style="width: 20px;"></i>
            <span>About Us</span>
        </a>

        <a href="{{ route('careers.show') }}" class="menu-item-parent">
            <i class="fa-solid fa-users-viewfinder" style="width: 20px;"></i>
            <span>Careers</span>
            <span style="margin-left: auto; background: #10b981; color: white; font-size: 0.6rem; padding: 2px 8px; border-radius: 20px; font-weight: 800;">NEW</span>
        </a>

    </nav>

    <!-- Sidebar Footer -->
    <div style="padding: 20px 16px; border-top: 1px solid #f1f5f9;">
        @if(Auth::check())
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-sidebar-form').submit();" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; color: #ef4444; border-radius: 12px; font-weight: 700; background: #fff5f5;">
                <i class="fa-solid fa-arrow-right-from-bracket" style="width: 20px;"></i>
                <span>Sign Out</span>
            </a>
            <form id="logout-sidebar-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
        @else
            <a href="/login" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; text-decoration: none; color: #0ea5e9; border-radius: 12px; font-weight: 700; background: #f0f9ff;">
                <i class="fa-solid fa-user-lock" style="width: 20px;"></i>
                <span>Login</span>
            </a>
        @endif
    </div>

</aside>

<script>
    // Toggle Sidebar
    window.bookingyardToggleSidebar = function() {
        const sidebar = document.getElementById('mainSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const isOpen = sidebar.style.transform === 'translateX(0%)';

        if (isOpen) {
            sidebar.style.transform = 'translateX(-100%)';
            backdrop.style.opacity = '0';
            backdrop.style.visibility = 'hidden';
            document.body.style.overflow = '';
        } else {
            sidebar.style.transform = 'translateX(0%)';
            backdrop.style.opacity = '1';
            backdrop.style.visibility = 'visible';
            document.body.style.overflow = 'hidden';
        }
    };

    // Generic function to handle submenu logic
    function handleToggle(submenuId, toggleId) {
        const submenu = document.getElementById(submenuId);
        const toggle = document.getElementById(toggleId);
        const icon = toggle.querySelector('.fa-chevron-down');
        
        const isOpen = submenu.style.display === 'block';
        if (isOpen) {
            submenu.style.display = 'none';
            toggle.setAttribute('aria-expanded', 'false');
            if(icon) icon.style.transform = 'rotate(0deg)';
        } else {
            submenu.style.display = 'block';
            toggle.setAttribute('aria-expanded', 'true');
            if(icon) icon.style.transform = 'rotate(180deg)';
        }
    }

    window.bookingyardToggleServices = () => handleToggle('servicesSubmenu', 'servicesToggle');
    window.bookingyardToggleVendor = () => handleToggle('vendorSubmenu', 'vendorToggle');
</script>