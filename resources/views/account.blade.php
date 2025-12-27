<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; text-align:center; margin:0; padding:0; background:#f6f7f9; }
        .container { width:90%; max-width:400px; background:#fff; padding:20px; margin:20px auto; border-radius:10px; position:relative; box-shadow:0 2px 10px rgba(0,0,0,.06); }
        .back-icon { position:absolute; top:20px; left:30px; font-size:20px; cursor:pointer; color:#333; }
        h2 { margin:0; font-size:larger; }
        .profile-pic-container { position:relative; width:120px; height:120px; margin:15px auto 0; display:flex; align-items:center; justify-content:center; background:#ccc; border-radius:50%; font-size:40px; font-weight:bold; color:#fff; border:2px solid #046c9f; overflow:hidden; }
        .profile-pic-container img { width:100%; height:100%; object-fit:cover; }
        #file-input { display:none; }
        .upload-label { cursor:pointer; font-size:14px; display:block; text-align:center; margin-top:10px; color:#046c9f; }
        .success-message { text-align:center; color:green; font-weight:bold; margin-bottom:10px; }
        form { display:flex; flex-direction:column; text-align:left; }
        label { margin-top:10px; font-weight:500; }
        .input-container { position:relative; }
        input, select { width:100%; padding:10px; margin-top:5px; border:1px solid #046c9f; border-radius:5px; font-size:16px; box-sizing:border-box; }
        input, text { color:#333; }
        .edit-icon { position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; color:#777; }
        .eye-icon { position:absolute; right:40px; top:50%; transform:translateY(-50%); cursor:pointer; color:#777; }
        button { width:100%; margin-top:20px; background:#046c9f; color:#fff; padding:10px; font-size:18px; border:none; border-radius:5px; cursor:pointer; display:block; margin-left:auto; margin-right:auto; }
        button:hover { background:#03557f; }
        @media (max-width:400px){ .container{ padding:15px; } .back-icon{ left:10px; font-size:18px;} .profile-pic-container{ width:80px; height:80px; font-size:30px;} button{ width:100%; font-size:16px;} }
    </style>
</head>
<body>
    <div class="container">
        <i class="fas fa-arrow-left back-icon" onclick="window.history.back()"></i>
        <h2>Edit Profile</h2>

        @if (session('status'))
            <div class="success-message">{{ session('status') }}</div>
        @endif

        <div class="profile-pic-container" id="profilePic">
            @if(!empty($user->avatar_url))
                <img src="{{ $user->avatar_url }}" alt="Profile Image">
            @else
                @php
                    $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
                @endphp
                <span style="font-size:40px; color:#fff;">{{ $initial }}</span>
            @endif
        </div>
        <label for="file-input" class="upload-label">Change Profile Image</label>

        <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="avatar" id="file-input" accept="image/*">

            <label for="name">Name</label>
            <div class="input-container">
                <input id="name" type="text" name="name" value="{{ old('name',$user->name) }}" required>
                <i class="fas fa-edit edit-icon" onclick="enableField('name')"></i>
            </div>
            @error('name')<small style="color:#b91c1c">{{ $message }}</small>@enderror

            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email',$user->email) }}" readonly>
            @error('email')<small style="color:#b91c1c">{{ $message }}</small>@enderror

            <label for="password">Password</label>
            <div class="input-container">
                <input id="password" type="password" name="password" placeholder="Leave blank to keep current password">
                <i class="fas fa-eye eye-icon" onclick="togglePassword()"></i>
                <i class="fas fa-edit edit-icon" onclick="enableField('password')"></i>
            </div>
            @error('password')<small style="color:#b91c1c">{{ $message }}</small>@enderror

            <label for="date_of_birth">Date of Birth</label>
            <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}">
            @error('date_of_birth')<small style="color:#b91c1c">{{ $message }}</small>@enderror

            <label for="country">Country</label>
            <select id="country" name="country">
                @php $country = old('country', $user->country ?? 'India'); @endphp
                <option value="India" {{ $country==='India' ? 'selected' : '' }}>India</option>
                <option value="United States" {{ $country==='United States' ? 'selected' : '' }}>United States</option>
                <option value="United Kingdom" {{ $country==='United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                <option value="Canada" {{ $country==='Canada' ? 'selected' : '' }}>Canada</option>
                <option value="Australia" {{ $country==='Australia' ? 'selected' : '' }}>Australia</option>
                <option value="Other" {{ $country==='Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('country')<small style="color:#b91c1c">{{ $message }}</small>@enderror

            <button type="submit">Save Changes</button>
        </form>
    </div>

    <script>
        // Enable editing for a field
        function enableField(id){ const el = document.getElementById(id); el.removeAttribute('readonly'); el.focus(); }
        // Toggle password visibility
        function togglePassword(){ const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password'; }
        // Preview avatar instantly
        const fileInput = document.getElementById('file-input');
        const profilePic = document.getElementById('profilePic');
        fileInput.addEventListener('change', e => {
            const [file] = e.target.files || []; if(!file) return;
            const url = URL.createObjectURL(file);
            profilePic.innerHTML = '';
            const img = document.createElement('img'); img.src = url; img.alt = 'Profile Image';
            profilePic.appendChild(img);
        });
    </script>
</body>
</html>
