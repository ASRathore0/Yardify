<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Modern Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #046c9f;
            --primary-hover: #03557f;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            padding: 0; 
            background: var(--bg-color); 
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container { 
            width: 95%; 
            max-width: 450px; 
            background: var(--card-bg); 
            padding: 40px 30px; 
            margin: 20px; 
            border-radius: 20px; 
            position: relative; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); 
        }

        /* Header Navigation */
        .header-nav {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 30px;
        }

        .back-icon { 
            position: absolute; 
            left: 0; 
            font-size: 18px; 
            cursor: pointer; 
            color: var(--text-muted); 
            transition: color 0.2s;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f1f5f9;
        }
        .back-icon:hover { color: var(--primary-color); background: #e0e7ff; }

        h2 { margin: 0; font-size: 1.25rem; font-weight: 700; color: var(--text-main); }

        /* Avatar Styling */
        .avatar-section {
            position: relative;
            width: 110px;
            height: 110px;
            margin: 0 auto 30px;
        }

        .profile-pic-container { 
            width: 100%; 
            height: 100%; 
            background: #e2e8f0; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border: 4px solid var(--card-bg); 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden; 
        }

        .profile-pic-container img { width: 100%; height: 100%; object-fit: cover; }
        
        .upload-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: var(--primary-color);
            color: white;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid var(--card-bg);
            transition: transform 0.2s;
        }
        .upload-badge:hover { transform: scale(1.1); }

        /* Form Controls */
        #file-input { display: none; }
        .success-message { 
            background: #dcfce7; 
            color: #166534; 
            padding: 12px; 
            border-radius: 8px; 
            font-size: 14px; 
            margin-bottom: 20px; 
            text-align: center;
        }

        form { display: flex; flex-direction: column; }
        
        .form-group { margin-bottom: 18px; }
        
        label { 
            display: block;
            margin-bottom: 6px; 
            font-weight: 600; 
            font-size: 0.85rem; 
            color: var(--text-muted);
        }

        .input-wrapper { position: relative; display: flex; align-items: center; }

        input, select { 
            width: 100%; 
            padding: 12px 14px; 
            border: 1.5px solid var(--border-color); 
            border-radius: 10px; 
            font-size: 15px; 
            transition: all 0.2s;
            background: #fdfdfd;
            color: var(--text-main);
        }

        input:focus, select:focus { 
            outline: none; 
            border-color: var(--primary-color); 
            background: #fff;
            box-shadow: 0 0 0 4px rgba(4, 108, 159, 0.1);
        }

        input[readonly] { background: #f1f5f9; cursor: not-allowed; color: var(--text-muted); }

        .input-icon { 
            position: absolute; 
            right: 12px; 
            color: var(--text-muted); 
            cursor: pointer; 
            font-size: 14px;
            transition: color 0.2s;
        }
        .input-icon:hover { color: var(--primary-color); }
        .eye-icon { right: 40px; }

        button { 
            width: 100%; 
            margin-top: 15px; 
            background: var(--primary-color); 
            color: #fff; 
            padding: 14px; 
            font-size: 16px; 
            font-weight: 600;
            border: none; 
            border-radius: 12px; 
            cursor: pointer; 
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(4, 108, 159, 0.2);
        }

        button:hover { 
            background: var(--primary-hover); 
            box-shadow: 0 6px 15px rgba(4, 108, 159, 0.3);
            transform: translateY(-1px);
        }

        .error-text { color: #e11d48; font-size: 12px; margin-top: 4px; display: block; }

        @media (max-width: 480px) {
            .container { padding: 30px 20px; border-radius: 0; width: 100%; height: 100vh; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-nav">
            <i class="fas fa-arrow-left back-icon" onclick="window.history.back()"></i>
            <h2>Edit Profile</h2>
        </div>

        @if (session('status'))
            <div class="success-message">
                <i class="fas fa-circle-check"></i> {{ session('status') }}
            </div>
        @endif

        <div class="avatar-section">
            <div class="profile-pic-container" id="profilePic">
                @if(!empty($user->avatar_url))
                    <img src="{{ $user->avatar_url }}" alt="Profile Image">
                @else
                    @php
                        $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
                    @endphp
                    <span style="font-size:40px; font-weight:700; color:var(--primary-color);">{{ $initial }}</span>
                @endif
            </div>
            <label for="file-input" class="upload-badge">
                <i class="fas fa-camera"></i>
            </label>
        </div>

        <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="avatar" id="file-input" accept="image/*">

            <div class="form-group">
                <label for="name">Full Name</label>
                <div class="input-wrapper">
                    <input id="name" type="text" name="name" value="{{ old('name',$user->name) }}" required readonly>
                    <i class="fas fa-pen-to-square input-icon" onclick="enableField('name')"></i>
                </div>
                @error('name')<small class="error-text">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <input id="email" type="email" name="email" value="{{ old('email',$user->email) }}" readonly>
                </div>
                @error('email')<small class="error-text">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input id="password" type="password" name="password" placeholder="••••••••" readonly>
                    <i class="fas fa-eye eye-icon input-icon" onclick="togglePassword()"></i>
                    <i class="fas fa-pen-to-square input-icon" onclick="enableField('password')"></i>
                </div>
                <small style="font-size: 11px; color: var(--text-muted);">Leave blank to keep current password</small>
                @error('password')<small class="error-text">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input id="date_of_birth" type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}">
                @error('date_of_birth')<small class="error-text">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
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
                @error('country')<small class="error-text">{{ $message }}</small>@enderror
            </div>

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <script>
        function enableField(id){ 
            const el = document.getElementById(id); 
            el.removeAttribute('readonly'); 
            el.style.background = "#fff";
            el.focus(); 
        }

        function togglePassword(){ 
            const p = document.getElementById('password'); 
            p.type = p.type === 'password' ? 'text' : 'password'; 
        }

        const fileInput = document.getElementById('file-input');
        const profilePic = document.getElementById('profilePic');
        fileInput.addEventListener('change', e => {
            const [file] = e.target.files || []; if(!file) return;
            const url = URL.createObjectURL(file);
            profilePic.innerHTML = '';
            const img = document.createElement('img'); img.src = url; 
            profilePic.appendChild(img);
        });
    </script>
</body>
</html>