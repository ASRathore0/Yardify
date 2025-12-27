<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookingYard Sidebar</title>
  
  <!-- 1. Google Fonts (Inter is the standard for modern UI) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- 2. FontAwesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <style>
    /* --- CSS Variables for Easy Customization --- */
    :root {
      --sidebar-width: 280px;
      --bg-sidebar: #0f172a;       /* Dark Slate (Professional) */
      --bg-hover: #1e293b;         /* Slightly lighter for hover */
      --brand-color: #38bdf8;      /* Sky Blue (BookingYard Brand) */
      --text-main: #f8fafc;        /* White-ish */
      --text-muted: #94a3b8;       /* Grey text */
      --transition: cubic-bezier(0.4, 0, 0.2, 1); /* Smooth Apple-like easing */
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #f1f5f9;
    }

    /* --- Backdrop (The dark overlay) --- */
    .backdrop {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(2px); /* Modern blur effect */
      z-index: 998;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    
    .backdrop.active {
      opacity: 1;
      visibility: visible;
    }

    /* --- Sidebar Container --- */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-width);
      height: 100vh; /* Full viewport height */
      background-color: var(--bg-sidebar);
      color: var(--text-main);
      display: flex;
      flex-direction: column;
      transform: translateX(-100%); /* Hardware accelerated sliding */
      transition: transform 0.3s var(--transition);
      box-shadow: 5px 0 25px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    .sidebar.active {
      transform: translateX(0);
    }

    /* --- Header Section --- */
    .sidebar-header {
      padding: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .brand {
      font-size: 1.2rem;
      font-weight: 700;
      letter-spacing: -0.5px;
      color: white;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    
    .brand span { color: var(--brand-color); }

    .close-btn {
      background: rgba(255,255,255,0.1);
      border: none;
      color: white;
      width: 32px; height: 32px;
      border-radius: 8px;
      cursor: pointer;
      display: grid; place-items: center;
      transition: 0.2s;
    }
    .close-btn:hover { background: var(--brand-color); }

    /* --- User Profile Section (Crucial for Apps) --- */
    .user-profile {
      padding: 20px 24px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .avatar {
      width: 42px; height: 42px;
      border-radius: 50%;
      background: var(--bg-hover);
      display: grid; place-items: center;
      color: var(--brand-color);
      font-size: 1.2rem;
      border: 2px solid rgba(255,255,255,0.1);
    }

    .user-info div { font-weight: 600; font-size: 0.95rem; }
    .user-info span { font-size: 0.8rem; color: var(--text-muted); }

    /* --- Navigation Links --- */
    .nav-links {
      flex: 1; /* Pushes footer to bottom */
      padding: 10px 16px;
      overflow-y: auto; /* Scrollable if list is long */
    }

    .nav-group-label {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--text-muted);
      margin: 15px 0 8px 12px;
      font-weight: 600;
    }

    .nav-links a {
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 12px 16px;
      color: var(--text-muted);
      text-decoration: none;
      font-weight: 500;
      border-radius: 10px;
      transition: all 0.2s ease;
      margin-bottom: 4px;
    }

    .nav-links a i {
      width: 20px;
      text-align: center;
      font-size: 1.1rem;
    }

    /* Hover State */
    .nav-links a:hover {
      background-color: var(--bg-hover);
      color: white;
      transform: translateX(4px); /* Subtle slide effect */
    }

    /* Active State */
    .nav-links a.active {
      background-color: var(--brand-color);
      color: #0f172a; /* Dark text for contrast */
      font-weight: 700;
    }

    /* --- Footer (Logout/Version) --- */
    .sidebar-footer {
      padding: 20px 24px;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logout-link {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #ef4444; /* Red for destructive action */
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: opacity 0.2s;
    }
    .logout-link:hover { opacity: 0.8; }

    /* --- Toggle Button for Demo --- */
    .open-btn {
      position: fixed; top: 20px; left: 20px;
      padding: 12px 24px;
      background: #0f172a; color: white;
      border: none; border-radius: 8px;
      font-weight: 600; cursor: pointer;
      display: flex; align-items: center; gap: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <!-- Demo Button to Open Sidebar -->
  <button class="open-btn" onclick="toggleSidebar()">
    <i class="fa-solid fa-bars"></i> Menu
  </button>

  <!-- 1. The Backdrop (Dark overlay) -->
  <div class="backdrop" id="backdrop" onclick="toggleSidebar()"></div>

  <!-- 2. The Sidebar -->
  <aside class="sidebar" id="sidebar">
    
    <!-- Header -->
    <div class="sidebar-header">
      <div class="brand">
        <i class="fa-solid fa-layer-group" style="color:#38bdf8"></i>
        <span>Booking</span>Yard
      </div>
      <button class="close-btn" onclick="toggleSidebar()">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- User Profile (Builds trust) -->
    <!-- <div class="user-profile">
      <div class="avatar">
        <i class="fa-regular fa-user"></i>
      </div>
      <div class="user-info">
        <div>Guest User</div>
        <span>Welcome to BookingYard</span>
      </div>
    </div> -->

    <!-- Navigation -->
    <nav class="nav-links">
      <div class="nav-group-label">Menu</div>
      
      <!-- Example Active Link -->
      <a href="#" class="active">
        <i class="fa-solid fa-house"></i> Home
      </a>
      
      <a href="assets/services.html">
        <i class="fa-solid fa-briefcase"></i> Services
      </a>

      <div class="nav-group-label">Company</div>

      <a href="assets/about.html">
        <i class="fa-solid fa-building"></i> About Us
      </a>
      <a href="assets/hiring.html">
        <i class="fa-solid fa-users-viewfinder"></i> We are hiring
        <span style="font-size:10px; background:#10b981; color:#fff; padding:2px 6px; border-radius:4px; margin-left:auto;">New</span>
      </a>

      <div class="nav-group-label">Support</div>

      <a href="assets/other.html">
        <i class="fa-solid fa-circle-question"></i> FAQ
      </a>
      <a href="assets/support.html">
        <i class="fa-solid fa-headset"></i> Help & Support
      </a>
    </nav>

    <!-- Footer -->
    <div class="sidebar-footer">
      <a href="#" class="logout-link">
        <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
      </a>
    </div>

  </aside>

  <!-- JavaScript to handle toggle -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const backdrop = document.getElementById('backdrop');
      
      // Toggle the 'active' class
      sidebar.classList.toggle('active');
      backdrop.classList.toggle('active');
    }
  </script>

</body>
</html>