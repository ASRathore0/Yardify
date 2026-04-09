<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>BookingYard - Login / Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: { brand: '#046c9f', brandDark: '#12304a', brandAccent: '#1e86ba' }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #12304a; overflow-x: hidden; }
        
        .input-field {
            width: 100%; border: 1px solid transparent; border-radius: 9999px;
            padding: 16px 44px 16px 44px; font-size: 14px; font-weight: 600;
            color: #1e293b; background-color: #f8fafc; transition: all 0.2s;
        }
        .input-field::placeholder { color: #94a3b8; font-weight: 500; }
        .input-field:focus, .input-field.filled { 
            border-color: #1e293b; background-color: #fff; outline: none; 
        }
        
        .form-icon-left { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px; z-index: 10; transition: color 0.2s; }
        .input-field:focus ~ .form-icon-left, .input-field.filled ~ .form-icon-left { color: #1e293b; }
        
        .form-icon-right { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 15px; cursor: pointer; z-index: 10; }
        
        .custom-checkbox { appearance: none; width: 18px; height: 18px; border: 2px solid #cbd5e1; border-radius: 4px; position: relative; cursor: pointer; transition: all 0.2s; }
        .custom-checkbox:checked { background-color: #12304a; border-color: #12304a; }
        .custom-checkbox:checked::after { content: '\f00c'; font-family: 'Font Awesome 6 Free'; font-weight: 900; color: white; font-size: 10px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        
        .brand-text { background: linear-gradient(to right, #046c9f, #0ea5e9); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .bg-hexagons {
            background-color: #12304a;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='103.92' viewBox='0 0 60 103.92' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 103.92L0 86.6V52.2l30-17.32 30 17.32v34.4zm0-3.46l27-15.59V53.92L30 38.33 3 53.92v30.95z' fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
            background-position: top center;
            background-repeat: repeat-x;
        }
        
        .card-shadow { box-shadow: 0 30px 60px rgba(0,0,0,0.15); }
        .btn-shadow { box-shadow: 0 10px 25px -5px rgba(18,48,74,0.4); }
        
        #flash { display: none; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 bg-hexagons relative text-slate-800">
    
    <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] rounded-full bg-white/5 blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-[400px] relative z-10 flex flex-col items-center">
        
        <!-- White Form Card -->
        <div class="bg-white w-full rounded-[2.5rem] px-6 py-12 card-shadow relative overflow-hidden mb-8 mt-4 border border-white/10">
            <div id="flash" class="mb-4 p-3 rounded-xl text-sm font-bold text-center"></div>

            <!-- LOGIN SECTION -->
            <div id="loginBox">
                <!-- Logo -->
                <div class="flex justify-center items-center mb-10 mt-2">
                    <span class="text-[36px] font-extrabold tracking-tight text-black leading-none">Booking<span class="text-[#046c9f]">Yard</span></span>
                </div>

                <form id="loginForm">
                    <!-- Email -->
                    <div class="mb-5 relative group">
                        <input type="email" name="loginEmail" id="loginEmail" required class="input-field" placeholder="example@gmail.com">
                        <i class="fa-regular fa-envelope form-icon-left"></i>
                        <i class="fa-solid fa-circle-check absolute right-5 top-1/2 -translate-y-1/2 text-[#12304a] hidden check-icon text-[16px] z-10"></i>
                    </div>

                    <!-- Password -->
                    <div class="mb-5 relative group">
                        <input type="password" name="loginPassword" id="loginPassword" required class="input-field" placeholder="Enter your password">
                        <i class="fa-solid fa-lock form-icon-left text-[14px]"></i>
                        <i class="fa-regular fa-eye form-icon-right toggle-password" data-target="loginPassword"></i>
                        <div class="text-red-500 text-xs mt-1 px-4 font-medium absolute -bottom-5" data-error-for="loginPassword"></div>
                    </div>

                    <!-- Options -->
                    <div class="flex justify-between items-center mb-8 px-2 mt-7">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" class="custom-checkbox">
                            <span class="text-[13px] font-bold text-[#12304a] transition">Remember me</span>
                        </label>
                        <a href="#" class="text-[13px] font-bold text-[#12304a] transition">Forgot password</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" id="loginBtn" class="w-full bg-[#12304a] hover:bg-[#1a4469] text-white rounded-full py-[16px] font-bold text-[15px] btn-shadow transition-all transform hover:-translate-y-1 active:translate-y-0">
                        Sign in
                    </button>
                </form>
            </div>

            <!-- REGISTER SECTION -->
            <div id="registerSection" class="hidden">
                 <div class="flex justify-center items-center mb-8 mt-2">
                    <span class="text-[34px] font-extrabold tracking-tight text-black leading-none">Booking<span class="text-[#046c9f]">Yard</span></span>
                </div>

                <form id="registerForm">
                    <div class="mb-4 relative">
                        <input type="text" name="fullName" required class="input-field" placeholder="Full Name">
                        <i class="fa-regular fa-user form-icon-left text-[14px]"></i>
                        <div class="text-red-500 text-xs mt-1 px-4 font-medium absolute -bottom-5" data-error-for="fullName"></div>
                    </div>

                    <div class="mb-4 relative">
                        <input type="email" name="registerEmail" required class="input-field" placeholder="Email Address">
                        <i class="fa-regular fa-envelope form-icon-left text-[14px]"></i>
                        <div class="text-red-500 text-xs mt-1 px-4 font-medium absolute -bottom-5" data-error-for="registerEmail"></div>
                    </div>

                    <div class="mb-4 relative">
                        <input type="password" name="registerPassword" id="registerPassword" required class="input-field" placeholder="Create a password">
                        <i class="fa-solid fa-lock form-icon-left text-[14px]"></i>
                        <i class="fa-regular fa-eye form-icon-right toggle-password" data-target="registerPassword"></i>
                        <div class="text-red-500 text-xs mt-1 px-4 font-medium absolute -bottom-5" data-error-for="registerPassword"></div>
                    </div>

                    <div class="mb-7 relative">
                        <input type="password" name="confirmPassword" id="confirmPassword" required class="input-field" placeholder="Confirm password">
                        <i class="fa-solid fa-shield-halved form-icon-left text-[14px]"></i>
                        <i class="fa-regular fa-eye form-icon-right toggle-password" data-target="confirmPassword"></i>
                    </div>

                    <button type="submit" id="registerBtn" class="w-full bg-[#12304a] hover:bg-[#1a4469] text-white rounded-full py-[16px] font-bold text-[15px] btn-shadow transition-all transform hover:-translate-y-1 active:translate-y-0">
                        Create Account
                    </button>
                </form>
            </div>
        </div>

        <!-- Social Icons -->
        <div class="flex gap-4 justify-center mb-6">
            <a href="{{ route('social.redirect','google') }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow text-[20px] transition-transform hover:scale-110">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-[20px] h-[20px]" alt="Google">
            </a>
            <a href="{{ route('social.redirect','facebook') }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-[#1877F2] text-[24px] shadow transition-transform hover:scale-110">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="{{ route('social.redirect','apple') }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-black text-[24px] shadow transition-transform hover:scale-110">
                <i class="fab fa-apple"></i>
            </a>
        </div>
        
        <!-- Toggle Text -->
        <div class="text-center mt-2">
            <p id="footerToggleText" class="text-[13px] font-medium text-slate-300">
                Don't have an account? <button type="button" id="footerToggle" class="text-[#e27d60] hover:text-[#fb923c] font-bold transition ml-1" style="color: #e38260;">Sign Up here</button>
            </p>
        </div>

    </div>

<script>
    // Input styling toggle (Filled vs Empty)
    const inputs = document.querySelectorAll('.input-field');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            if(input.value.length > 0) input.classList.add('filled');
            else input.classList.remove('filled');
        });
    });

    // Checkicon logic for main login email
    const loginEmail = document.getElementById('loginEmail');
    const checkIcon = document.querySelector('.check-icon');
    if (loginEmail && checkIcon) {
        loginEmail.addEventListener('input', (e) => {
            if(e.target.value.includes('@') && e.target.value.includes('.')){
                checkIcon.classList.remove('hidden');
            } else {
                checkIcon.classList.add('hidden');
            }
        });
    }

    // Toggle Password
    document.querySelectorAll('.toggle-password').forEach(el => {
        el.addEventListener('click', () => {
            const targetId = el.getAttribute('data-target');
            const field = document.getElementById(targetId);
            if(field.type === 'password') {
                field.type = 'text';
                el.classList.remove('fa-eye');
                el.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                el.classList.remove('fa-eye-slash');
                el.classList.add('fa-eye');
            }
        });
    });

    // Form Switching
    const loginBox = document.getElementById('loginBox');
    const registerSection = document.getElementById('registerSection');
    const footerToggleText = document.getElementById('footerToggleText');

    function showRegisterForm() {
        loginBox.style.display = 'none';
        registerSection.style.display = 'block';
        footerToggleText.innerHTML = 'Already have an account? <button type="button" onclick="showLoginForm()" class="font-bold transition ml-1" style="color: #e38260;">Sign in here</button>';
    }

    function showLoginForm() {
        loginBox.style.display = 'block';
        registerSection.style.display = 'none';
        footerToggleText.innerHTML = 'Don\'t have an account? <button type="button" onclick="showRegisterForm()" class="font-bold transition ml-1" style="color: #e38260;">Sign Up here</button>';
    }

    document.getElementById('footerToggle').addEventListener('click', showRegisterForm);

    // Flash & Errors
    const flashBox = document.getElementById('flash');
    function flash(msg, type='success'){ 
        flashBox.textContent = msg; 
        flashBox.className = 'mb-4 p-3 rounded-xl text-sm font-bold text-center ' + (type==='success' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'); 
        flashBox.style.display = 'block'; 
        setTimeout(()=>{ flashBox.style.display = 'none'; }, 4000); 
    }
    function setErrors(container, errors){ 
        Object.entries(errors).forEach(([field, msgs]) => { 
            const errEl = document.querySelector('[data-error-for="' + field + '"]'); 
            if(errEl) errEl.textContent = Array.isArray(msgs) ? msgs[0] : msgs; 
        }); 
    }
    function clearErrors(){ document.querySelectorAll('[data-error-for]').forEach(e => e.textContent = ''); }

    async function postJson(url, data, btn){
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const originalText = btn.innerHTML;
        btn.disabled = true; 
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
        clearErrors();
        try {
            // handle optional redirect parameter based on the URL search string
            const params = new URLSearchParams(window.location.search);
            if(params.has('redirect')) data.redirect = params.get('redirect');
            
            const res = await fetch(url, { 
                method: 'POST', 
                headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json' }, 
                body: JSON.stringify(data)
            });
            const json = await res.json();
            
            if(res.ok && json.status === 'success'){ 
                flash('Success! Redirecting...', 'success'); 
                setTimeout(() => { window.location.href = json.redirect; }, 600); 
            } else if(res.status === 422) { 
                if(json.errors) setErrors(btn.form, json.errors); 
                flash(json.message || 'Validation error', 'error'); 
            } else { 
                flash(json.message || 'Request failed', 'error'); 
            }
        } catch(e){ 
            flash('Network error', 'error'); 
        } finally { 
            btn.disabled = false; 
            btn.innerHTML = originalText;
        }
    }

    // Submit events
    const loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', e => { 
        e.preventDefault(); 
        postJson('{{ route("login.submit") }}', { 
            email: loginForm.loginEmail.value, 
            password: loginForm.loginPassword.value 
        }, document.getElementById('loginBtn')); 
    });

    const registerForm = document.getElementById('registerForm');
    registerForm.addEventListener('submit', e => { 
        e.preventDefault(); 
        if(registerForm.registerPassword.value !== registerForm.confirmPassword.value){ 
            flash('Passwords do not match', 'error'); 
            return; 
        } 
        postJson('{{ route("register.submit") }}', { 
            name: registerForm.fullName.value, 
            email: registerForm.registerEmail.value, 
            password: registerForm.registerPassword.value, 
            password_confirmation: registerForm.confirmPassword.value 
        }, document.getElementById('registerBtn')); 
    });

    // External notifications
    @if (session('status')) flash(@json(session('status')), 'success'); @endif
    @if ($errors->any()) flash(@json(collect($errors->all())->join('\n')), 'error'); @endif
</script>
</body>
</html>
