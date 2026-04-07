<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Society Deals - Buy & Sell</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- <link rel="stylesheet" href="{{ asset('css/stylee.css') }}"> -->
    <style>
        html, body { max-width: 100%; overflow-x: hidden; }
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .main-contentt { padding-top: 0; } /* clear fixed header */
        .deal-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .deal-card:hover { transform: translateY(-4px); box-shadow: 0 15px 30px -5px rgba(0,0,0,0.1); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        /* Modal animation */
        @keyframes modalFadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .modal-enter { animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 overflow-x-hidden w-full">

    @include('partials.header')
    @include('partials.sidebar')

    <div class="main-contentt min-h-screen">
        
        <!-- Hero Section with Search -->
        <section class="bg-gradient-to-br from-[#046c9f] to-[#023b57] text-white pt-5 pb-16 px-4 shadow-lg relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-72 h-72 bg-white opacity-5 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#0ef] opacity-10 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2 pointer-events-none"></div>
            
            <div class="max-w-5xl mx-auto relative z-10">
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
                    <div class="text-center md:text-left">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-[10px] font-bold uppercase tracking-widest mb-3 backdrop-blur-sm">
                            <i class="fas fa-handshake text-yellow-300"></i> Society Marketplace
                        </div>
                        <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-2 leading-tight">Find Great Deals Locally</h1>
                        <p class="text-blue-100 text-sm md:text-base font-medium max-w-lg mx-auto md:mx-0">
                            Buy, sell, and trade gently used items with your trusted neighbors.
                        </p>
                    </div>
                    <div class="shrink-0 w-full md:w-auto">
                        <a href="{{ route('vendor.items.sell') }}" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-white text-[#046c9f] text-[15px] rounded-xl font-black shadow-xl hover:bg-slate-50 hover:shadow-2xl transition-all transform hover:-translate-y-0.5 border border-white/40">
                            <i class="fas fa-camera mr-2 text-lg"></i> Post an Ad
                        </a>
                    </div>
                </div>

                <!-- Prominent Search Bar -->
                <form action="{{ route('one_x_one') }}" method="GET" class="relative max-w-3xl mx-auto md:mx-0 group">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-[#046c9f] transition-colors text-lg"></i>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}"
                        class="block w-full pl-12 pr-32 py-4 sm:py-5 border-0 rounded-2xl text-slate-900 bg-white placeholder-slate-400 focus:ring-4 focus:ring-blue-100 shadow-xl transition-shadow text-[15px] sm:text-base font-medium" 
                        placeholder="Search electronics, furniture, vehicles...">
                    <div class="absolute inset-y-0 right-2 flex items-center">
                        <button type="submit" class="bg-[#046c9f] hover:bg-[#035b88] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-xl font-bold shadow-md transition-colors text-sm sm:text-[15px]">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Sticky Filters & Categories -->
        <section class="sticky top-[60px] z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm px-4 py-3 -mt-6 rounded-t-3xl max-w-7xl mx-auto">
            <div class="flex overflow-x-auto gap-3 items-center scrollbar-hide">
                <a href="{{ route('one_x_one', ['q' => request('q')]) }}" class="shrink-0 px-6 py-2.5 {{ !request('category') ? 'bg-[#046c9f] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-sm font-bold rounded-xl shadow-md transition-colors">All Items</a>
                <a href="{{ route('one_x_one', ['category' => 'Electronics', 'q' => request('q')]) }}" class="shrink-0 px-5 py-2 {{ request('category') == 'Electronics' ? 'bg-[#046c9f] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-sm font-bold rounded-xl transition-colors">Electronics</a>
                <a href="{{ route('one_x_one', ['category' => 'Furniture', 'q' => request('q')]) }}" class="shrink-0 px-5 py-2 {{ request('category') == 'Furniture' ? 'bg-[#046c9f] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-sm font-bold rounded-xl transition-colors">Furniture</a>
                <a href="{{ route('one_x_one', ['category' => 'Vehicles', 'q' => request('q')]) }}" class="shrink-0 px-5 py-2 {{ request('category') == 'Vehicles' ? 'bg-[#046c9f] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-sm font-bold rounded-xl transition-colors">Vehicles</a>
                <a href="{{ route('one_x_one', ['category' => 'Books & Media', 'q' => request('q')]) }}" class="shrink-0 px-5 py-2 {{ request('category') == 'Books & Media' ? 'bg-[#046c9f] text-white shadow-md' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} text-sm font-bold rounded-xl transition-colors">Books & Media</a>
            </div>
        </section>

        <!-- Deals Grid -->
        <section class="max-w-7xl mx-auto px-4 py-8 pb-12">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-extrabold text-slate-800">Fresh Listings</h3>
                <div class="flex items-center gap-2 text-sm font-bold text-slate-500 cursor-pointer hover:text-slate-700">
                    Sort by: <span class="text-[#046c9f]">Newest <i class="fas fa-chevron-down text-[10px] ml-1"></i></span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($items as $item)
                @php
                    $sellerName = $item->user->name ?? 'Unknown Seller';
                    $initials = collect(explode(' ', $sellerName))->map(function($v) { return substr($v, 0, 1); })->take(2)->implode('');
                    $initials = strtoupper($initials);
                    $colors = ['from-blue-100 to-slate-200', 'from-pink-100 to-slate-200', 'from-yellow-100 to-slate-200', 'from-green-100 to-slate-200', 'from-purple-100 to-slate-200'];
                    $colorClass = $colors[$item->id % count($colors)];
                    $imageUrl = ($item->image_path && count($item->image_path) > 0) ? asset('storage/'.$item->image_path[0]) : 'https://placehold.co/600x400/e2e8f0/475569?text=No+Image';
                    $imagesJson = json_encode($item->image_path && count($item->image_path) > 0 ? array_map(function($img) { return asset('storage/'.$img); }, $item->image_path) : []);
                @endphp
                <div onclick="openDeal(this)" 
                    data-title="{{ $item->title }}"
                    data-price="₹{{ number_format($item->price, 2) }}"
                    data-image="{{ $imageUrl }}"
                    data-images="{{ $imagesJson }}"
                    data-condition="{{ $item->condition ?? 'N/A' }}"
                    data-desc="{{ $item->description }}"
                    data-seller="{{ $sellerName }}"
                    data-location="{{ $item->location_text }}"
                    data-phone="{{ $item->phone ?? '' }}"
                    data-avatar="{{ $initials }}"
                    data-color="{{ $colorClass }}"
                    class="bg-white rounded-[1.25rem] border border-slate-200 overflow-hidden deal-card flex flex-col cursor-pointer group">
                    <div class="relative h-56 bg-slate-100 overflow-hidden">
                        <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-md text-[10px] font-black text-slate-700 shadow-sm uppercase tracking-wider z-10">
                            {{ $item->condition ?? 'Listed' }}
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $item->type == 'sell' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }} uppercase">{{ $item->type }}</span>
                            <span class="text-[10px] font-bold text-slate-400">{{ $item->category }}</span>
                        </div>
                        <h3 class="text-[17px] font-bold text-slate-800 leading-snug line-clamp-2 mb-2 group-hover:text-[#046c9f] transition-colors">{{ $item->title }}</h3>
                        <div class="text-lg font-black text-[#046c9f] mb-3">₹{{ number_format($item->price, 2) }} {{ $item->type == 'rent' ? '/period' : '' }}</div>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $item->description }}</p>
                        
                        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $colorClass }} flex items-center justify-center text-[10px] font-bold text-slate-600 border border-slate-100 shadow-sm">{{ $initials }}</div>
                                <div>
                                    <p class="text-[12px] font-bold text-slate-700 leading-none mb-0.5">{{ $sellerName }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium leading-none"><i class="fas fa-map-marker-alt mr-0.5"></i> {{ Str::limit($item->location_text, 15) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-500">
                    <i class="fas fa-box-open text-4xl mb-3 text-slate-300"></i>
                    <p class="text-lg font-medium">No items listed yet. Be the first to post an ad!</p>
                </div>
            @endforelse
            </div>
            
            <div class="mt-12 text-center">
                <button class="px-8 py-3.5 bg-white text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors border border-slate-300 shadow-sm inline-flex items-center">
                    <i class="fas fa-redo-alt mr-2 text-slate-400"></i> Load More Deals
                </button>
            </div>
        </section>
    </div>

    <!-- Product Details Modal Overlay -->
    <div id="dealModal" style="z-index: 49;" class="fixed inset-0 pt-[52px] sm:pt-[72px] bg-slate-900/80 backdrop-blur-sm flex items-end sm:items-center justify-center sm:p-4 hidden transition-opacity duration-300">
        <!-- Modal Content Container -->
        <div class="bg-white w-full max-w-2xl sm:rounded-[2rem] rounded-t-[2rem] rounded-b-none sm:rounded-b-[2rem] overflow-hidden flex flex-col max-h-[90vh] sm:max-h-[95vh] relative shadow-2xl modal-enter translate-y-0 transition-transform duration-300">
            
            <!-- Mobile Drag Handle Indicator (Visual only) -->
            <div class="w-full flex justify-center py-3 sm:hidden absolute top-0 left-0 z-30 pointer-events-none">
                <div class="w-12 h-1.5 bg-white/50 rounded-full"></div>
            </div>

            <!-- Close Button -->
            <button onclick="closeDeal()" class="absolute top-3 right-3 sm:top-5 sm:right-5 z-20 w-9 h-9 sm:w-10 sm:h-10 bg-black/30 hover:bg-black/50 backdrop-blur-md text-white rounded-full flex items-center justify-center transition-colors shadow-lg border border-white/10">
                <i class="fas fa-times text-base sm:text-lg"></i>
            </button>

            <!-- Scrollable Content -->
            <div class="overflow-y-auto flex-1 font-sans scrollbar-hide">
                <!-- Large Image Slider -->
                <div class="relative h-64 sm:h-[400px] w-full bg-slate-100 group select-none overflow-hidden cursor-grab active:cursor-grabbing"
                     ontouchstart="handleTouchStart(event)" ontouchmove="handleTouchMove(event)" ontouchend="handleTouchEnd(event)"
                     onmousedown="handleMouseDown(event)" onmousemove="handleMouseMove(event)" onmouseup="handleMouseUp(event)" onmouseleave="handleMouseUp(event)">
                    <img id="mImg" src="" alt="Product Image" class="w-full h-full object-cover transition-opacity duration-300 pointer-events-none">
                    
                    <!-- Slider Indicators -->
                    <div id="sliderDots" class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-20 px-4 pointer-events-none">
                        <!-- Dots will be injected via JS -->
                    </div>

                    <!-- Gradient overlay on mobile for drag handle visibility -->
                    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-transparent to-transparent sm:hidden h-24 pointer-events-none"></div>
                </div>

                <div class="p-5 sm:p-8">
                    <div class="flex items-center gap-2 mb-3">
                        <span id="mCondition" class="bg-blue-50 text-[#046c9f] border border-blue-100 px-3 py-1 rounded-md text-[10px] sm:text-[11px] font-black uppercase tracking-wider">Condition</span>
                    </div>

                    <h2 id="mTitle" class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2 leading-tight">Product Title</h2>
                    <div class="text-2xl sm:text-3xl font-black text-[#046c9f] mb-5 sm:mb-6" id="mPrice">₹0</div>

                    <h4 class="text-[11px] sm:text-sm font-bold uppercase tracking-widest text-slate-400 mb-2.5">Description</h4>
                    <p id="mDesc" class="text-slate-600 text-sm sm:text-[15px] leading-relaxed mb-6 sm:mb-8 bg-slate-50 p-4 sm:p-5 rounded-2xl border border-slate-100">
                        Detailed description goes here.
                    </p>

                    <h4 class="text-[11px] sm:text-sm font-bold uppercase tracking-widest text-slate-400 mb-2.5">Seller Details</h4>
                    <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-5 border border-slate-200 rounded-2xl bg-white shadow-sm">
                        <div id="mAvatar" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-base sm:text-lg font-bold text-slate-700 shadow-sm border border-slate-100">A</div>
                        <div class="flex-1 min-w-0">
                            <p id="mSeller" class="text-sm sm:text-base font-bold text-slate-800 truncate">Seller Name</p>
                            <p id="mLoc" class="text-xs sm:text-[13px] text-slate-500 font-medium mt-0.5 truncate"><i class="fas fa-map-marker-alt mr-1 text-slate-400"></i> Location</p>
                        </div>
                        <div class="text-right flex flex-col items-end shrink-0">
                            <span class="bg-green-50 text-green-700 px-2 py-1 rounded-md text-[9px] sm:text-[10px] font-bold uppercase tracking-wide flex items-center mb-1 border border-green-100">
                                <i class="fas fa-check-circle mr-1"></i> Verified
                            </span>
                            <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold">Resident</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Action Footer -->
            <div class="p-4 sm:p-6 bg-white border-t border-slate-100 flex gap-3 shadow-[0_-4px_20px_-10px_rgba(0,0,0,0.1)] relative z-10">
                <a id="mWhatsAppBtn" href="#" target="_blank" class="flex-1 bg-[#25D366] hover:bg-[#20bd5a] text-white py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-bold text-sm sm:text-[15px] shadow-lg shadow-green-200/50 transition-transform transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fab fa-whatsapp text-lg sm:text-xl"></i> <span class="hidden sm:inline">WhatsApp</span><span class="sm:hidden">Chat</span>
                </a>
                <a id="mCallBtn" href="#" class="flex-1 bg-[#046c9f] hover:bg-[#035b88] text-white py-3.5 sm:py-4 rounded-xl sm:rounded-2xl font-bold text-sm sm:text-[15px] shadow-lg shadow-blue-200/50 transition-transform transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fas fa-phone-alt"></i> Call
                </a>
            </div>
        </div>
    </div>

    @include('partials.footer-mobile')
    @include('partials.footer-modern')

    <script src="js/script.js"></script>
    <script src="js/script1.js"></script>
    <script>
        // Modal Slider Logic
        let currentImages = [];
        let currentImageIndex = 0;

        function updateSlider() {
            const imgEl = document.getElementById('mImg');
            const sliderDots = document.getElementById('sliderDots');

            if (currentImages.length > 0) {
                imgEl.src = currentImages[currentImageIndex];
            }

            if (currentImages.length > 1) {
                sliderDots.innerHTML = currentImages.map((_, i) => 
                    `<button style="pointer-events: auto;" onclick="goToSlide(${i})" class="w-2.5 h-2.5 rounded-full transition-all border border-black/10 focus:outline-none ${i === currentImageIndex ? 'bg-white w-5 shadow-md' : 'bg-white/60 hover:bg-white/90 shadow'}"></button>`
                ).join('');
            } else {
                sliderDots.innerHTML = '';
            }
        }

        function slideNext() {
            if (currentImages.length > 1) {
                currentImageIndex = (currentImageIndex + 1) % currentImages.length;
                updateSlider();
            }
        }

        function slidePrev() {
            if (currentImages.length > 1) {
                currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
                updateSlider();
            }
        }

        function goToSlide(index) {
            if (currentImages.length > 1 && index >= 0 && index < currentImages.length) {
                currentImageIndex = index;
                updateSlider();
            }
        }

        // Touch & Swipe Logic
        let touchStartX = 0;
        let touchEndX = 0;
        let isMouseDown = false;

        function handleTouchStart(e) {
            touchStartX = e.changedTouches ? e.changedTouches[0].screenX : e.screenX;
        }

        function handleTouchMove(e) {
            touchEndX = e.changedTouches ? e.changedTouches[0].screenX : e.screenX;
        }

        function handleTouchEnd(e) {
            if (e.changedTouches) {
                touchEndX = e.changedTouches[0].screenX;
            }
            handleSwipe();
        }

        function handleMouseDown(e) {
            isMouseDown = true;
            touchStartX = e.screenX;
        }

        function handleMouseMove(e) {
            if (!isMouseDown) return;
            touchEndX = e.screenX;
        }

        function handleMouseUp(e) {
            if (!isMouseDown) return;
            isMouseDown = false;
            handleSwipe();
        }

        function handleSwipe() {
            const SWIPE_THRESHOLD = 50;
            if (touchStartX - touchEndX > SWIPE_THRESHOLD) {
                slideNext(); // Swipe left -> Next
            }
            if (touchEndX - touchStartX > SWIPE_THRESHOLD) {
                slidePrev(); // Swipe right -> Prev
            }
        }

        // Modal Logic
        function openDeal(card) {
            // Get data
            const title = card.getAttribute('data-title');
            const price = card.getAttribute('data-price');
            const image = card.getAttribute('data-image');
            const imagesRaw = card.getAttribute('data-images');
            const condition = card.getAttribute('data-condition');
            const desc = card.getAttribute('data-desc');
            const seller = card.getAttribute('data-seller');
            const loc = card.getAttribute('data-location');
            const phone = card.getAttribute('data-phone');
            const avatar = card.getAttribute('data-avatar');
            const colorClass = card.getAttribute('data-color');

            // Setup Slider data
            try {
                currentImages = JSON.parse(imagesRaw);
            } catch(e) {
                currentImages = [];
            }
            if (!currentImages || currentImages.length === 0) {
                currentImages = image ? [image] : [];
            }
            currentImageIndex = 0;
            updateSlider();

            // Set data in modal
            document.getElementById('mTitle').textContent = title;
            document.getElementById('mPrice').textContent = price;
            document.getElementById('mCondition').textContent = condition;
            document.getElementById('mDesc').textContent = desc;
            document.getElementById('mSeller').textContent = seller;
            document.getElementById('mLoc').innerHTML = '<i class="fas fa-map-marker-alt mr-1 text-slate-400"></i> ' + loc;
            
            const waBtn = document.getElementById('mWhatsAppBtn');
            const callBtn = document.getElementById('mCallBtn');
            if (phone) {
                const cleanPhone = phone.replace(/\D/g, '');
                const waText = encodeURIComponent(`Hi ${seller}, I am interested in your ad "${title}" listed on Society Deals.`);
                waBtn.href = `https://wa.me/91${cleanPhone}?text=${waText}`;
                callBtn.href = `tel:${cleanPhone}`;
            } else {
                waBtn.href = "#";
                callBtn.href = "#";
            }
            
            const avatarEl = document.getElementById('mAvatar');
            avatarEl.textContent = avatar;
            avatarEl.className = `w-12 h-12 sm:w-14 sm:h-14 rounded-full flex items-center justify-center text-base sm:text-lg font-bold text-slate-700 shadow-sm border border-slate-100 bg-gradient-to-br ${colorClass}`;

            // Show Modal (disable body scroll and animate)
            const modal = document.getElementById('dealModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
            
            // Fix header position because overflow hidden breaks sticky
            const header = document.getElementById('global-header');
            const mainContent = document.querySelector('.main-contentt');
            if (header) {
                header.style.setProperty('position', 'fixed', 'important');
                header.style.setProperty('width', '100%', 'important');
                header.style.setProperty('top', '0', 'important');
                if (mainContent) mainContent.style.marginTop = header.offsetHeight + 'px';
            }
            
            // Hide bottom nav footer
            const fnav = document.getElementById('footer');
            if (fnav) fnav.style.display = 'none';
        }

        function closeDeal() {
            document.getElementById('dealModal').classList.add('hidden');
            document.body.style.overflow = '';
            document.documentElement.style.overflow = '';
            
            // Restore header position
            const header = document.getElementById('global-header');
            const mainContent = document.querySelector('.main-contentt');
            if (header) {
                header.style.removeProperty('position');
                header.style.removeProperty('width');
                header.style.removeProperty('top');
                if (mainContent) mainContent.style.marginTop = '';
            }
            
            // Show bottom nav footer
            const fnav = document.getElementById('footer');
            if (fnav) fnav.style.display = '';
        }

        // Close modal on click outside
        document.getElementById('dealModal').addEventListener('click', function(e) {
            if (e.target === this) { closeDeal(); }
        });
        
        // Escape key to close
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('dealModal').classList.contains('hidden')) {
                closeDeal();
            }
        });
    </script>
</body>
</html>

