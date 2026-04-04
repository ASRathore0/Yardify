<!-- 1. Backdrop -->
<div id="sidebarBackdrop" onclick="window.bookingyardToggleSidebar()" 
     class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[9998] opacity-0 invisible transition-all duration-300">
</div>

<!-- Load Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>

<aside id="mainSidebar" 
       class="fixed top-0 left-0 w-[280px] h-screen bg-white text-slate-800 flex flex-col -translate-x-full transition-transform duration-300 ease-in-out shadow-2xl z-[9999] border-r border-slate-100 font-sans">
    
    <!-- Sidebar Header -->
    <div class="p-6 flex items-center justify-between border-b border-slate-100">
        @if(Auth::check())
            <a href="{{ route('profile') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-brand-50 rounded-xl overflow-hidden flex items-center justify-center border border-brand-100 group-hover:shadow-md transition-all">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" class="w-full h-full object-cover block">
                    @else
                        <span class="font-bold text-brand-600 text-lg">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</span>
                    @endif
                </div>
                <div class="flex flex-col leading-tight">
                    <span class="font-bold text-sm text-slate-900 group-hover:text-brand-600 transition-colors">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-slate-500 mt-0.5">View profile</span>
                </div>
            </a>
        @else
            <div class="flex items-center gap-2 font-black text-xl text-slate-900 tracking-tight">
                <span>Booking<span class="text-brand-600">Yard</span></span>
            </div>
        @endif
        <button onclick="window.bookingyardToggleSidebar()" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-500 hover:bg-slate-100 hover:text-slate-800 transition-colors">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- Navigation Content -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar">
        
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 ml-3">Menu</p>

        <!-- Home Item -->
        <a href="/" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 transition-all {{ url()->current() === url('/') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <i class="fa-solid fa-house w-5 text-center {{ url()->current() === url('/') ? 'text-brand-600' : 'text-slate-400' }}"></i>
            <span>Home</span>
        </a>

        <!-- My Bookings -->
        <a href="/my-bookings" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 transition-all {{ request()->is('my-bookings*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <i class="fa-solid fa-calendar-check w-5 text-center {{ request()->is('my-bookings*') ? 'text-brand-600' : 'text-slate-400' }}"></i>
            <span>My Bookings</span>
        </a>

        <!-- Services Parent Toggle -->
        <a href="#" id="servicesToggle" role="button" aria-expanded="false" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900" onclick="event.preventDefault(); window.bookingyardToggleServices();">
            <i class="fa-solid fa-layer-group w-5 text-center text-slate-400"></i>
            <span>Services</span>
            <i class="fa-solid fa-chevron-down ml-auto text-[10px] text-slate-400 transition-transform duration-300"></i>
        </a>

        <!-- Services Submenu -->
        <div id="servicesSubmenu" class="hidden ml-7 pl-4 border-l border-slate-200 mt-1 mb-2 space-y-1 relative">
            <a href="#" class="flex items-center py-2 px-2 text-sm font-medium text-slate-500 hover:text-brand-600 hover:bg-slate-50 rounded-lg transition-colors relative before:absolute before:-left-4 before:top-1/2 before:w-3 before:h-px before:bg-slate-200">
                <span>Home Services</span>
            </a>
            <a href="#" class="flex items-center py-2 px-2 text-sm font-medium text-slate-500 hover:text-brand-600 hover:bg-slate-50 rounded-lg transition-colors relative before:absolute before:-left-4 before:top-1/2 before:w-3 before:h-px before:bg-slate-200">
                <span>Event</span>
            </a>
            <a href="#" class="flex items-center py-2 px-2 text-sm font-medium text-slate-500 hover:text-brand-600 hover:bg-slate-50 rounded-lg transition-colors relative before:absolute before:-left-4 before:top-1/2 before:w-3 before:h-px before:bg-slate-200">
                <span>Cab</span>
            </a>
        </div>
  
        <!-- Expenses Item -->
        <a href="/expense-management" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 transition-all {{ request()->is('expense-management*') ? 'bg-brand-50 text-brand-700 shadow-sm' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <i class="fa-solid fa-wallet w-5 text-center {{ request()->is('expense-management*') ? 'text-brand-600' : 'text-slate-400' }}"></i>
            <span>Expenses</span>
        </a>

        <!-- Vendor Parent -->
        <a href="#" id="vendorToggle" role="button" aria-expanded="{{ request()->is('vendor*') ? 'true' : 'false' }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 transition-all {{ request()->is('vendor*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" onclick="event.preventDefault(); window.bookingyardToggleVendor();">
            <i class="fa-solid fa-store w-5 text-center {{ request()->is('vendor*') ? 'text-indigo-600' : 'text-slate-400' }}"></i>
            <span>Vendor Central</span>
            <i class="fa-solid fa-chevron-down ml-auto text-[10px] {{ request()->is('vendor*') ? 'text-indigo-600 rotate-180' : 'text-slate-400' }} transition-transform duration-300"></i>
        </a>

        <!-- Vendor Submenu -->
        <div id="vendorSubmenu" class="{{ request()->is('vendor*') ? 'block' : 'hidden' }} ml-7 pl-4 border-l border-slate-200 mt-1 mb-2 space-y-1 relative">
            <a href="/vendor/dashboard" class="flex items-center py-2 px-3 text-sm font-medium rounded-lg transition-colors relative before:absolute before:-left-4 before:top-1/2 before:w-3 before:h-px before:bg-slate-200 {{ request()->is('vendor/dashboard') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }}">
                <span>Dashboard</span>
            </a>
            <a href="/vendor/bookings" class="flex items-center py-2 px-3 text-sm font-medium rounded-lg transition-colors relative before:absolute before:-left-4 before:top-1/2 before:w-3 before:h-px before:bg-slate-200 {{ request()->is('vendor/bookings') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }}">
                <span>Bookings</span>
            </a>
            <a href="/vendor" class="flex items-center py-2 px-3 text-sm font-medium rounded-lg transition-colors relative before:absolute before:-left-4 before:top-1/2 before:w-3 before:h-px before:bg-slate-200 {{ request()->is('vendor') && !request()->is('vendor/*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-500 hover:text-indigo-600 hover:bg-slate-50' }}">
                <span>My Listings</span>
            </a>
        </div>

        @if(Auth::check() && Auth::user()->is_admin)
        <!-- Admin Panel Item -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 transition-all {{ request()->routeIs('admin.*') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
            <i class="fa-solid fa-chart-pie w-5 text-center {{ request()->routeIs('admin.*') ? 'text-slate-300' : 'text-slate-400' }}"></i>
            <span>Employee Panel</span>
        </a>
        @endif

        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-8 mb-3 ml-3">Company</p>

        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
            <i class="fa-solid fa-building w-5 text-center text-slate-400"></i>
            <span>About Us</span>
        </a>

        <a href="{{ route('careers.show') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold mb-1 transition-all text-slate-600 hover:bg-slate-50 hover:text-slate-900">
            <i class="fa-solid fa-users-viewfinder w-5 text-center text-slate-400"></i>
            <span>Careers</span>
            <span class="ml-auto bg-emerald-100 text-emerald-700 text-[9px] px-2 py-0.5 rounded-full font-bold tracking-wider">NEW</span>
        </a>

    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
        @if(Auth::check())
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-sidebar-form').submit();" class="flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl font-bold text-sm transition-all bg-white border border-rose-100 text-rose-600 hover:bg-rose-50 hover:border-rose-200 shadow-sm">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span>Sign Out</span>
            </a>
            <form id="logout-sidebar-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        @else
            <a href="/login" class="flex items-center justify-center gap-2 w-full py-3 px-4 rounded-xl font-bold text-sm transition-all bg-slate-900 border border-transparent text-white hover:bg-slate-800 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                <i class="fa-solid fa-user-lock"></i>
                <span>Login Securely</span>
            </a>
        @endif
    </div>

</aside>

<style>
    /* Styling for a subtle scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 4px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background: #cbd5e1;
    }
</style>

<script>
    // Config script for tailwind to match dashboard theme
    if(window.tailwind) {
        window.tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50: '#f0f9ff', 100: '#e0f2fe', 500: '#38bdf8', 600: '#0ea5e9', 700: '#0ea5e9', 900: '#0c4a6e' }
                    }
                }
            }
        }
    }

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
        
        const isOpen = !submenu.classList.contains('hidden');
        if (isOpen) {
            submenu.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            if(icon) {
                icon.classList.remove('rotate-180');
            }
        } else {
            submenu.classList.remove('hidden');
            toggle.setAttribute('aria-expanded', 'true');
            if(icon) {
                icon.classList.add('rotate-180');
            }
        }
    }

    window.bookingyardToggleServices = () => handleToggle('servicesSubmenu', 'servicesToggle');
    window.bookingyardToggleVendor = () => handleToggle('vendorSubmenu', 'vendorToggle');
</script>
