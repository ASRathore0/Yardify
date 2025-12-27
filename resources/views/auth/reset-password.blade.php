<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <style> body{font-family:Arial, sans-serif; background:#f4f6f8; display:flex; align-items:center; justify-content:center; height:100vh;} .card{background:#fff; padding:24px; border-radius:10px; width:100%; max-width:380px; box-shadow:0 2px 12px rgba(0,0,0,.06);} .row{margin-bottom:14px;} label{display:block; margin-bottom:6px; color:#333;} input{width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;} button{background:#046c9f; color:#fff; border:none; padding:10px 16px; border-radius:6px; cursor:pointer;} .error{color:#b91c1c; font-size:.85rem;} a{color:#046c9f; text-decoration:none;} </style>
</head>
<body>
  <div class="card">
    <h2>Reset Password</h2>
    <form method="POST" action="{{ route('password.update') }}"> @csrf
      <input type="hidden" name="token" value="{{ $token }}" />
      <input type="hidden" name="email" value="{{ request('email') }}" />
      <div class="row">
        <label for="password">New Password</label>
        <input id="password" type="password" name="password" required />
        @error('password') <div class="error">{{ $message }}</div> @enderror
      </div>
      <div class="row">
        <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required />
      </div>
      <button type="submit">Reset Password</button>
    </form>
    <p style="margin-top:12px;"><a href="{{ route('login') }}">Back to Login</a></p>
  </div>
</body>
</html>
