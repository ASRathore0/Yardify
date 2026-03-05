const fs = require('fs');

const content = `<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vendor->title }} - BookingYard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .glass-panel { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
        .service-card-active { border-color: #0ea5e9 !important; background-color: #f0f9ff !important; box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.1), 0 2px 4px -1px rgba(14, 165, 233, 0.06) !important; }
        .service-card-active .check-icon { display: block !important; }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800">
    @include('partials.header')
    @include('partials.sidebar')

    <!-- Hero Section -->
    <div class="relative w-full h-[30vh] sm:h-[40vh] mt-16">
        <img src="{{ $vendor->business_image ?? asset('image/Booking.jpg') }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
        <div class="absolute bottom-0 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 translate-y-1/2 flex items-end gap-5">
            <div class="w-24 h-24 sm:w-32 sm:h-32 bg-white rounded-2xl p-1 shadow-xl shrink-0 overflow-hidden relative z-10 border-4 border-white">
                <img src="{{ $vendor->image ?? asset('image/Booking.jpg') }}" class="w-full h-full object-cover rounded-xl" alt="Profile">
                <div class="absolute top-2 right-2 bg-green-500 w-3.5 h-3.5 rounded-full border-2 border-white shadow-sm"></div>
            </div>
            <div class="mb-14 sm:mb-16 text-white relative z-10">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">{{ $vendor->title }}</h1>
                    <span class="bg-blue-600 text-white text-xs font-bold px-2 py-0.5 rounded-md uppercase tracking-wide">Verified</span>
                </div>
                <p class="text-slate-200 mt-1 flex items-center gap-2 text-sm sm:text-base font-medium">
                    <i class="fas fa-map-marker-alt text-blue-400"></i> {{ $vendor->area }}, {{ $vendor->city }}
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 sm:pt-24 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column (Details) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- About Card -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-100">
                    <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-tie text-blue-500"></i> About Professional
                    </h2>
                    <p class="text-slate-600 leading-relaxed">{{ $vendor->description ?? 'Highly skilled and verified professional dedicated to providing top-notch services. Committed to quality, punctuality, and customer satisfaction.' }}</p>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-slate-100">
                        <div class="text-center p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fas fa-star text-yellow-400 text-2xl mb-2"></i>
                            <div class="font-bold text-slate-800 text-lg">{{ number_format($vendor->rating ?? 5.0, 1) }}</div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider font-semibold mt-1">Rating</div>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fas fa-briefcase text-blue-500 text-2xl mb-2"></i>
                            <div class="font-bold text-slate-800 text-lg">100+</div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider font-semibold mt-1">Jobs Done</div>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fas fa-history text-green-500 text-2xl mb-2"></i>
                            <div class="font-bold text-slate-800 text-lg">3 yrs</div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider font-semibold mt-1">Experience</div>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <i class="fas fa-shield-alt text-purple-500 text-2xl mb-2"></i>
                            <div class="font-bold text-slate-800 text-lg">Yes</div>
                            <div class="text-xs text-slate-500 uppercase tracking-wider font-semibold mt-1">Insured</div>
                        </div>
                    </div>
                </div>

                <!-- Services Card -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-100">
                    <h2 class="text-xl font-bold text-slate-800 mb-5 flex items-center gap-2">
                        <i class="fas fa-tools text-blue-500"></i> Select Service
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="servicesList">
                        @forelse($vendor->services as $index => $service)
                        <div class="service-option relative border-2 border-slate-100 rounded-xl p-5 cursor-pointer transition-all hover:border-blue-300" onclick="selectService(this, \\'{{ $service->name }}\\', {{ $service->price ?? $vendor->base_price ?? 500 }})">
                            <div class="check-icon hidden absolute top-4 right-4 text-blue-500">
                                <i class="fas fa-check-circle text-xl animate-bounce"></i>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mb-3 text-lg">
                                <i class="fas fa-wrench"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-1 text-lg">{{ $service->name }}</h4>
                            <p class="text-sm text-slate-500 mb-4 line-clamp-2">Standard quality service including all basic tools.</p>
                            <div class="font-black text-slate-900 text-2xl">₹{{ $service->price ?? $vendor->base_price ?? 500 }}</div>
                        </div>
                        @empty
                        <div class="service-option relative border-2 border-slate-100 rounded-xl p-5 cursor-pointer transition-all hover:border-blue-300" onclick="selectService(this, \\'Standard Service\\', {{ $vendor->base_price ?? 500 }})">
                            <div class="check-icon hidden absolute top-4 right-4 text-blue-500">
                                <i class="fas fa-check-circle text-xl animate-bounce"></i>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500 mb-3 text-lg">
                                <i class="fas fa-cog"></i>
                            </div>
                            <h4 class="font-bold text-slate-800 mb-1 text-lg">Standard Service</h4>
                            <p class="text-sm text-slate-500 mb-4">General professional service at base rate.</p>
                            <div class="font-black text-slate-900 text-2xl">₹{{ $vendor->base_price ?? 500 }}</div>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right Column (Sticky Booking Form) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                        <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-7 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl"></div>
                            <h3 class="text-2xl font-bold flex items-center gap-3 mb-1"><i class="fas fa-calendar-check text-blue-400"></i> Book Now</h3>
                            <p class="text-slate-300 text-sm">Secure your spot instantly.</p>
                        </div>
                        
                        <div class="p-7">
                            <form id="bookingForm" onsubmit="event.preventDefault(); submitBooking();">
                                @csrf
                                <input type="hidden" id="vendor_id" value="{{ $vendor->id }}">
                                <input type="hidden" id="selectedService" value="{{ $vendor->services->first()->name ?? 'Standard Service' }}">
                                <input type="hidden" id="selectedPrice" value="{{ $vendor->services->first()->price ?? $vendor->base_price ?? 500 }}">

                                <!-- Service Overview Summary -->
                                <div class="bg-blue-50/50 rounded-2xl p-4 mb-6 border border-blue-100 flex justify-between items-center">
                                    <div>
                                        <div class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-1">Selected Service</div>
                                        <div id="displayServiceName" class="font-bold text-slate-800">{{ $vendor->services->first()->name ?? 'Standard Service' }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-1">Cost</div>
                                        <div id="displayServicePrice" class="font-black text-slate-900 text-xl">₹{{ $vendor->services->first()->price ?? $vendor->base_price ?? 500 }}</div>
                                    </div>
                                </div>

                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2 flex justify-between">Session Date & Time <i class="far fa-clock text-slate-400"></i></label>
                                        <input type="datetime-local" id="scheduled_at" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none transition-all shadow-sm">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2 flex justify-between">Address & Notes <i class="fas fa-map-pin text-slate-400"></i></label>
                                        <textarea id="notes" rows="3" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white outline-none transition-all resize-none custom-scrollbar shadow-sm" placeholder="House no, street, landmark, and any specific requests..."></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Payment Type</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label class="relative border-2 border-slate-900 bg-white p-4 rounded-xl cursor-pointer flex flex-col items-center justify-center text-center transition-all shadow-sm">
                                                <input type="radio" name="payment_method" value="cod" checked class="peer sr-only">
                                                <div class="text-slate-900 mb-2 mt-1"><i class="fas fa-wallet text-2xl"></i></div>
                                                <span class="text-xs font-black text-slate-900 uppercase tracking-wide">Cash / UPI<br>Post Service</span>
                                                <div class="absolute top-2 right-2 text-slate-900 peer-checked:block hidden"><i class="fas fa-check-circle"></i></div>
                                            </label>
                                            <label class="relative border-2 border-slate-100 bg-slate-50 p-4 rounded-xl cursor-not-allowed opacity-50 flex flex-col items-center justify-center text-center">
                                                <input type="radio" name="payment_method" value="online" disabled class="peer sr-only">
                                                <div class="text-slate-400 mb-2 mt-1"><i class="fas fa-credit-card text-2xl"></i></div>
                                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Pay Online<br>(Soon)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 pt-5 border-t border-slate-200 border-dashed">
                                    <div class="flex justify-between items-center text-sm font-semibold text-slate-500 mb-2">
                                        <span>Service Rate</span>
                                        <span id="summaryPrice">₹{{ $vendor->services->first()->price ?? $vendor->base_price ?? 500 }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm font-semibold text-slate-500 mb-3">
                                        <span>Platform Fee</span>
                                        <span>₹20</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-4 border-t border-slate-200">
                                        <span class="text-slate-900 font-extrabold text-lg">Total Due</span>
                                        <span id="summaryTotal" class="text-2xl font-black text-blue-600">₹{{ ($vendor->services->first()->price ?? $vendor->base_price ?? 500) + 20 }}</span>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <button id="submitBtn" type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-xl shadow-blue-600/30 transition-all flex justify-center items-center gap-2 text-lg outline-none focus:ring-4 focus:ring-blue-500/30 active:scale-[0.98]">
                                        Confirm Details <i class="fas fa-arrow-right text-sm"></i>
                                    </button>
                                    <div id="loadingBtn" class="hidden w-full bg-slate-800 text-white font-bold py-4 rounded-xl text-center text-lg shadow-xl">
                                        <i class="fas fa-circle-notch fa-spin mr-2"></i> Requesting...
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="mt-5 flex items-center justify-center gap-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        <i class="fas fa-shield-alt text-green-500"></i> Secure booking with BookingYard
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal Overlay -->
    <div id="successModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform scale-95 transition-all opacity-0 border border-slate-100 text-slate-800" id="successModalContent">
                <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 border-8 border-green-100">
                    <i class="fas fa-check text-4xl text-green-500"></i>
                </div>
                <h3 class="text-3xl font-extrabold mb-2 text-slate-900">Success!</h3>
                <p class="text-slate-500 mb-8 text-sm leading-relaxed font-medium">Your request is dispatched securely! The professional will review and accept it shortly.</p>
                <div class="space-y-3">
                    <a href="{{ route('my.bookings') }}" class="block w-full bg-slate-900 hover:bg-black text-white font-bold py-4 px-4 rounded-xl transition-colors shadow-lg shadow-slate-900/20 text-lg">
                        View My Bookings
                    </a>
                    <a href="{{ route('explore') }}" class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 px-4 rounded-xl transition-colors">
                        Back to Explore
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer-mobile')
    @include('partials.footer-modern')

    <script>
        // Set min date to today and default time
        document.addEventListener('DOMContentLoaded', function() {
            var now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('scheduled_at').min = now.toISOString().slice(0,16);
            
            // Set default date to +2 hours
            now.setHours(now.getHours() + 2);
            document.getElementById('scheduled_at').value = now.toISOString().slice(0,16);
            
            // Initialize first service as active visually
            const firstServiceCard = document.querySelector('.service-option');
            if(firstServiceCard) {
                firstServiceCard.classList.add('service-card-active');
            }
        });

        // Handle service selection UX
        function selectService(element, name, price) {
            document.getElementById('selectedService').value = name;
            document.getElementById('selectedPrice').value = price;
            
            document.getElementById('displayServiceName').textContent = name;
            document.getElementById('displayServicePrice').textContent = '₹' + price;
            
            document.getElementById('summaryPrice').textContent = '₹' + price;
            document.getElementById('summaryTotal').textContent = '₹' + (parseFloat(price) + 20);

            // Remove active state from all cards
            document.querySelectorAll('.service-option').forEach(card => {
                card.classList.remove('service-card-active');
            });
            // Add active state to clicked
            element.classList.add('service-card-active');
        }

        async function submitBooking() {
            const vendor_id = document.getElementById('vendor_id').value;
            const service_name = document.getElementById('selectedService').value;
            const scheduled_at = document.getElementById('scheduled_at').value;
            const notes = document.getElementById('notes').value;
            const price = document.getElementById('selectedPrice').value;

            document.getElementById('submitBtn').classList.add('hidden');
            document.getElementById('loadingBtn').classList.remove('hidden');

            try {
                const res = await fetch('{{ route("bookings.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        vendor_id,
                        service_name,
                        scheduled_at,
                        notes,
                        price
                    })
                });

                if (res.status === 401) {
                    alert('Please log in to make a booking.');
                    window.location.href = '/login';
                    return;
                }

                const data = await res.json();
                
                if (data.success || res.ok) {
                    // Show fancy modal
                    document.getElementById('successModal').classList.remove('hidden');
                    // Animate it in
                    setTimeout(() => {
                        const content = document.getElementById('successModalContent');
                        content.classList.remove('opacity-0', 'scale-95');
                        content.classList.add('opacity-100', 'scale-100');
                    }, 10);
                } else {
                    alert(data.error || 'Failed to submit booking. Please try again.');
                    document.getElementById('submitBtn').classList.remove('hidden');
                    document.getElementById('loadingBtn').classList.add('hidden');
                }
            } catch(e) {
                console.error(e);
                alert('Connection error. Please try again.');
                document.getElementById('submitBtn').classList.remove('hidden');
                document.getElementById('loadingBtn').classList.add('hidden');
            }
        }
    </script>
</body>
</html>`;

fs.writeFileSync('resources/views/professional/show.blade.php', content);
