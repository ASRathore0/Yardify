<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $type == 'sell' ? 'Sell an Item' : 'Rent an Item' }} | BookingYard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Using Tailwind for a professional structure similar to one-x-one -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .drag-active { border-color: #0077b6 !important; background-color: #e0f2fe !important; }
    </style>
</head>
<body>
    @include('vendor.partials.nav')

    <div class="max-w-3xl mx-auto my-8 px-4 sm:px-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                    {{ $type == 'sell' ? 'Post an Ad for Sale' : 'List an Item for Rent' }}
                </h1>
                <p class="text-slate-500 text-sm mt-1">Provide clear photos and details to attract more {{ $type == 'sell' ? 'buyers' : 'renters' }}.</p>
            </div>
            <a href="{{ route('vendor.dashboard') }}" class="hidden sm:inline-flex items-center text-sm font-semibold text-[#0077b6] hover:text-[#023e8a] transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex items-center text-red-800 font-bold mb-2">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> Please fix the following errors:
                </div>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1 ml-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="h-2 w-full bg-gradient-to-r {{ $type == 'sell' ? 'from-green-400 to-emerald-500' : 'from-orange-400 to-amber-500' }}"></div>
            
            <form action="{{ isset($item) ? route('vendor.items.update', $item) : route('vendor.items.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8" id="itemForm">
                @csrf
                @if(isset($item))
                    @method('PUT')
                @endif
                <input type="hidden" name="type" value="{{ $type }}">
                
                <!-- Section 1: Basic Info -->
                <div class="mb-8 pb-8 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center"><span class="bg-slate-100 text-slate-500 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">1</span> Basic Details</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="col-span-1 sm:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Posting Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" value="{{ old('title', isset($item) ? $item->title : '') }}" required placeholder="e.g. Sony PlayStation 5 / Featherlite Chair" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0077b6] focus:border-[#0077b6] outline-none transition-all placeholder-slate-400 text-slate-800 font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                            <select name="category" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0077b6] focus:border-[#0077b6] outline-none transition-all text-slate-800 font-medium bg-white">
                                <option value="" disabled {{ !old('category', isset($item) ? $item->category : '') ? 'selected' : '' }}>Select Category</option>
                                @foreach(['Electronics', 'Vehicles', 'Property', 'Furniture', 'Books & Media', 'Tools', 'Fashion', 'Other'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', isset($item) ? $item->category : '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Condition</label>
                            <select name="condition" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0077b6] focus:border-[#0077b6] outline-none transition-all text-slate-800 font-medium bg-white">
                                @foreach(['Brand New', 'Like New', 'Gently Used', 'Heavily Used'] as $cond)
                                    <option value="{{ $cond }}" {{ old('condition', isset($item) ? $item->condition : '') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1 sm:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Price (?) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-slate-500 font-bold">?</span>
                                </div>
                                <input type="number" name="price" step="0.01" value="{{ old('price', isset($item) ? $item->price : '') }}" required placeholder="{{ $type == 'rent' ? 'Price per day/month' : 'Total Price' }}" 
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0077b6] focus:border-[#0077b6] outline-none transition-all text-slate-800 font-bold text-lg">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Location & Description -->
                <div class="mb-8 pb-8 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center"><span class="bg-slate-100 text-slate-500 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">2</span> Information & Location</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">City <span class="text-red-500">*</span></label>
                            <input type="text" name="city" value="{{ old('city', isset($item) ? $item->city : '') }}" required placeholder="e.g. Mumbai" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0077b6] focus:border-[#0077b6] outline-none transition-all text-slate-800 font-medium">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Exact Location <span class="text-red-500">*</span></label>
                            <input type="text" name="location_text" value="{{ old('location_text', isset($item) ? $item->location_text : '') }}" required placeholder="e.g. Tower B, Apt 402" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0077b6] focus:border-[#0077b6] outline-none transition-all text-slate-800 font-medium">
                        </div>

                        <div class="col-span-1 sm:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Contact Phone No. <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-phone text-slate-400"></i>
                                </div>
                                <input type="tel" name="phone" value="{{ old('phone', isset($item) ? $item->phone : '') }}" required placeholder="e.g. 9876543210" 
                                    class="w-full pl-10 px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0077b6] focus:border-[#0077b6] outline-none transition-all text-slate-800 font-medium">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                        <textarea name="description" required rows="4" placeholder="Detail any flaws, condition notes, or extra accessories included..." 
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-[#0077b6] focus:border-[#0077b6] outline-none transition-all text-slate-800 font-medium leading-relaxed">{{ old('description', isset($item) ? $item->description : '') }}</textarea>
                    </div>
                </div>

                <!-- Section 3: Photos -->
                <div class="mb-6 pb-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center"><span class="bg-slate-100 text-slate-500 w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">3</span> Upload Photos</h3>
                    
                    <div id="dropZone" class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center bg-slate-50 cursor-pointer hover:bg-slate-100 transition-colors">
                        <input type="file" id="imageInput" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden">
                        
                        <div class="flex flex-col items-center justify-center pointer-events-none">
                            <div class="w-16 h-16 bg-white rounded-full shadow-sm flex items-center justify-center mb-3">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-[#0077b6]"></i>
                            </div>
                            <h4 class="text-base font-bold text-slate-700 mb-1">Click or drag photos here to upload</h4>
                            <p class="text-xs text-slate-500 font-medium mt-1">PNG, JPG up to 5MB each (Max 5 photos)</p>
                        </div>
                    </div>

                    <!-- Image Previews Container -->
                    <div id="imagePreviewContainer" class="flex flex-wrap gap-4 mt-6">
                        <!-- Previews will go here dynamically -->
                    </div>
                </div>

                <!-- Submit Action -->
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <a href="{{ route('vendor.dashboard') }}" class="w-full sm:w-auto px-6 py-3.5 text-center font-bold text-slate-600 hover:text-slate-900 transition-colors rounded-xl">Cancel</a>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto px-8 py-3.5 bg-[#0077b6] hover:bg-[#023e8a] shadow-lg shadow-blue-200 text-white font-bold rounded-xl transition-transform transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Post Listing Now
                    </button>
                </div>

            </form>
        </div>
        
        <div class="text-center mt-6 block sm:hidden pb-12">
            <a href="{{ route('vendor.dashboard') }}" class="text-sm font-semibold text-slate-500">
                <i class="fa-solid fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
        
    </div>

    <!-- Hidden input array handler to sync DataTransfer with actual HTML form element -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dropZone = document.getElementById('dropZone');
            const imageInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('imagePreviewContainer');
            
            // Allow clicking the drop zone to open file dialog
            dropZone.addEventListener('click', () => {
                imageInput.click();
            });

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Highlight drop zone when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.add('drag-active'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.remove('drag-active'), false);
            });

            // Store files for previews
            let uploadedFiles = new DataTransfer();

            // Handle dropped files
            dropZone.addEventListener('drop', (e) => {
                handleFiles(e.dataTransfer.files);
            });

            // Handle file input change
            imageInput.addEventListener('change', function() {
                handleFiles(this.files);
            });

            function handleFiles(files) {
                const maxFiles = 5;
                
                [...files].forEach(file => {
                    // Check file type
                    if (!file.type.match('image.*')) return;
                    
                    // Check count limit
                    if (uploadedFiles.files.length >= maxFiles) {
                        return; // Exceeded limit silently handled (could alert)
                    }

                    // Add to DataTransfer
                    uploadedFiles.items.add(file);
                    
                    // Create preview
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group w-24 h-24 sm:w-32 sm:h-32 rounded-xl overflow-hidden shadow-sm border border-slate-200';
                        // Add unique ID to identify
                        div.dataset.filename = file.name;
                        
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" class="text-white bg-red-500 hover:bg-red-600 rounded-full w-8 h-8 flex items-center justify-center shadow-md remove-img">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        `;
                        previewContainer.appendChild(div);

                        // Attach remove handler
                        div.querySelector('.remove-img').addEventListener('click', function(evt) {
                            evt.stopPropagation();
                            removeFile(file.name, div);
                        });
                    }
                    reader.readAsDataURL(file);
                });
                
                // Sync input files payload
                syncFileInput();
            }

            function removeFile(fileName, previewElement) {
                const newFiles = new DataTransfer();
                [...uploadedFiles.files].forEach(file => {
                    if (file.name !== fileName) {
                        newFiles.items.add(file);
                    }
                });
                uploadedFiles = newFiles;
                syncFileInput();
                previewElement.remove();
            }
            
            function syncFileInput() {
                // To safely update input.files, we rewrite it
                if (navigator.userAgent.indexOf("Firefox") !== -1) {
                     // FF workaround if needed, but standard dataTransfer works in most modern browsers
                }
                const tempInput = document.createElement('input');
                tempInput.type = 'file';
                tempInput.multiple = true;
                tempInput.files = uploadedFiles.files;
                imageInput.files = tempInput.files;
            }
            
            // Final sumbit lock to prevent double clicks
            const form = document.getElementById('itemForm');
            const submitBtn = document.getElementById('submitBtn');
            
            form.addEventListener('submit', () => {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Processing...';
                submitBtn.classList.add('opacity-75');
            });
        });
    </script>
</body>
</html>


