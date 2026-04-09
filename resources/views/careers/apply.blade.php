<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=no">
    <title>Careers — BookingYard</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: '#046c9f',
                        brandLight: '#e0f2fe',
                        brandHover: '#035680'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .input-field {
            background-color: #f1f5f9;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        .input-field:focus {
            background-color: #ffffff;
            border-color: #046c9f;
            box-shadow: 0 0 0 4px rgba(4, 108, 159, 0.1);
            outline: none;
        }
        /* Custom scrollbar for textarea */
        textarea::-webkit-scrollbar { width: 6px; }
        textarea::-webkit-scrollbar-track { background: transparent; }
        textarea::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="text-slate-800 antialiased relative selection:bg-brand selection:text-white">

    @include('partials.header')
    @include('partials.sidebar')

    <!-- Decorative background -->
    <div class="absolute top-0 left-0 w-full h-[600px] bg-gradient-to-b from-brandLight/60 to-transparent -z-10 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-1 sm:pt-12 pb-16 sm:pb-24 mt-5 sm:mt-[72px]">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-16">
            
            <!-- Left Column: Branding / Context -->
            <div class="lg:col-span-5 lg:pr-4 flex flex-col justify-center">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-bold tracking-wide text-brand mb-6 w-max shadow-sm">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-brand"></span>
                    </span>
                    WE ARE HIRING
                </div>
                
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.1] mb-6">
                    Are you ready for Joining us?
                 </h1>
                
                <p class="text-lg text-slate-600 mb-10 leading-relaxed font-medium">
                    Join BookingYard and be part of a team that's reshaping how people connect with vendors locally. We value creativity, ultimate ownership, and real impact.
                </p>

                <div class="space-y-6 hidden sm:block">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-[1rem] bg-white border border-slate-100 shadow-[0_2px_8px_rgb(0,0,0,0.04)] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-rocket text-xl text-brand"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-[15px]">Career Growth</h3>
                            <p class="text-[13px] text-slate-500 mt-1 leading-snug">Accelerate your career with challenging projects and continuous learning.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-[1rem] bg-white border border-slate-100 shadow-[0_2px_8px_rgb(0,0,0,0.04)] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-heart-pulse text-xl text-pink-500"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-[15px]">Great Benefits</h3>
                            <p class="text-[13px] text-slate-500 mt-1 leading-snug">Comprehensive health coverage, flexible hours, and remote-friendly policies.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-[1rem] bg-white border border-slate-100 shadow-[0_2px_8px_rgb(0,0,0,0.04)] flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-users-rays text-xl text-amber-500"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-[15px]">Amazing Culture</h3>
                            <p class="text-[13px] text-slate-500 mt-1 leading-snug">Work alongside brilliant, supportive, and kind individuals.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-[2rem] shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] border border-slate-100 p-6 sm:p-10 relative overflow-hidden">
                    
                    <div class="mb-8">
                        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Submit Application</h2>
                        <p class="text-[14px] text-slate-500 mt-1.5 font-medium">All fields marked with an asterisk (<span class="text-red-500">*</span>) are required.</p>
                    </div>

                    @if(session('success'))
                        <div class="p-8 bg-brandLight/50 border border-brand/20 rounded-[1.5rem] flex flex-col items-center justify-center text-center">
                            <div class="w-16 h-16 rounded-full bg-brandLight flex items-center justify-center mb-4">
                                <i class="fa-solid fa-check-double text-3xl text-brand"></i>
                            </div>
                            <h3 class="text-xl font-extrabold text-slate-900 mb-2">Thank You!</h3>
                            <p class="text-brand font-bold">{{ session('success') }}</p>
                            <p class="text-[13px] text-slate-600 mt-2">Our hiring team will review your application and be in touch soon.</p>
                            <a href="{{ url('/') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-brand text-white font-bold text-sm hover:bg-brandHover transition">
                                <i class="fa-solid fa-house"></i> Return Home
                            </a>
                        </div>
                    @else
                        @if($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-800 rounded-xl text-[13px] font-bold">
                                <div class="flex items-center mb-2">
                                    <i class="fa-solid fa-circle-exclamation mr-1 text-red-500"></i> 
                                    <span>Please fix the following errors:</span>
                                </div>
                                <ul class="list-disc pl-5 mt-1 font-medium">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="applicationForm" action="{{ route('careers.submit') }}" method="post" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <!-- Personal Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-[13px] font-bold text-slate-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" required class="input-field w-full px-4 py-[13px] rounded-xl text-[14px] font-medium" placeholder="Jane Doe">
                            </div>
                            <div>
                                <label for="email" class="block text-[13px] font-bold text-slate-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" required class="input-field w-full px-4 py-[13px] rounded-xl text-[14px] font-medium" placeholder="jane@example.com">
                            </div>
                            <div>
                                <label for="phone" class="block text-[13px] font-bold text-slate-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                                <input type="text" id="phone" name="phone" required class="input-field w-full px-4 py-[13px] rounded-xl text-[14px] font-medium" placeholder="+91 XXXXX XXXXX">
                            </div>
                            <div>
                                <label for="location" class="block text-[13px] font-bold text-slate-700 mb-1.5">Location <span class="text-red-500">*</span></label>
                                <input type="text" id="location" name="location" required class="input-field w-full px-4 py-[13px] rounded-xl text-[14px] font-medium" placeholder="City, State">
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <label for="position" class="block text-[13px] font-bold text-slate-700 mb-1.5">Role Applied For <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="position" name="position" required class="input-field w-full px-4 py-[13px] rounded-xl text-[14px] font-medium appearance-none cursor-pointer">
                                    <option value="" disabled selected hidden>Select an open role...</option>
                                    <option value="Business Development Manager">Business Development Manager</option>
                                    <option value="Full-Stack Web Developer">Full-Stack Web Developer</option>
                                    <option value="UI/UX Designer">UI/UX Designer</option>
                                    <option value="Digital Marketing Specialist">Digital Marketing Specialist</option>
                                    <option value="SEO Specialist">SEO Specialist</option>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-[11px]"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Links & Date -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="linkedin" class="block text-[13px] font-bold text-slate-700 mb-1.5">LinkedIn URL <span class="text-slate-400 font-normal">(Optional)</span></label>
                                <div class="relative flex items-center">
                                    <i class="fa-brands fa-linkedin absolute left-3.5 text-slate-400 text-[15px]"></i>
                                    <input type="url" id="linkedin" name="linkedin" class="input-field w-full pl-9 pr-4 py-[13px] rounded-xl text-[14px] font-medium" placeholder="linkedin.com/in/jane">
                                </div>
                            </div>
                            <div>
                                <label for="start-date" class="block text-[13px] font-bold text-slate-700 mb-1.5">Earliest Start Date <span class="text-red-500">*</span></label>
                                <input type="date" id="start-date" name="start_date" required class="input-field w-full px-4 py-[13px] rounded-xl text-[14px] font-medium text-slate-700 cursor-pointer relative z-10">
                            </div>
                        </div>

                        <!-- Resume Upload -->
                        <div>
                            <label for="resume" class="block text-[13px] font-bold text-slate-700 mb-2">Resume / CV <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative group">
                                <input id="resume" name="resume" type="file" class="sr-only" accept=".pdf, .doc, .docx" required>
                                <label for="resume" id="resumeZone" class="flex flex-col items-center py-7 px-4 border-[1.5px] border-dashed border-slate-300 bg-[#f8fafc] hover:bg-brandLight/20 hover:border-brand/40 rounded-2xl cursor-pointer transition-all">
                                    <div id="resumeIcon" class="w-10 h-10 rounded-full bg-white shadow-[0_2px_8px_rgb(0,0,0,0.06)] flex items-center justify-center text-slate-500 mb-3 group-hover:scale-105 group-hover:text-brand transition-all">
                                        <i class="fa-solid fa-cloud-arrow-up text-[17px]"></i>
                                    </div>
                                    <div id="resumeTextContainer" class="text-center">
                                        <p class="text-[13px] font-bold text-slate-800 mb-1"><span class="text-brand">Click to upload</span> or drag and drop</p>
                                        <p class="text-[11.5px] text-slate-400 font-medium">PDF, DOC, or DOCX (Max 5MB)</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Cover Letter -->
                        <div>
                            <label for="statement" class="block text-[13px] font-bold text-slate-700 mb-1.5">Cover Letter <span class="text-red-500">*</span></label>
                            <textarea id="statement" name="statement" rows="4" required class="input-field w-full px-4 py-3.5 rounded-xl text-[14px] font-medium resize-none" placeholder="Tell us why you want to join the team..."></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="pt-2">
                            <button type="submit" class="w-full py-[15px] bg-[#0f172a] hover:bg-brand text-white rounded-xl font-bold text-[15px] shadow-[0_4px_12px_rgb(0,0,0,0.1)] transition-all transform hover:-translate-y-[1px] active:translate-y-0 active:scale-[0.99] flex justify-center items-center gap-2">
                                Send Application <i class="fa-solid fa-paper-plane text-[11px] opacity-80"></i>
                            </button>
                        </div>

                    </form>
                    @endif
                    
                    <p id="responseMessage" class="hidden text-[13px] font-bold text-center mt-4"></p>
                    <div id="confirmationMessage" class="hidden mt-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl text-[13px] font-bold text-center">
                        <i class="fa-solid fa-circle-check mr-1 text-emerald-500"></i> Application submitted successfully! We'll be in touch soon.
                    </div>
                </div>
                
                <p class="text-center text-[12px] text-slate-400 font-medium mt-6">
                    <i class="fa-solid fa-shield-halved text-[11px] mr-1 opacity-70"></i> Post-encryption securing your data.
                </p>
            </div>
        </div>
    </div>

    @include('partials.footer-mobile')
    @include('partials.footer-modern')

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/script1.js') }}"></script>
    
    <script>
        const resumeInput = document.getElementById('resume');
        const resumeZone = document.getElementById('resumeZone');
        const resumeIcon = document.getElementById('resumeIcon');
        const resumeTextContainer = document.getElementById('resumeTextContainer');

        resumeInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                resumeIcon.innerHTML = '<i class="fa-solid fa-check text-emerald-500"></i>';
                resumeIcon.classList.add('bg-emerald-50', 'ring-4', 'ring-emerald-50');
                resumeTextContainer.innerHTML = '<p class="text-[13px] font-bold text-emerald-600 mb-0.5">' + fileName + '</p><p class="text-[10px] text-slate-400 uppercase tracking-widest font-extrabold">Ready to upload</p>';
                resumeZone.classList.add('border-emerald-200', 'bg-emerald-50/50');
            }
        });

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            resumeZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) { e.preventDefault(); e.stopPropagation(); }

        ['dragenter', 'dragover'].forEach(eventName => {
            resumeZone.addEventListener(eventName, () => resumeZone.classList.add('border-brand', 'bg-brandLight/20'));
        });

        ['dragleave', 'drop'].forEach(eventName => {
            resumeZone.addEventListener(eventName, () => resumeZone.classList.remove('border-brand', 'bg-brandLight/20'));
        });

        resumeZone.addEventListener('drop', (e) => {
            if (e.dataTransfer.files.length > 0) {
                resumeInput.files = e.dataTransfer.files;
                resumeInput.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>
</html>
