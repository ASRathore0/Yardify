
<footer id="footer">
  <div class="footer-links">
	<a href="/" class="footer-button" id="home-button">
	  <i class="fa fa-house icon"></i>
	  <span>Home</span>
	</a>
	<a href="{{ route('explore') }}" class="footer-button" id="explore-button">
	  <i class="fa fa-compass icon"></i>
	  <span>Explore</span>
	</a>
	<a href="assets/other.html" class="footer-button" id="cart-button">
	  <i class="fa fa-handshake icon"></i>
	  <span>1X1</span>
	</a>
	<a href="{{ Auth::check() ? route('profile') : route('login') }}" class="footer-button" id="profile-button">
	  <i class="fa fa-user icon"></i>
	  <span>Profile</span>
	</a>
  </div>
</footer>

<style>
#footer {
    transition: transform 0.3s ease-in-out;
    transform: translateY(0);
    z-index: 1000;
}
.footer-hidden {
    transform: translateY(100%) !important;
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


<footer class="modern-footer">
	<div class="footer-container">
		<div class="footer-logo">
			<h2>BookingYard<span></span></h2>
			<p>"Bringing every booking services to your fingertips"</p>
		</div>

		<div class="footer-links">
			<div class="footer-column">
				<h4>Company</h4>
				<ul>
					<li><a href="assets/about.html">About Us</a></li>
					<li><a href="assets/hiring.html">Careers</a></li>
					<li><a href="#">Blog</a></li>
					<li><a href="assets/support.html">Contact</a></li>
				</ul>
			</div>
			<div class="footer-column">
				<h4>Services</h4>
				<ul>
					<li><a href="#">Events</a></li>
					<li><a href="#">Home Services</a></li>
					<li><a href="#">Cab</a></li>
					<li><a href="#">Hotels</a></li>
				</ul>
			</div>
			<div class="footer-column">
				<h4>Support</h4>
				<ul>
					<li><a href="#">FAQs</a></li>
					<li><a href="assets/T&C.html">Terms & Conditions</a></li>
					<li><a href="#">Privacy Policy</a></li>
					<li><a href="assets/support.html">Help Center</a></li>
				</ul>
			</div>

			<div class="footer-column">
			  <h4>Quick Links</h4>
			  <ul>
				  <li><a href="#">Knowledge</a></li>
				  <li><a href="#">Return & Refund</a></li>
				  <li><a href="#">Track Order</a></li>
				  <li><a href="#" style="color: #d1d5db;" onclick="downloadApk()">Download App</a></li>
				  <script>
					function downloadApk() {
					window.location.href = '/image/BookingYard.apk';
					}
				  </script>
			  </ul>
		  </div>
		</div>

		<div class="footer-newsletter">
			<h4>Stay Connected</h4>
			<p>Sign up for our newsletter to get the latest updates and offers.</p>
			<form id="subscribeForm">
	<input type="email" name="email" id="email" placeholder="Enter your email" required />
	<button type="submit">Subscribe</button>
</form>

<!-- Response message will show here -->
<p id="responseMessage" style="margin-top: 10px; font-weight: bold;"></p>

<script>
document.getElementById("subscribeForm").addEventListener("submit", async function (e) {
	e.preventDefault();

	const email = document.getElementById("email").value;
	const responseMessage = document.getElementById("responseMessage");

	try {
		const response = await fetch("subscribe.php", {
			method: "POST",
			headers: { "Content-Type": "application/json" },
			body: JSON.stringify({ email })
		});

		if (!response.ok) throw new Error("Network error");

		const result = await response.json();

		responseMessage.textContent = result.message;
		responseMessage.style.color = result.status === "success" ? "green" : "red";

		if (result.status === "success") {
			document.getElementById("subscribeForm").reset();
		}

	} catch (err) {
		responseMessage.textContent = "⚠️ Something went wrong. Please try again.";
		responseMessage.style.color = "red";
	}
});
</script>



			<div class="social-icons">
				<a href="https://www.facebook.com/people/BookingYardin/61568422323510" target="_blank"><i class="fab fa-facebook-f"></i></a>
				<a href="https://twitter.com/bookingyard" target="_blank"><i class="fab fa-twitter"></i></a>
				<a href="https://www.instagram.com/BookingYard" target="_blank"><i class="fab fa-instagram"></i></a>
				<a href="https://www.linkedin.com/company/bookingyard-in" target="_blank"><i class="fab fa-linkedin-in"></i></a>
			</div>
		</div>
	</div>
	<div class="footer-bottom">
		<p>&copy; 2025 Skynet Bookingyards Pvt Ltd. All Rights Reserved.</p>
	</div>
</footer>
