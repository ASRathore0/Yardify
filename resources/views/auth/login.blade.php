<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookingYard - Login / Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        :root{
          --primary:#046c9f; --primary-600:#035a85; --bg:#f3f6f8; --text:#1f2937; --muted:#6b7280; --ring:#93c5fd;
          --error:#dc2626; --success:#059669;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
        body { background:linear-gradient(135deg,#e6f3f8 0%, #f7fbfd 100%); min-height:100vh; display:flex; justify-content:center; align-items:center; padding:24px; }
        .container { background:#fff; padding:28px; border-radius:16px; box-shadow:0 20px 45px rgba(3,90,133,.15); width:100%; max-width:440px; }
        .header { text-align:center; margin-bottom:18px; }
        .title { color:var(--text); font-weight:700; font-size:1.75rem; letter-spacing:.2px; }
        .subtitle { color:var(--muted); font-size:.95rem; margin-top:6px; }

        .input-box { position:relative; margin:16px 0; }
        .input-box label { position:absolute; top:-9px; left:12px; background:#fff; padding:0 6px; color:var(--primary); font-size:.8rem; pointer-events:none; border-radius:4px; }
        .input-box input { width:100%; padding:12px 44px 12px 44px; border:1px solid #cfe6f0; border-radius:10px; font-size:1rem; outline:none; transition:.18s border-color ease, .18s box-shadow ease; }
        .input-box input:focus { border-color: var(--primary); box-shadow:0 0 0 4px rgba(4,108,159,.10); }
        .input-box .left-icon { position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:18px; color:#7aa6b9; pointer-events:none; }
        .toggle-password { position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#7aa6b9; }

        .row-between { display:flex; justify-content:space-between; align-items:center; margin-top:6px; }
        .forgot { font-size:.9rem; color:var(--muted); text-decoration:none; }
        .forgot:hover { color:var(--primary); }

        .btn { width:100%; padding:12px 16px; background:var(--primary); border:none; color:#fff; font-size:1rem; font-weight:600; border-radius:10px; cursor:pointer; transition:.18s background ease, .18s transform ease; }
        .btn:hover { background:var(--primary-600); transform:translateY(-1px); }
        .btn:disabled { opacity:.6; cursor:not-allowed; transform:none; }

        .or { position:relative; text-align:center; margin:18px 0; color:#9ca3af; font-weight:600; }
        .or::before, .or::after { content:""; position:absolute; top:50%; height:1px; width:40%; background:#e5e7eb; }
        .or::before { left:0; } .or::after { right:0; }

        .social-login { display:flex; gap:12px; }
        .social-link { flex:1; display:flex; align-items:center; justify-content:center; height:44px; border-radius:10px; text-decoration:none; color:#111; border:1px solid #e5e7eb; transition:.18s transform ease, .18s box-shadow ease; background:#fff; }
        .social-link:hover { transform:translateY(-1px); box-shadow:0 8px 22px rgba(0,0,0,.06); }
        .social-link i { font-size:18px; margin-right:8px; }
        .social-google { border-color:#e5e7eb; }
        .social-facebook { background:#1877F2; color:#fff; border-color:#1877F2; }
        .social-apple { background:#000; color:#fff; border-color:#000; }
        .social-link.disabled { opacity:.55; cursor:not-allowed; pointer-events:none; }

        .switch { text-align:center; margin-top:16px; color:var(--muted); font-size:.95rem; }
        .switch a { color:var(--primary); text-decoration:none; font-weight:600; }
        .switch a:hover { text-decoration:underline; }

        .flash { margin:8px 0 12px; padding:10px 12px; font-size:.9rem; border-radius:10px; display:none; border:1px solid transparent; }
        .flash.success { background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
        .flash.error { background:#fef2f2; color:#991b1b; border-color:#fecaca; }

        .error { color:var(--error); font-size:.8rem; margin-top:6px; }
        @media (max-width:520px){ body{ padding:16px;} .container{ padding:22px;} }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
          <div class="title">Welcome back</div>
          <div class="subtitle">Login to continue to BookingYard</div>
        </div>
        <div id="flash" class="flash"></div>
        <div id="loginBox">
            <form id="loginForm">
                <div class="input-box">
                    <label for="loginEmail">Email</label>
                    <i class="fas fa-envelope left-icon"></i>
                    <input type="email" id="loginEmail" name="email" placeholder="Enter your email" required />
                    <div class="error" data-error-for="loginEmail"></div>
                </div>
                <div class="input-box">
                    <label for="loginPassword">Password</label>
                    <i class="fas fa-lock left-icon"></i>
                    <input type="password" id="loginPassword" name="password" placeholder="Enter your password" required />
                    <i class="fas fa-eye toggle-password" data-toggle-for="loginPassword"></i>
                    <div class="error" data-error-for="loginPassword"></div>
                </div>
                <div class="row-between">
                    <a href="{{ route('password.request') }}" class="forgot">Forgot your password?</a>
                </div>
                <button class="btn" type="submit" id="loginBtn">Sign in</button>
            </form>
            <div class="or">Or continue with</div>
            <div class="social-login">
                 <a title="Continue with Google" aria-label="Continue with Google" href="{{ route('social.redirect','google') }}" class="social-link social-google"><i class="fab fa-google"></i></a>
                 <a title="Continue with Facebook" aria-label="Continue with Facebook" href="{{ route('social.redirect','facebook') }}" class="social-link social-facebook"><i class="fab fa-facebook"></i></a>
                 <a title="Continue with Apple" aria-label="Continue with Apple" href="{{ route('social.redirect','apple') }}" class="social-link social-apple"><i class="fab fa-apple"></i></a>
            </div>
            <div class="switch">Don’t have an account? <a href="#" id="showRegister">Create one</a></div>
        </div>

    <div id="registerSection" style="display:none;">
            <div class="header" style="margin-top:-8px;">
              <div class="title">Create your account</div>
              <div class="subtitle">Sign up to get started</div>
            </div>
            <form id="registerForm">
                <div class="input-box">
                    <label for="fullName">Name</label>
                    <input type="text" id="fullName" name="name" placeholder="Full Name" required />
                    <div class="error" data-error-for="fullName"></div>
                </div>
                <div class="input-box">
                    <label for="registerEmail">Email</label>
                    <input type="email" id="registerEmail" name="email" placeholder="Enter your email" required />
                    <div class="error" data-error-for="registerEmail"></div>
                </div>
                <div class="input-box">
                    <label for="registerPassword">Password</label>
                    <input type="password" id="registerPassword" name="password" placeholder="Create password" required />
                    <div class="error" data-error-for="registerPassword"></div>
                </div>
                <div class="input-box">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="password_confirmation" placeholder="Confirm password" required />
                    <div class="error" data-error-for="confirmPassword"></div>
                </div>
                <button class="btn" type="submit" id="registerBtn">Create account</button>
            </form>
            <div class="switch">Already have an account? <a href="#" id="showLogin">Sign in</a></div>
        </div>
    </div>

<script>
// Toggle Password
function toggleVisibility(id){ const field=document.getElementById(id); field.type = field.type==='password'?'text':'password'; }

document.querySelectorAll('.toggle-password').forEach(el=>{
  el.addEventListener('click',()=>{ toggleVisibility(el.getAttribute('data-toggle-for')); el.classList.toggle('fa-eye-slash'); });
});

// Switch Forms
const loginBox=document.getElementById('loginBox');
const registerSection=document.getElementById('registerSection');

document.getElementById('showRegister').addEventListener('click', e=>{ e.preventDefault(); loginBox.style.display='none'; registerSection.style.display='block'; });

document.getElementById('showLogin').addEventListener('click', e=>{ e.preventDefault(); loginBox.style.display='block'; registerSection.style.display='none'; });

function flash(msg,type='success'){ const box=document.getElementById('flash'); box.textContent=msg; box.className='flash '+type; box.style.display='block'; setTimeout(()=>{box.style.display='none';},4000); }
function setErrors(container, errors){ Object.entries(errors).forEach(([field,msgs])=>{ const errEl=document.querySelector(`[data-error-for="${field}"]`); if(errEl){ errEl.textContent=Array.isArray(msgs)?msgs[0]:msgs; } }); }
function clearErrors(){ document.querySelectorAll('.error').forEach(e=>e.textContent=''); }

async function postJson(url, data, btn){
  const token=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  btn.disabled=true; clearErrors();
  try {
        // include optional redirect param from querystring
        try{
            const params = new URLSearchParams(window.location.search);
            const redirect = params.get('redirect');
            if(redirect) data.redirect = redirect;
        }catch(e){}
        const res= await fetch(url,{ method:'POST', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json' }, body: JSON.stringify(data)});
    const json= await res.json();
    if(res.ok && json.status==='success'){ flash('Success! Redirecting...','success'); setTimeout(()=>{ window.location.href = json.redirect; },600); }
    else if(res.status===422){ if(json.errors) setErrors(btn.form, json.errors); flash(json.message||'Validation error','error'); }
    else { flash(json.message||'Request failed','error'); }
  } catch(e){ flash('Network error','error'); }
  finally { btn.disabled=false; }
}

// Login Submit
const loginForm=document.getElementById('loginForm');
loginForm.addEventListener('submit', e=>{ e.preventDefault(); postJson('{{ route('login.submit') }}', { email: loginForm.loginEmail.value, password: loginForm.loginPassword.value }, document.getElementById('loginBtn')); });

// Register Submit
const registerForm=document.getElementById('registerForm');
registerForm.addEventListener('submit', e=>{ e.preventDefault(); if(registerForm.registerPassword.value !== registerForm.confirmPassword.value){ flash('Passwords do not match','error'); return; } postJson('{{ route('register.submit') }}', { name: registerForm.fullName.value, email: registerForm.registerEmail.value, password: registerForm.registerPassword.value, password_confirmation: registerForm.confirmPassword.value }, document.getElementById('registerBtn')); });
// Disabled social link click hint
document.querySelectorAll('.social-link.disabled').forEach(a=>{
    a.addEventListener('click', e=>{ e.preventDefault(); flash('This provider is not configured yet. Please contact support or try another option.','error'); });
});
// Show server flash status if present (e.g., after password reset email)
@if (session('status'))
    flash(@json(session('status')),'success');
@endif
@if ($errors->any())
    flash(@json(collect($errors->all())->join('\n')),'error');
@endif
</script>
</body>
</html>
