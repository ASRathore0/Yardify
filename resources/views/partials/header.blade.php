<style>
    #global-header {
        background-color: #1f2937 !important;
        height: px !important;
        width: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        position: sticky !important;
        top: 0 !important;
        z-index: 50 !important;
    }
</style>
<script>
    // Apply theme immediately to prevent FOUC (Flash of Unstyled Content) and the "reflecting" animation on page load
    (function() {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>

<header id="global-header" class="sticky top-0 z-50 w-full bg-[#1f2937] border-b border-slate-700 shadow-md">
    <div class="px-4 sm:px-6 lg:px-8 w-full max-w-[1400px] mx-auto flex items-center justify-between h-14 sm:h-[72px]">

        <!-- Left: Logo -->
        <div class="flex items-center shrink-0">
            <!-- Brand Name Only -->
            <a href="/" class="flex justify-center outline-none">
                <span class="text-xl sm:text-[30px] font-black text-white tracking-tight leading-none hover:text-[#38bdf8] transition-colors">
                    Booking<span class="text-[#046c9f]">Yard</span>
                </span>
            </a>
        </div>

        <!-- Right: Theme, Notifications & Toggle -->
        <div class="flex items-center justify-end gap-3 sm:gap-2 shrink-0">

            <!-- Dark Mode Toggle -->
            <button id="themeToggle" onclick="toggleTheme()" class="relative w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full text-slate-300 hover:bg-slate-700 transition-colors outline-none">
                <i id="themeIcon" class="fa-regular text-lg sm:text-[20px] transition-transform"></i>
            </button>

            <!-- Notifications -->
            <button class="relative w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full text-slate-300 hover:bg-slate-700 transition-colors outline-none">
                <i class="fa-regular fa-bell text-lg sm:text-[20px]"></i>
                <span class="absolute top-1.5 right-1.5 sm:top-2.5 sm:right-2.5 w-2 h-2 sm:w-[9px] sm:h-[9px] bg-red-500 border-2 border-[#1f2937] rounded-full"></span>
            </button>

            <!-- Custom Animated Hamburger Menu -->
            <button onclick="window.bookingyardToggleSidebar()" class="group relative w-9 h-9 sm:w-10 sm:h-10 flex flex-col items-center justify-center gap-[4px] sm:gap-[5px] rounded-xl bg-transparent hover:bg-slate-700 transition-colors focus:ring-2 focus:ring-[#0ea5e9]/20 outline-none ml-1 sm:ml-0">
                <span class="w-[16px] sm:w-[18px] h-[2px] bg-slate-300 rounded-full transition-all group-hover:bg-[#0ea5e9] group-hover:w-[20px] sm:group-hover:w-[22px]"></span>
                <span class="w-[20px] sm:w-[22px] h-[2px] bg-slate-300 rounded-full transition-all group-hover:bg-[#0ea5e9] group-hover:w-[16px] sm:group-hover:w-[18px]"></span>
                <span class="w-[16px] sm:w-[18px] h-[2px] bg-slate-300 rounded-full transition-all group-hover:bg-[#0ea5e9] group-hover:w-[20px] sm:group-hover:w-[22px]"></span>
            </button>

        </div>
    </div>
</header>

<script>
    // Set correct icon immediately without waiting for DOMContentLoaded to stop the 'flicker'
    (function() {
        const icon = document.getElementById('themeIcon');
        if (document.documentElement.classList.contains('dark')) {
            icon.classList.add('fa-sun');
        } else {
            icon.classList.add('fa-moon');
        }
    })();

    function toggleTheme() {
        const html = document.documentElement;
        const icon = document.getElementById('themeIcon');

        if (html.classList.contains('dark')) {
            // Switch to Light Mode
            html.classList.remove('dark');
            localStorage.theme = 'light';

            // Animate Icon
            icon.style.transform = 'rotate(-90deg) scale(0.5)';
            icon.style.opacity = '0';
            setTimeout(() => {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                icon.style.transform = 'rotate(0) scale(1)';
                icon.style.opacity = '1';
            }, 150);
        } else {
            // Switch to Dark Mode
            html.classList.add('dark');
            localStorage.theme = 'dark';

            // Animate Icon
            icon.style.transform = 'rotate(90deg) scale(0.5)';
            icon.style.opacity = '0';
            setTimeout(() => {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                icon.style.transform = 'rotate(0) scale(1)';
                icon.style.opacity = '1';
            }, 150);
        }
    }
</script>


