<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Bookings</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body { background-color: #f8fafc; }
    .booking-card:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); }
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill="currentColor" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
        background-repeat: no-repeat;
        background-position-x: 95%;
        background-position-y: center;
    }
  </style>
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-800 pb-20">
  @include('vendor.partials.nav')
  
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            <i class="fas fa-calendar-check text-[#046c9f] mr-2"></i> Bookings
        </h2>
    </div>

    @if($bookings->count())
      <div class="space-y-4">
        @foreach($bookings as $b)
          <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 transition-all booking-card">
              <div class="flex flex-col sm:flex-row justify-between gap-4">
                  <!-- Left: Info -->
                  <div class="flex-1">
                      <div class="flex items-start justify-between sm:justify-start gap-4 mb-2">
                          <h3 class="text-lg font-bold text-slate-800">{{ $b->service_name }}</h3>
                          <!-- Mobile Price -->
                          <span class="sm:hidden text-lg font-black text-[#046c9f]">₹{{ $b->price }}</span>
                      </div>
                      
                      <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">
                          <div class="bg-slate-100 p-1.5 rounded-md">
                              <i class="far fa-clock text-slate-400"></i>
                          </div>
                          <span class="font-medium">{{ optional($b->scheduled_at)->format('d M Y, h:i A') }}</span>
                      </div>
                      
                      <div class="flex items-center gap-3">
                          <div class="text-sm text-slate-500 font-semibold uppercase tracking-wider text-[10px]">Status:</div>
                          <form action="{{ route('vendor.bookings.update', $b->id) }}" method="POST" class="m-0">
                              @csrf
                              @method('PUT')
                              <select name="status" onchange="this.form.submit()" 
                                  class="text-sm font-bold rounded-lg pl-3 pr-8 py-2 block w-full outline-none ring-1 ring-slate-200 focus:ring-2 focus:ring-[#046c9f] cursor-pointer shadow-sm transition-all
                                      {{ $b->status == 'pending' ? 'bg-amber-50 text-amber-700 ring-amber-200' : '' }}
                                      {{ $b->status == 'confirmed' ? 'bg-blue-50 text-blue-700 ring-blue-200' : '' }}
                                      {{ $b->status == 'completed' ? 'bg-green-50 text-green-700 ring-green-200' : '' }}
                                      {{ $b->status == 'cancelled' ? 'bg-red-50 text-red-700 ring-red-200' : '' }}">
                                  <option value="pending" {{ $b->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                  <option value="confirmed" {{ $b->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                  <option value="completed" {{ $b->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                  <option value="cancelled" {{ $b->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                              </select>
                          </form>
                      </div>
                  </div>
                  
                  <!-- Right: Price (Desktop) -->
                  <div class="hidden sm:flex flex-col items-end justify-center pl-6 border-l border-slate-100">
                      <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Total Amount</div>
                      <div class="text-2xl font-black text-[#046c9f]">₹{{ $b->price }}</div>
                      <div class="text-xs text-slate-500 mt-1 font-medium"><i class="fas fa-wallet mr-1"></i> Cash / UPI</div>
                  </div>
              </div>
          </div>
        @endforeach
      </div>
      
      <!-- Pagination -->
      <div class="mt-8 flex justify-center">
          {{ $bookings->links() }}
      </div>
      
    @else
      <div class="bg-white rounded-2xl border border-slate-200 border-dashed p-12 text-center mt-6">
          <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="far fa-folder-open text-3xl text-slate-300"></i>
          </div>
          <h3 class="text-xl font-bold text-slate-700 mb-2">No bookings yet</h3>
          <p class="text-slate-500 text-sm max-w-sm mx-auto">When customers book your services, they will appear here. Stay tuned!</p>
      </div>
    @endif

  </div>
</body>
</html>

