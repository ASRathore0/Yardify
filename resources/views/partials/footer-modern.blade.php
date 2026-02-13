
<style>
/* Compact fixed mobile footer */
#footer {
	position: fixed;
	left: 0;
	right: 0;
	bottom: 0;
	background: #ffffff;
	border-top: 1px solid #e5e7eb;
	transition: transform 0.18s ease-in-out;
	transform: translateY(0);
	z-index: 1000;
	/* padding: 6px 8px; */
}
.footer-hidden {
	transform: translateY(100%) !important;
}
.footer-links {
	display: flex;
	justify-content: space-between;
	gap: 4px;
	max-width: 720px;
	margin: 0 auto;
}
.footer-button {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	padding: 6px 4px;
	color: #6b7280;
	text-decoration: none;
	font-size: 12px;
	flex: 1 1 0;
	min-width: 0;
}
.footer-button .icon { font-size: 18px; margin-bottom: 2px; }
.footer-button span { font-size: 11px; line-height: 1; }
.footer-button.active {
	color: #0f172a;
}

@media (max-width:420px) {
	.footer-button .icon { font-size:25px }
	.footer-button { padding: 5px 2px }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let lastScrollTop = 0;
    const footer = document.getElementById('footer');
    
    if (footer) {
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Only toggle if we've scrolled more than a small threshold to avoid jitter
            if (Math.abs(scrollTop - lastScrollTop) > 5) {
                if (scrollTop > lastScrollTop && scrollTop > 60) {
                    // Scrolling down & past header
                    footer.classList.add('footer-hidden');
                } else {
                    // Scrolling up
                    footer.classList.remove('footer-hidden');
                }
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, { passive: true });
    }
});
</script>

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