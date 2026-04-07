<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - BookingYard</title>
    <link rel="stylesheet" href="{{ asset('css/stylee.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">
    @include('partials.header')
    @include('partials.sidebar')
    <div class="mt-"></div>
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-6">
                <i class="fas fa-calendar-check text-[#046c9f] mr-2"></i> My Bookings
            </h2>

            @if($bookings->isEmpty())
                <div class="bg-white rounded-2xl border border-slate-200 border-dashed p-12 text-center mt-6">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="far fa-folder-open text-3xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">You have no bookings yet</h3>
                    <p class="text-slate-500 text-sm max-w-sm mx-auto mb-6">When you book services, they will appear here.</p>
                    <a href="{{ route('explore') }}" class="inline-block bg-[#046c9f] hover:bg-[#035b88] text-white font-bold py-2 px-6 rounded-lg transition-colors">Explore Services</a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 transition-all hover:-translate-y-1 hover:shadow-md">
                            <div class="flex flex-col sm:flex-row justify-between gap-4">
                                <!-- Left: Info -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between sm:justify-start gap-4 mb-2">
                                        <h3 class="text-lg font-bold text-slate-800">{{ $booking->service_name }}</h3>
                                        <!-- Mobile Price -->
                                        <span class="sm:hidden text-lg font-black text-[#046c9f]">₹{{ number_format($booking->price, 2) }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-2">
                                        <div class="bg-slate-100 p-1.5 rounded-md text-center w-8 text-[#046c9f]">
                                            <i class="fas fa-store"></i>
                                        </div>
                                        <span class="font-medium">{{ $booking->vendor->title ?? 'N/A' }}</span>
                                    </div>

                                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
                                        <div class="bg-slate-100 p-1.5 rounded-md text-center w-8">
                                            <i class="far fa-clock text-slate-400"></i>
                                        </div>
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($booking->scheduled_at)->format('d M Y, h:i A') }}</span>
                                    </div>
                                    
                                    @if($booking->notes)
                                        <div class="text-sm text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-100 mb-4 italic">
                                            "{{ $booking->notes }}"
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center gap-3 mt-auto">
                                        <div class="text-sm text-slate-500 font-semibold uppercase tracking-wider text-[10px]">Status:</div>
                                        <span class="text-sm font-bold rounded-lg px-3 py-1 inline-block
                                            {{ $booking->status == 'pending' ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' : '' }}
                                            {{ $booking->status == 'confirmed' ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' : '' }}
                                            {{ $booking->status == 'completed' ? 'bg-green-50 text-green-700 ring-1 ring-green-200' : '' }}
                                            {{ $booking->status == 'cancelled' ? 'bg-red-50 text-red-700 ring-1 ring-red-200' : '' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Right: Price (Desktop) -->
                                <div class="hidden sm:flex flex-col items-end justify-center pl-6 border-l border-slate-100">
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Total Amount</div>
                                    <div class="text-2xl font-black text-[#046c9f]">₹{{ number_format($booking->price, 2) }}</div>
                                    <div class="text-xs text-slate-500 mt-1 font-medium"><i class="fas fa-wallet mr-1"></i> Cash / UPI</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @include('partials.footer-mobile')
    @include('partials.footer-modern')
</body>
</html>

