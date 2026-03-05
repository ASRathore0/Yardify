const fs = require('fs');

const htmlContent = fs.readFileSync('resources/views/professional/show.blade.php', 'utf8');

const heroReplaceStr = `@php
    // Mocking a gallery array for the UI. If you add a 'gallery' column later, you can replace this variable.
    $gallery = [
        $vendor->image_url ?? asset('imagee/Booking.jpg'),
        asset('imagee/banner.webp'),
        asset('imagee/service.png')
    ];
@endphp

    <!-- Hero Section (Slider) -->
    <div class="relative w-full h-[30vh] sm:h-[40vh] mt-16 group">
        <!-- Slider Images -->
        <div id="hero-slider" class="w-full h-full flex overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
            @foreach($gallery as $index => $img)
            <div class="w-full h-full flex-shrink-0 snap-center relative">
                <img src="{{ $img }}" class="w-full h-full object-cover" alt="Service Photo">
            </div>
            @endforeach
        </div>

        <!-- Slider Controls -->
        @if(count($gallery) > 1)
        <button onclick="slideHero(-1)" class="absolute left-2 sm:left-4 top-[40%] sm:top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/60 backdrop-blur-md text-white w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity z-20 shadow-lg">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button onclick="slideHero(1)" class="absolute right-2 sm:right-4 top-[40%] sm:top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/60 backdrop-blur-md text-white w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity z-20 shadow-lg">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <!-- Indicators -->
        <div class="absolute bottom-[35%] w-full flex justify-center gap-2 z-20">
            @foreach($gallery as $index => $img)
            <div class="slider-dot w-2 h-2 rounded-full {{ $index === 0 ? 'bg-white scale-125' : 'bg-white/50' }} transition-all shadow-sm"></div>
            @endforeach
        </div>
        @endif

        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent pointer-events-none"></div>
        
        <div class="absolute bottom-0 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 translate-y-1/2 flex items-end gap-5">
            <div class="w-24 h-24 sm:w-32 sm:h-32 bg-white rounded-2xl p-1 shadow-xl shrink-0 overflow-hidden relative z-10 border-4 border-white">
                <img src="{{ $vendor->user->avatar_url ?? asset('imagee/profile.png') }}" class="w-full h-full object-cover rounded-xl" alt="Profile">
                <div class="absolute top-2 right-2 bg-green-500 w-3.5 h-3.5 rounded-full border-2 border-white shadow-sm"></div>
            </div>
            <div class="mb-14 sm:mb-16 text-white relative z-10">
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">{{ $vendor->title }}</h1>
                    <span class="bg-blue-600 text-white text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded-md uppercase tracking-wide">Verified</span>
                </div>
                <p class="text-slate-200 mt-1 flex items-center gap-2 text-sm sm:text-base font-medium">
                    <i class="fas fa-map-marker-alt text-blue-400"></i> {{ $vendor->area }}, {{ $vendor->city }}
                </p>
            </div>
        </div>
    </div>`;

const originalHero = `    <!-- Hero Section -->
    <div class="relative w-full h-[30vh] sm:h-[40vh] mt-16">
        <img src="{{ $vendor->image_url ?? asset('imagee/Booking.jpg') }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
        <div class="absolute bottom-0 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 translate-y-1/2 flex items-end gap-5">
            <div class="w-24 h-24 sm:w-32 sm:h-32 bg-white rounded-2xl p-1 shadow-xl shrink-0 overflow-hidden relative z-10 border-4 border-white">
                <img src="{{ $vendor->user->avatar_url ?? asset('imagee/profile.png') }}" class="w-full h-full object-cover rounded-xl" alt="Profile">
                <div class="absolute top-2 right-2 bg-green-500 w-3.5 h-3.5 rounded-full border-2 border-white shadow-sm"></div>
            </div>
            <div class="mb-14 sm:mb-16 text-white relative z-10">
                <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">{{ $vendor->title }}</h1>
                    <span class="bg-blue-600 text-white text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded-md uppercase tracking-wide">Verified</span>
                </div>
                <p class="text-slate-200 mt-1 flex items-center gap-2 text-sm sm:text-base font-medium">
                    <i class="fas fa-map-marker-alt text-blue-400"></i> {{ $vendor->area }}, {{ $vendor->city }}
                </p>
            </div>
        </div>
    </div>`;

const scriptLogic = `        // Slider Logic
        let currentSlide = 0;
        function slideHero(direction) {
            const slider = document.getElementById('hero-slider');
            if(!slider) return;
            const dots = document.querySelectorAll('.slider-dot');
            const totalSlides = dots.length;
            
            if(totalSlides > 0) {
                currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
                slider.scrollTo({
                    left: slider.clientWidth * currentSlide,
                    behavior: 'smooth'
                });
            }
        }
        
        document.getElementById('hero-slider')?.addEventListener('scroll', function() {
            const slider = this;
            const dots = document.querySelectorAll('.slider-dot');
            if(dots.length) {
                const slideIndex = Math.round(slider.scrollLeft / slider.clientWidth);
                if(slideIndex !== currentSlide) {
                    currentSlide = slideIndex;
                    dots.forEach((dot, index) => {
                        if(index === currentSlide) {
                            dot.classList.remove('bg-white/50');
                            dot.classList.add('bg-white', 'scale-125');
                        } else {
                            dot.classList.add('bg-white/50');
                            dot.classList.remove('bg-white', 'scale-125');
                        }
                    });
                }
            }
        });

        // Set min date to today and default time`;

let updatedStr = htmlContent.replace(originalHero, heroReplaceStr);
updatedStr = updatedStr.replace('// Set min date to today and default time', scriptLogic);

// Adding CSS hide scrollbar class to head
const styleTagStart = `<style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }`;
updatedStr = updatedStr.replace('<style>', styleTagStart);


fs.writeFileSync('resources/views/professional/show.blade.php', updatedStr);
