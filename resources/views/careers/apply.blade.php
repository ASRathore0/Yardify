<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Careers — BookingYard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>

    @include('partials.header')
    
    @include('partials.sidebar')
    
     
     
</div>
  <section class="hiring-section">
    <h1>Join Our Team at BookingYard.in!</h1>
    <p>Are you passionate about transforming the booking industry? We’re looking for talented individuals to join our team!</p>

    <h2>Current Open Positions</h2>
    <ul class="positions">
      <li>Business Development Manager</li>
      <li>Full-Stack Web Developer</li>
      <li>UI/UX Designer</li>
      <li>Digital Marketing Specialist</li>
      <li>SEO Specialist</li>
    </ul>

    <form id="applicationForm" class="application-form" action="{{ route('careers.submit') }}" method="post" enctype="multipart/form-data">
      @csrf
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required>

      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" required>

      <label for="position">Position Applied For</label>
      <select id="position" name="position" required>
        <option value="">Select Position</option>
        <option value="Business Development Manager">Business Development Manager</option>
        <option value="Full-Stack Web Developer">Full-Stack Web Developer</option>
        <option value="UI/UX Designer">UI/UX Designer</option>
        <option value="Digital Marketing Specialist">Digital Marketing Specialist</option>
        <option value="SEO Specialist">SEO Specialist</option>
      </select>

      <label for="location">Location</label>
      <input type="text" id="location" name="location" required>

      <label for="linkedin">LinkedIn Profile (optional)</label>
      <input type="url" id="linkedin" name="linkedin">

      <label for="resume">Resume (PDF or Word)</label>
      <input type="file" id="resume" name="resume" accept=".pdf, .doc, .docx" required>

      <label for="statement">Why do you want to join BookingYard.in?</label>
      <textarea id="statement" name="statement" rows="4" required></textarea>

      <label for="start-date">Availability to Start</label>
      <input type="date" id="start-date" name="start_date" required>

      <button type="submit">Apply Now</button>
    </form>

    <p id="responseMessage" style="margin-top: 10px; font-weight: bold;"></p>

     

    <div id="confirmationMessage" class="confirmation-message">
      Thank you for your interest in joining BookingYard.in! Our team will review your application and contact you if we find a match.
    </div>
  </section>

   @include('partials.footer-mobile')
    @include('partials.footer-modern')

  <script src="js/script.js"></script>
  <script src="js/script1.js"></script>
</body>

</html>
