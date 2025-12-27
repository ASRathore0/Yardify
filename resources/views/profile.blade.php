<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('image/icon.ico.jpg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
       * { margin:0; padding:0; box-sizing:border-box; font-family: Arial, sans-serif; }
       body { display:flex; justify-content:center; align-items:center; width:100vw; height:100vh; background:#f8f9fa; overflow:hidden; }
       .container { width:100%; max-width:380px; height:100vh; background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.1); display:flex; flex-direction:column; }
       .header { display:flex; align-items:center; justify-content:space-between; padding:15px 5px; }
       .profile { display:flex; align-items:center; }
    .avatar { width:50px; height:50px; background:#ddd; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.2rem; overflow:hidden; }
    .avatar img { width:100%; height:100%; object-fit:cover; display:block; }
       .sign-in-text { font-size:1.2rem; margin-left:12px; font-weight:600; cursor:pointer; }
       .icons { display:flex; gap:40px; font-size:1.4rem; }
       .settings { font-weight:500; padding-top:10px; border-top:1px solid #ccc; margin-bottom:10px; }
       .menu-item { display:flex; align-items:center; justify-content:space-between; padding:12px; background:#ebe8e84d; margin:3px 0; border-radius:8px; cursor:pointer; transition:background .3s; }
       .menu-item:hover { background:#e2e2e2; }
       .menu-left { display:flex; align-items:center; }
       .icon { font-size:1.5rem; margin-right:12px; color:#046c9f; }
       .arrow { font-size:1.3rem; color:rgba(128,128,128,.664); }
       @media (max-width: 768px){ .container { max-width:100%; height:100vh; padding:16px; border-radius:0; } .sign-in-text{ font-size:1rem;} .avatar{ width:45px; height:45px; font-size:1rem;} .icons{ font-size:1.2rem;} .menu-item{ padding:14px;} .icon{ font-size:1.3rem;} }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="profile">
                <div class="avatar">
                    @if(Auth::check() && Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }} avatar">
                    @else
                        <i class="fa-solid fa-user"></i>
                    @endif
                </div>
                <span class="sign-in-text">{{ Auth::check() ? Auth::user()->name : 'Guest User' }}</span>
            </div>
            <div class="icons">
                <i class="fa-solid fa-right-left" title="Switch" onclick="window.location.href='{{ route('vendor.entry') }}'"></i>
                <i class="fa-solid fa-xmark" title="Close" onclick="closeProfile()"></i>
            </div>
        </div>
        <div class="settings">Personal Settings</div>
        <div class="menu-item" onclick="alert('Change your Language...')">
            <div class="menu-left"><i class="fa-solid fa-globe icon"></i> Language</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        <div class="menu-item" onclick="window.location.href='{{ route('account.show') }}'">
            <div class="menu-left"><i class="fa-solid fa-user icon"></i> Your Account</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        <div class="menu-item" onclick="window.location.href='{{ route('wallet') }}'">
            <div class="menu-left"><i class="fa-solid fa-wallet icon"></i> Wallet</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        <div class="menu-item" onclick="window.location.href='{{ route('vendor.form') }}'">
            <div class="menu-left"><i class="fa-solid fa-store icon"></i> Become Vendor</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        <div class="menu-item" onclick="alert('Favorite Vendor')">
            <div class="menu-left"><i class="fa-solid fa-heart icon"></i> Favorite Vendor</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        <div class="menu-item" onclick="window.location.href='{{ route('refer.earn') }}'">
            <div class="menu-left"><i class="fa-solid fa-gift icon"></i> Refer & Earn</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        <div class="menu-item" onclick="alert('Policy')">
            <div class="menu-left"><i class="fa-solid fa-shield-halved icon"></i> Policy</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        <div class="menu-item" onclick="window.location.href='{{ url('terms') }}'">
            <div class="menu-left"><i class="fa-solid fa-file-lines icon"></i> Terms & Conditions</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        @if(Auth::check())
        <div class="menu-item" onclick="document.getElementById('logout-form').submit()">
            <div class="menu-left"><i class="fa-solid fa-right-from-bracket icon"></i> Logout</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        @else
        <div class="menu-item" onclick="window.location.href='{{ route('login') }}'">
            <div class="menu-left"><i class="fa-solid fa-right-to-bracket icon"></i> Login</div><i class="fa-solid fa-arrow-right arrow"></i>
        </div>
        @endif
    </div>
<script>
function closeProfile(){ window.location.href = '{{ url('/') }}'; }
</script>
</body>
</html>
