<footer id="footer" >
  <div class="footer-links">
		<a href="/" class="footer-button {{ url()->current() == url('/') ? 'active' : '' }}" id="home-button">
	  <i class="fa fa-house icon"></i>
	  <span>Home</span>
	</a>
		<a href="{{ route('explore') }}" class="footer-button {{ request()->routeIs('explore') || request()->is('explore*') ? 'active' : '' }}" id="explore-button">
	  <i class="fa fa-compass icon"></i>
	  <span>Explore</span>
	</a>
		<a href="/expense-management" class="footer-button {{ request()->is('expense-management*') ? 'active' : '' }}" id="explore-button">
				<i class="fa fa-wallet icon"></i>
				<span>Expenses</span>
		</a>
		<a href="{{ route('one_x_one') }}" class="footer-button {{ request()->routeIs('one_x_one') ? 'active' : '' }}" id="cart-button">
	  <i class="fa fa-handshake icon"></i>
	  <span>1X1</span>
	</a>
		<a href="{{ Auth::check() ? route('profile') : route('login') }}" class="footer-button {{ (Auth::check() && request()->routeIs('profile')) || (!Auth::check() && request()->routeIs('login')) ? 'active' : '' }}" id="profile-button">
	  <i class="fa fa-user icon"></i>
	  <span>Profile</span>
	</a>
  </div>
</footer>