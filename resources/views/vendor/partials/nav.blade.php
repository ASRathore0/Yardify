<style>
  /* Hide scrollbar for Chrome, Safari and Opera */
  .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  /* Hide scrollbar for IE, Edge and Firefox */
  .no-scrollbar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
  }

  .nav-link {
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 50px; /* Full pill shape */
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    white-space: nowrap;
    border: 1px solid transparent; /* Prevents layout jump on hover */
  }

  /* Inactive State: Clean, no background, dark text */
  .nav-link.inactive {
    color: #64748b; /* Slate 500 */
    background: transparent;
  }
  .nav-link.inactive:hover {
    background: #f1f5f9; /* Slate 100 */
    color: #0f172a;
  }

  /* Active State: Brand Blue, White Text, Subtle Shadow */
  .nav-link.active {
    background: #0ea5e9; /* Sky 500 (Brand Blue) */
    color: #ffffff;
    box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.3);
  }
</style>

<!-- Ensure icons load on pages that don't include Font Awesome in their <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<header style="background: #fff; font-family: 'Inter', system-ui, sans-serif; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
  @php($user = Auth::user())
  
  <!-- Top Section: Premium Dark Header -->
  <div style="background: #0f172a; padding: 16px 20px; color: white; display: flex; align-items: center; justify-content: space-between;">
    
    <!-- User Profile -->
    <div style="display: flex; align-items: center; gap: 12px;">
      <div style="position: relative;">
        <div style="width: 42px; height: 42px; border-radius: 50%; background: #334155; border: 2px solid rgba(255,255,255,0.2); overflow: hidden; display: grid; place-items: center;">
          @if($user && $user->avatar_url)
            <img src="{{ $user->avatar_url }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
          @else
            <i class="fa-solid fa-user" style="color: #94a3b8; font-size: 18px;"></i>
          @endif
        </div>
        <!-- Online Status Dot (Optional) -->
        <div style="position: absolute; bottom: 0; right: 0; width: 10px; height: 10px; background: #22c55e; border: 2px solid #0f172a; border-radius: 50%;"></div>
      </div>
      
      <div>
        <div style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.5px; font-weight: 600; text-transform: uppercase;">Vendor Panel</div>
        <div style="font-size: 1rem; font-weight: 700; color: #f8fafc; line-height: 1.2;">{{ $user?->name ?? 'Guest' }}</div>
      </div>
    </div>

    <!-- Exit/Profile Action -->
    <a href="{{ route('profile') }}" style="width: 36px; height: 36px; display: grid; place-items: center; background: rgba(255,255,255,0.1); border-radius: 50%; color: #fff; text-decoration: none; transition: background 0.2s;">
      <i class="fa-solid fa-arrow-right-from-bracket" style="font-size: 14px;"></i>
    </a>
  </div>

  <!-- Bottom Section: Scrollable Clean Nav -->
  <nav class="no-scrollbar" style="display: flex; gap: 8px; padding: 12px 20px; overflow-x: auto; border-bottom: 1px solid #f1f5f9;">
    @php($routes = [
      ['text'=>'Overview', 'icon'=>'fa-chart-pie', 'name'=>'vendor.dashboard'],
      ['text'=>'Services', 'icon'=>'fa-layer-group', 'name'=>'vendor.services'],
      ['text'=>'Bookings', 'icon'=>'fa-calendar-check', 'name'=>'vendor.bookings'],
      ['text'=>'Wallet',   'icon'=>'fa-wallet', 'name'=>'vendor.transactions']
    ])
    
    @foreach($routes as $r)
      @php($active = request()->routeIs($r['name']))
      <a href="{{ route($r['name']) }}" class="nav-link {{ $active ? 'active' : 'inactive' }}">
        <i class="fa-solid {{ $r['icon'] }}"></i>
        {{ $r['text'] }}
      </a>
    @endforeach
  </nav>
</header>