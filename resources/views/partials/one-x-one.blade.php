<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Society Deals - Buy & Sell</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .main-contentt { padding-top:; } /* clear fixed header */
        .deal-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .deal-card:hover { transform: translateY(-4px); box-shadow: 0 15px 30px -5px rgba(0,0,0,0.1); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        /* Modal animation */
        @keyframes modalFadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .modal-enter { animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 pb-20">

    @include('partials.header')
    @include('partials.sidebar')

    <div class="main-contentt min-h-screen">
        
        <!-- Hero Section with Search -->
        <section class="bg-gradient-to-br from-[#046c9f] to-[#023b57] text-white pt-10 pb-16 px-4 shadow-lg relative overflow-hidden">
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
                        <button onclick="alert('Post an ad modal would open here!')" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3.5 bg-white text-[#046c9f] text-[15px] rounded-xl font-black shadow-xl hover:bg-slate-50 hover:shadow-2xl transition-all transform hover:-translate-y-0.5 border border-white/40">
                            <i class="fas fa-camera mr-2 text-lg"></i> Post an Ad
                        </button>
                    </div>
                </div>

                <!-- Prominent Search Bar -->
                <div class="relative max-w-3xl mx-auto md:mx-0 group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 group-focus-within:text-[#046c9f] transition-colors text-lg"></i>
                    </div>
                    <input type="text" 
                        class="block w-full pl-12 pr-32 py-4 sm:py-5 border-0 rounded-2xl text-slate-900 bg-white placeholder-slate-400 focus:ring-4 focus:ring-blue-100 shadow-xl transition-shadow text-[15px] sm:text-base font-medium" 
                        placeholder="Search electronics, furniture, vehicles...">
                    <div class="absolute inset-y-0 right-2 flex items-center">
                        <button class="bg-[#046c9f] hover:bg-[#035b88] text-white px-5 sm:px-8 py-2.5 sm:py-3 rounded-xl font-bold shadow-md transition-colors text-sm sm:text-[15px]">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sticky Filters & Categories -->
        <section class="sticky top-[60px] z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 shadow-sm px-4 py-3 -mt-6 rounded-t-3xl max-w-7xl mx-auto">
            <div class="flex overflow-x-auto gap-3 items-center scrollbar-hide">
                <button class="shrink-0 px-6 py-2.5 bg-[#046c9f] text-white text-sm font-bold rounded-xl shadow-md transition-colors">All Items</button>
                <button class="shrink-0 px-5 py-2 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">Electronics</button>
                <button class="shrink-0 px-5 py-2 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">Furniture</button>
                <button class="shrink-0 px-5 py-2 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">Vehicles</button>
                <button class="shrink-0 px-5 py-2 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-200 transition-colors">Books & Media</button>
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
                
                <!-- Listing Item 1 -->
                <div onclick="openDeal(this)" 
                    data-title="Sony PlayStation 5 - Disk Edition"
                    data-price="?38,000"
                    data-image="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                    data-condition="Like New"
                    data-desc="Barely used PS5 Disk Edition. Perfect working condition. Comes with 2 DualSense controllers, original power/HDMI cables, and FIFA 23. Selling because I don't have time to play anymore due to work. Price is slightly negotiable for genuine buyers."
                    data-seller="Amit Singh"
                    data-location="Tower B, Apt 402"
                    data-avatar="AS"
                    data-color="from-blue-100 to-slate-200"
                    class="bg-white rounded-[1.25rem] border border-slate-200 overflow-hidden deal-card flex flex-col cursor-pointer group">
                    <div class="relative h-56 bg-slate-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="PS5" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-md text-[10px] font-black text-slate-700 shadow-sm uppercase tracking-wider z-10">
                            Like New
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-[17px] font-bold text-slate-800 leading-snug line-clamp-2 mb-2 group-hover:text-[#046c9f] transition-colors">Sony PlayStation 5 - Disk Edition</h3>
                        <div class="text-lg font-black text-[#046c9f] mb-3">?38,000</div>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">Barely used PS5 Disk Edition. Perfect condition. Comes with 2 controllers and FIFA 23.</p>
                        
                        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600 border border-slate-100 shadow-sm">AS</div>
                                <div>
                                    <p class="text-[12px] font-bold text-slate-700 leading-none mb-0.5">Amit Singh</p>
                                    <p class="text-[10px] text-slate-400 font-medium leading-none"><i class="fas fa-map-marker-alt mr-0.5"></i> Tower B</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Listing Item 2 -->
                <div onclick="openDeal(this)" 
                    data-title="Featherlite Ergonomic Office Chair"
                    data-price="?3,500"
                    data-image="https://images.unsplash.com/photo-1592078615290-033ee584e267?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                    data-condition="Gently Used"
                    data-desc="High back chair with adjustable lumbar support and 3D armrests. Perfect for long WFH setups. The mesh is intact, gas lift works perfectly. Minor scratches on the right armrest. Bought for ?8,500 last year."
                    data-seller="Priya Kapoor"
                    data-location="Tower A, Apt 1105"
                    data-avatar="PK"
                    data-color="from-pink-100 to-slate-200"
                    class="bg-white rounded-[1.25rem] border border-slate-200 overflow-hidden deal-card flex flex-col cursor-pointer group">
                    <div class="relative h-56 bg-slate-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1592078615290-033ee584e267?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Chair" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-md text-[10px] font-black text-slate-700 shadow-sm uppercase tracking-wider z-10">
                            Gently Used
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-[17px] font-bold text-slate-800 leading-snug line-clamp-2 mb-2 group-hover:text-[#046c9f] transition-colors">Featherlite Ergonomic Office Chair</h3>
                        <div class="text-lg font-black text-[#046c9f] mb-3">?3,500</div>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">High back chair with lumbar support. Perfect for WFH setups. Minor scratches on armrests.</p>
                        
                        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-100 to-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600 border border-slate-100 shadow-sm">PK</div>
                                <div>
                                    <p class="text-[12px] font-bold text-slate-700 leading-none mb-0.5">Priya Kapoor</p>
                                    <p class="text-[10px] text-slate-400 font-medium leading-none"><i class="fas fa-map-marker-alt mr-0.5"></i> Tower A</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Listing Item 3 -->
                <div onclick="openDeal(this)" 
                    data-title="Decathlon Rockrider Mountain Bike"
                    data-price="?8,000"
                    data-image="https://images.unsplash.com/photo-1485965120184-e220f721d03e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                    data-condition="Brand New"
                    data-desc="Ridden exactly twice. Selling because I am moving out of the country. 21-speed Shimano gears, dual hydraulic disc brakes, front suspension. Includes Decathlon helmet, bell, and heavy-duty number lock (worth ?1,500)."
                    data-seller="Rahul Desai"
                    data-location="Villa 14"
                    data-avatar="RD"
                    data-color="from-yellow-100 to-slate-200"
                    class="bg-white rounded-[1.25rem] border border-slate-200 overflow-hidden deal-card flex flex-col cursor-pointer group">
                    <div class="relative h-56 bg-slate-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1485965120184-e220f721d03e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bicycle" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-[#046c9f] backdrop-blur-sm px-2.5 py-1 rounded-md text-[10px] font-black text-white shadow-sm uppercase tracking-wider z-10">
                            Brand New
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-[17px] font-bold text-slate-800 leading-snug line-clamp-2 mb-2 group-hover:text-[#046c9f] transition-colors">Decathlon Rockrider Mountain Bike</h3>
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-lg font-black text-[#046c9f]">?8,000</span>
                            <span class="text-xs font-bold text-slate-400 line-through">?12,000</span>
                        </div>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">Ridden twice. 21-speed Shimano gears, dual disc brakes. Includes helmet and lock.</p>
                        
                        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-yellow-100 to-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600 border border-slate-100 shadow-sm">RD</div>
                                <div>
                                    <p class="text-[12px] font-bold text-slate-700 leading-none mb-0.5">Rahul Desai</p>
                                    <p class="text-[10px] text-slate-400 font-medium leading-none"><i class="fas fa-map-marker-alt mr-0.5"></i> Villa 14</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Listing Item 4 -->
                <div onclick="openDeal(this)" 
                    data-title="Harry Potter Complete Box Set"
                    data-price="?1,200"
                    data-image="https://images.unsplash.com/photo-1544244015-06103b41d08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                    data-condition="Heavily Used"
                    data-desc="Complete 7-book paperback series by Bloomsbury. Some dog-eared pages and spine wear on the first 3 books, but perfectly readable. Great for a kid starting their reading journey without spending ?4000 on a new set."
                    data-seller="Neha Verma"
                    data-location="Tower C, Apt 704"
                    data-avatar="NV"
                    data-color="from-green-100 to-slate-200"
                    class="bg-white rounded-[1.25rem] border border-slate-200 overflow-hidden deal-card flex flex-col cursor-pointer group">
                    <div class="relative h-56 bg-slate-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1544244015-06103b41d08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Books" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-md text-[10px] font-black text-slate-700 shadow-sm uppercase tracking-wider z-10">
                            Heavily Used
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-[17px] font-bold text-slate-800 leading-snug line-clamp-2 mb-2 group-hover:text-[#046c9f] transition-colors">Harry Potter Complete Box Set</h3>
                        <div class="text-lg font-black text-[#046c9f] mb-3">?1,200</div>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">7-book paperback series. Some pages dog-eared, but perfectly readable. Great value.</p>
                        
                        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-100 to-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600 border border-slate-100 shadow-sm">NV</div>
                                <div>
                                    <p class="text-[12px] font-bold text-slate-700 leading-none mb-0.5">Neha Verma</p>
                                    <p class="text-[10px] text-slate-400 font-medium leading-none"><i class="fas fa-map-marker-alt mr-0.5"></i> Tower C</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="mt-12 text-center">
                <button class="px-8 py-3.5 bg-white text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors border border-slate-300 shadow-sm inline-flex items-center">
                    <i class="fas fa-redo-alt mr-2 text-slate-400"></i> Load More Deals
                </button>
            </div>
        </section>
    </div>

    <!-- Product Details Modal Overlay -->
    <div id="dealModal" class="fixed inset-0 bg-slate-900/70 z-[100] backdrop-blur-sm flex items-center justify-center p-4 hidden">
        <div class="bg-white w-full max-w-2xl rounded-[2rem] overflow-hidden flex flex-col max-h-[95vh] relative shadow-2xl modal-enter">
            
            <!-- Close Button -->
            <button onclick="closeDeal()" class="absolute top-4 right-4 z-20 w-10 h-10 bg-black/40 hover:bg-black/60 backdrop-blur-md text-white rounded-full flex items-center justify-center transition-colors shadow-lg">
                <i class="fas fa-times text-lg"></i>
            </button>

            <!-- Scrollable Content -->
            <div class="overflow-y-auto flex-1 font-sans">
                <!-- Large Image -->
                <div class="relative h-72 sm:h-[400px] w-full bg-slate-100">
                    <img id="mImg" src="" alt="Product Image" class="w-full h-full object-cover">
                </div>

                <div class="p-6 sm:p-8">
                    <div class="flex gap-2 mb-3">
                        <span id="mCondition" class="bg-slate-100 text-slate-700 border border-slate-200 px-3 py-1 rounded-md text-[11px] font-black uppercase tracking-wider">Condition</span>
                    </div>

                    <h2 id="mTitle" class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2 leading-tight">Product Title</h2>
                    <div class="text-3xl font-black text-[#046c9f] mb-6" id="mPrice">?0</div>

                    <h4 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-3">Description</h4>
                    <p id="mDesc" class="text-slate-600 text-sm sm:text-[15px] leading-relaxed mb-8 bg-slate-50 p-5 rounded-2xl border border-slate-100">
                        Detailed description goes here.
                    </p>

                    <h4 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-3">Seller Details</h4>
                    <div class="flex items-center gap-4 p-4 lg:p-5 border border-slate-200 rounded-2xl bg-white shadow-sm">
                        <div id="mAvatar" class="w-14 h-14 rounded-full flex items-center justify-center text-lg font-bold text-slate-700 shadow-sm border border-slate-100">A</div>
                        <div class="flex-1">
                            <p id="mSeller" class="text-base font-bold text-slate-800">Seller Name</p>
                            <p id="mLoc" class="text-[13px] text-slate-500 font-medium mt-0.5"><i class="fas fa-map-marker-alt mr-1 text-slate-400"></i> Location</p>
                        </div>
                        <div class="text-right flex flex-col items-end">
                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide flex items-center mb-1">
                                <i class="fas fa-check-circle mr-1"></i> Verified
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium font-bold">Resident</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Action Footer -->
            <div class="p-5 sm:p-6 bg-white border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                <button onclick="alert('Opening WhatsApp Chat')" class="flex-1 bg-[#25D366] hover:bg-[#20bd5a] text-white py-4 rounded-2xl font-bold text-[15px] shadow-lg shadow-green-200 transition-transform transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fab fa-whatsapp text-xl"></i> Chat on WhatsApp
                </button>
                <button onclick="alert('Initiating Call')" class="flex-1 bg-[#046c9f] hover:bg-[#035b88] text-white py-4 rounded-2xl font-bold text-[15px] shadow-lg shadow-blue-200 transition-transform transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <i class="fas fa-phone-alt"></i> Call Seller
                </button>
            </div>
        </div>
    </div>

    @include('partials.footer-mobile')
    @include('partials.footer-modern')

    <script src="js/script.js"></script>
    <script src="js/script1.js"></script>
    <script>
        // Modal Logic
        function openDeal(card) {
            // Get data
            const title = card.getAttribute('data-title');
            const price = card.getAttribute('data-price');
            const image = card.getAttribute('data-image');
            const condition = card.getAttribute('data-condition');
            const desc = card.getAttribute('data-desc');
            const seller = card.getAttribute('data-seller');
            const loc = card.getAttribute('data-location');
            const avatar = card.getAttribute('data-avatar');
            const colorClass = card.getAttribute('data-color');

            // Set data in modal
            document.getElementById('mTitle').textContent = title;
            document.getElementById('mPrice').textContent = price;
            document.getElementById('mImg').src = image;
            document.getElementById('mCondition').textContent = condition;
            document.getElementById('mDesc').textContent = desc;
            document.getElementById('mSeller').textContent = seller;
            document.getElementById('mLoc').innerHTML = '<i class="fas fa-map-marker-alt mr-1 text-slate-400"></i> ' + loc;
            
            const avatarEl = document.getElementById('mAvatar');
            avatarEl.textContent = avatar;
            avatarEl.className = `w-14 h-14 rounded-full flex items-center justify-center text-lg font-bold text-slate-700 shadow-sm border border-slate-100 bg-gradient-to-br ${colorClass}`;

            // Show Modal (disable body scroll and animate)
            const modal = document.getElementById('dealModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeal() {
            document.getElementById('dealModal').classList.add('hidden');
            document.body.style.overflow = '';
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
