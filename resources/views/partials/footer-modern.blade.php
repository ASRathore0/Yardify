
<style>
/* Ultra-Modern Floating Pill Footer */
#footer {
	position: fixed;
	left: 5%;
	right: 5%;
	bottom: 15px;
	background: #ffffff;
	border-radius: 20px;
	box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1), 0 3px 10px rgba(0, 0, 0, 0.05);
	transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
	transform: translateY(0);
	z-index: 1000;
	/* Ensures it doesn't get squished on larger inputs, max-width centers it */
	max-width: 500px;
	margin: 0 auto;
}

.footer-hidden {
	transform: translateY(200%) !important;
}

.footer-links {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 10px 14px;
}

.footer-button {
	display: flex;
	flex-direction: row;
	align-items: center;
	justify-content: center;
	padding: 12px 16px;
	color: #1f2937;
	text-decoration: none;
	font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
	border-radius: 30px;
	transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
	position: relative;
	overflow: hidden;
}

.footer-button .icon { 
	font-size: 22px; 
	margin-bottom: 0; 
	transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.footer-button span { 
	font-size: 15px; 
	font-weight: 600;
	white-space: nowrap;
	max-width: 0;
	opacity: 0;
	margin-left: 0;
	transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
	transform: translateX(-5px);
}

.footer-button:hover {
	color: #64748b;
}

.footer-button.active {
	background-color: rgba(4, 108, 159, 0.12);
	color: #046c9f;
	padding: 12px 20px; /* Slightly larger padding for active item */
}

.footer-button.active span {
	max-width: 100px;
	opacity: 1;
	margin-left: 8px;
	transform: translateX(0);
}

.footer-button.active .icon {
	transform: scale(1.15);
}

@media (max-width:400px) {
	#footer { left: 4%; right: 4%; bottom: 15px; }
	.footer-links { padding: 8px 10px; }
	.footer-button { padding: 12px; }
	.footer-button.active { padding: 12px 16px; }
	.footer-button .icon { font-size: 18px; }
	.footer-button span { font-size: 13px; }
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
	  <span> </span>
	</a>
		<a href="{{ route('explore') }}" class="footer-button {{ request()->routeIs('explore') || request()->is('explore*') ? 'active' : '' }}" id="explore-button">
	  <i class="fa fa-compass icon"></i>
	  <span></span>
	</a>
		<a href="/expense-management" class="footer-button {{ request()->is('expense-management*') ? 'active' : '' }}" id="explore-button">
				<i class="fa fa-wallet icon"></i>
				<span> </span>
		</a>
		<a href="{{ route('one_x_one') }}" class="footer-button {{ request()->routeIs('one_x_one') ? 'active' : '' }}" id="cart-button">
	  <i class="fa fa-handshake icon"></i>
	  <span> </span>
	</a>
		<a href="{{ Auth::check() ? route('profile') : route('login') }}" class="footer-button {{ (Auth::check() && request()->routeIs('profile')) || (!Auth::check() && request()->routeIs('login')) ? 'active' : '' }}" id="profile-button">
	  <i class="fa fa-user icon"></i>
	  <span> </span>
	</a>
  </div>
</footer>