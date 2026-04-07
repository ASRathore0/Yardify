 
<style>
/* Modern Footer Styles */
.modern-footer {
  background-color: #1f2937;
  color: #ffffff;
  padding: 40px 20px 20px;
  font-family: 'Arial', sans-serif;
  margin-top: 0;
  width: 100%;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  max-width: 100%;
  margin: 0 auto;
  gap: 30px;
  margin-top: 0;
}

.footer-logo h2 {
  font-size: 1.8em;
  color: #046c9f;
  margin-bottom: 10px;
}

.footer-logo h2 span {
  color: #046c9f;
}

.footer-logo p {
  font-size: 0.95em;
  color: #d1d5db;
  margin-bottom: 15px;
}

.footer-links {
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
}

.footer-column h4 {
  font-size: 1.1em;
  color: #046c9f;
  margin-bottom: 15px;
}

.footer-column ul {
  list-style: none;
  padding: 0;
}

.footer-column ul li {
  margin: 8px 0;
}

.footer-column ul li a {
  text-decoration: none;
  color: #d1d5db;
  transition: color 0.3s;
}

.footer-column ul li a:hover {
  color: #04A2C6;
}

.footer-newsletter h4 {
  font-size: 1.2em;
  color: #046c9f;
  margin-bottom: 10px;
}

.footer-newsletter p {
  font-size: 0.9em;
  color: #d1d5db;
  margin-bottom: 15px;
}

.footer-newsletter form {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
  flex-wrap: wrap;
}

.footer-newsletter form input {
  flex: 1;
  padding: 10px;
  border-radius: 5px;
  border: none;
  outline: none;
  min-width: 150px;
}

.footer-newsletter form button {
  padding: 10px 20px;
  background-color: #046c9f;
  border: none;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.3s;
  white-space: nowrap;
}

.footer-newsletter form button:hover {
  background-color: #04A2C6;
}

.social-icons {
  display: flex;
  gap: 35px;
  padding-left: 0;
  margin-top: 15px;
}

.social-icons a {
  font-size: 1.8em;
  color: #d1d5db;
  transition: color 0.3s;
}

.social-icons a:hover {
  color: #046c9f;
}

.footer-bottom {
  text-align: center;
  padding: 15px 0;
  font-size: 0.9em;
  color: #d1d5db;
  border-top: 1px solid #374151;
  margin-top: 20px;
}

/* Base responsive tweaks */
@media (max-width: 768px) {
  .modern-footer .footer-container {
    flex-direction: column;
    align-items: stretch;
  }
  .modern-footer .footer-links {
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px 0;
  }
  .modern-footer .footer-column {
    width: 48%; /* Forces two columns per row */
    text-align: left;
    align-items: flex-start;
    margin-bottom: 10px;
  }
  .modern-footer .footer-logo,
  .modern-footer .footer-newsletter {
    text-align: left;
  }
  .social-icons {
    justify-content: flex-start;
  }
}

/* Let's reinstate the fixed mobile footer styles here just in case they were accidentally removed and are still needed by bottom nav */
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
}
.footer-hidden {
  transform: translateY(100%) !important;
}
#footer .footer-links {
  display: flex !important;
  flex-direction: row !important;
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
.footer-button.active { color: #0f172a; }

@media (max-width:420px) {
  .footer-button .icon { font-size:25px; }
  .footer-button { padding: 5px 2px; }
  .modern-footer { padding-bottom: 80px; /* Space for the bottom fixed nav */ }
}
</style>
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
