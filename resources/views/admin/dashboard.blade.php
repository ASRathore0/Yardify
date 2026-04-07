@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
@vite(['resources/css/app.css', 'resources/js/app.js'])


<div class="py-6 sm:py-10 bg-slate-50 min-h-screen font-sans text-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-12">
        
        @if(session('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-teal-800 border border-teal-200 rounded-2xl bg-teal-50 shadow-sm animate-fade-in-down" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 me-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
                <span class="sr-only">Success</span>
                <div>
                    <span class="font-semibold">Success!</span> {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Platform Overview
                </h2>
                <p class="text-sm sm:text-base text-slate-500 mt-1 sm:mt-2">Monitor analytics and manage storefront content seamlessly.</p>
            </div>
        </div>

        <!-- Platform Overview Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Stat 1 -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 bg-gradient-to-br from-accent-50 to-accent-100 rounded-full w-32 h-32 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Users</p>
                        <p class="text-4xl sm:text-5xl font-black text-slate-800 tracking-tight">{{ $stats['users'] }}</p>
                    </div>
                    <div class="p-4 bg-white/80 backdrop-blur-sm rounded-2xl text-accent-600 shadow-sm border border-accent-50 group-hover:bg-accent-50 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>
            
            <!-- Stat 2 -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 bg-gradient-to-br from-brand-50 to-brand-100 rounded-full w-32 h-32 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Vendors</p>
                        <p class="text-4xl sm:text-5xl font-black text-slate-800 tracking-tight">{{ $stats['vendors'] }}</p>
                    </div>
                    <div class="p-4 bg-white/80 backdrop-blur-sm rounded-2xl text-brand-600 shadow-sm border border-brand-50 group-hover:bg-brand-50 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group sm:col-span-2 lg:col-span-1">
                <div class="absolute -right-6 -top-6 bg-gradient-to-br from-orange-50 to-amber-100 rounded-full w-32 h-32 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Listings</p>
                        <p class="text-4xl sm:text-5xl font-black text-slate-800 tracking-tight">{{ $stats['items'] }}</p>
                    </div>
                    <div class="p-4 bg-white/80 backdrop-blur-sm rounded-2xl text-orange-500 shadow-sm border border-orange-50 group-hover:bg-orange-50 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Landing Page Ad Manager -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-white">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-accent-50 rounded-lg text-accent-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Hero Banners</h3>
                        <p class="text-xs sm:text-sm text-slate-500">Upload high-quality 16:9 images for top carousel.</p>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-slate-50/50">
                <form method="POST" action="{{ route('admin.banners.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6 sm:space-y-8">
                        @foreach ($banners as $index => $banner)
                            <div class="bg-white p-5 sm:p-8 rounded-3xl shadow-sm border border-slate-200 transition-all hover:border-accent-200">
                                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-full bg-accent-100 text-accent-700 flex items-center justify-center font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <h4 class="font-bold text-lg text-slate-800">Banner Slide</h4>
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
                                    <!-- Image Column -->
                                    <div class="lg:col-span-4">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Display Image</label>
                                        <div class="relative group rounded-2xl overflow-hidden bg-slate-100 border-2 border-dashed border-slate-300 hover:border-accent-400 hover:bg-slate-50 transition-all aspect-video flex flex-col items-center justify-center cursor-pointer">
                                            @if(!empty($banner['image']))
                                                <img src="{{ asset('storage/' . $banner['image']) }}" class="absolute inset-0 w-full h-full object-cover z-0">
                                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-all z-10 flex items-center justify-center backdrop-blur-[2px]">
                                                    <span class="text-white text-sm font-medium px-4 py-2 border border-white/50 rounded-full bg-black/30">Replace Image</span>
                                                </div>
                                            @else
                                                <div class="text-center z-10 p-4">
                                                    <svg class="mx-auto h-8 w-8 text-slate-400 mb-2 group-hover:text-accent-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    <p class="text-sm font-medium text-slate-600">Upload Image</p>
                                                    <p class="text-xs text-slate-400 mt-1">16:9 Ratio recommended</p>
                                                </div>
                                            @endif
                                            <input type="file" name="banners[{{ $index }}][image_file]" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                        </div>
                                    </div>

                                    <!-- Text Fields Column -->
                                    <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Headline</label>
                                            <input type="text" name="banners[{{ $index }}][title]" value="{{ $banner['title'] ?? '' }}" placeholder="E.g., 20% OFF Summer Sale" class="w-full rounded-xl border border-slate-200 shadow-sm focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20 text-sm p-3 sm:p-3.5 bg-slate-50 focus:bg-white transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Subtitle</label>
                                            <input type="text" name="banners[{{ $index }}][subtitle]" value="{{ $banner['subtitle'] ?? '' }}" placeholder="E.g., Book your service today" class="w-full rounded-xl border border-slate-200 shadow-sm focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20 text-sm p-3 sm:p-3.5 bg-slate-50 focus:bg-white transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Target Link URL</label>
                                            <input type="text" name="banners[{{ $index }}][link]" value="{{ $banner['link'] ?? '' }}" placeholder="E.g., /services" class="w-full rounded-xl border border-slate-200 shadow-sm focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20 text-sm p-3 sm:p-3.5 bg-slate-50 focus:bg-white transition-all">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-semibold text-slate-700 mb-2">Background Theme Preset <span class="text-[11px] text-slate-400 font-normal ml-1">(Shown if no image)</span></label>
                                            <select name="banners[{{ $index }}][bg]" class="w-full rounded-xl border border-slate-200 shadow-sm focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20 text-sm p-3 sm:p-3.5 bg-slate-50 focus:bg-white transition-all cursor-pointer appearance-none">
                                                <option value="bg-1" {{ ($banner['bg'] ?? '') == 'bg-1' ? 'selected' : '' }}>🌊 Blue Ocean</option>
                                                <option value="bg-2" {{ ($banner['bg'] ?? '') == 'bg-2' ? 'selected' : '' }}>🔥 Sunset Orange</option>
                                                <option value="bg-3" {{ ($banner['bg'] ?? '') == 'bg-3' ? 'selected' : '' }}>🌿 Emerald Green</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8 pt-6 flex justify-end border-t border-slate-200">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center py-3.5 px-8 rounded-xl text-white bg-slate-900 hover:bg-slate-800 focus:ring-4 focus:ring-slate-900/10 transition-all font-bold shadow-lg shadow-slate-900/20 active:scale-[0.98]">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Publish Banners
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Categories and Services split nicely -->
        
        <!-- Popular Categories Manager -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-white">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Featured Categories</h3>
                        <p class="text-xs sm:text-sm text-slate-500">Quick-link circular chips on homepage.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-slate-50/50">
                <form method="POST" action="{{ route('admin.categories.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
                        @foreach ($categories as $index => $category)
                            <div class="bg-white p-5 sm:p-6 rounded-3xl shadow-sm border border-slate-200 transition-all hover:border-purple-200 group">
                                <h4 class="font-bold text-slate-700 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 inline-flex items-center justify-center text-xs">{{ $index + 1 }}</span> Category Block
                                </h4>
                                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 sm:gap-6">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 shrink-0 bg-slate-100 rounded-2xl overflow-hidden border-2 border-dashed border-slate-300 relative flex items-center justify-center cursor-pointer group-hover:border-purple-400 transition-colors">
                                        @if(!empty($category['image']))
                                            <img src="{{ Str::startsWith($category['image'], 'image/') ? asset($category['image']) : asset('storage/' . $category['image']) }}" class="w-full h-full object-cover z-0">
                                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-all z-10 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                            </div>
                                        @else
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        @endif
                                        <input type="file" name="categories[{{ $index }}][image_file]" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full">
                                    </div>
                                    <div class="flex-1 w-full space-y-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Display Title</label>
                                            <input type="text" name="categories[{{ $index }}][title]" value="{{ $category['title'] ?? '' }}" placeholder="e.g. Electrician" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Search Keyword/Link</label>
                                            <input type="text" name="categories[{{ $index }}][link]" value="{{ $category['link'] ?? '' }}" placeholder="e.g. /search?q=electrician" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all shadow-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 pt-6 flex justify-end border-t border-slate-200">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center py-3.5 px-8 rounded-xl text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-600/20 transition-all font-bold shadow-lg shadow-purple-600/30 active:scale-[0.98]">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Update Categories
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Top Services Manager -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-brand-50 rounded-lg text-brand-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900">Most Booked Services</h3>
                        <p class="text-xs sm:text-sm text-slate-500">Manage detailed service cards displayed on the homepage.</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 sm:p-8 bg-slate-50/50">
                <form method="POST" action="{{ route('admin.services.update') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center py-3 px-6 rounded-xl text-brand-700 bg-brand-50 border border-brand-200 hover:bg-brand-600 hover:text-white hover:border-brand-600 focus:ring-4 focus:ring-brand-500/20 transition-all font-bold active:scale-[0.98]">
                            Save Progress
                        </button>
                    </div>

                    <div class="space-y-6 sm:space-y-8">
                        @foreach ($services as $index => $service)
                            <div class="bg-white p-5 sm:p-8 rounded-3xl shadow-sm border border-slate-200 transition-all hover:border-brand-300 group">
                                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                                    <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center font-bold text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <h4 class="font-bold text-lg text-slate-800">Featured Service Card</h4>
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 sm:gap-8">
                                    <div class="lg:col-span-1 flex flex-col">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Thumbnail</label>
                                        <div class="w-full aspect-[4/3] bg-slate-100 rounded-2xl overflow-hidden border-2 border-dashed border-slate-300 relative group/img flex flex-col items-center justify-center cursor-pointer mb-2 hover:border-brand-400 hover:bg-slate-50 transition-all">
                                            @if(!empty($service['image']))
                                                <img src="{{ Str::startsWith($service['image'], 'image/') ? asset($service['image']) : asset('storage/' . $service['image']) }}" class="absolute inset-0 w-full h-full object-cover z-0 service-img-preview">
                                            @else
                                                <svg class="w-10 h-10 text-slate-300 mb-2 preview-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <img src="" class="absolute inset-0 w-full h-full object-cover z-0 service-img-preview hidden">
                                            @endif
                                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover/img:opacity-100 transition-all z-10 flex items-center justify-center backdrop-blur-[2px]">
                                                <span class="text-white text-xs font-semibold px-3 py-1.5 border border-white/50 rounded-full bg-black/40">Change Image</span>
                                            </div>
                                            <input type="file" name="services[{{ $index }}][image_file]" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-20 w-full h-full" onchange="previewImage(this)">
                                        </div>
                                    </div>
                                    
                                    <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Service Title</label>
                                            <input type="text" name="services[{{ $index }}][title]" value="{{ $service['title'] ?? '' }}" placeholder="e.g. Deep Home Cleaning" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Subtitle / Location</label>
                                            <input type="text" name="services[{{ $index }}][subtitle]" value="{{ $service['subtitle'] ?? '' }}" placeholder="e.g. Valid in Delhi NCR" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Price Display</label>
                                            <input type="text" name="services[{{ $index }}][price]" value="{{ $service['price'] ?? '' }}" placeholder="e.g. Starts at ₹999" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Highlight Badge</label>
                                            <input type="text" name="services[{{ $index }}][badge]" value="{{ $service['badge'] ?? '' }}" placeholder="e.g. Bestseller" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all shadow-sm">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Rating (0-5)</label>
                                                <input type="text" name="services[{{ $index }}][rating]" value="{{ $service['rating'] ?? '' }}" placeholder="4.8" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all shadow-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Total Reviews</label>
                                                <input type="text" name="services[{{ $index }}][reviews]" value="{{ $service['reviews'] ?? '' }}" placeholder="(2.4k)" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all shadow-sm">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Target URL</label>
                                            <input type="text" name="services[{{ $index }}][link]" value="{{ $service['link'] ?? '' }}" placeholder="e.g. /service/cleaning" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all shadow-sm">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase tracking-wide">Footer / Context Info</label>
                                            <input type="text" name="services[{{ $index }}][footer]" value="{{ $service['footer'] ?? '' }}" placeholder="e.g. Free cancellation up to 24hrs" class="w-full rounded-xl border border-slate-200 text-sm p-3 bg-slate-50 focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all shadow-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 pt-6 flex justify-end border-t border-slate-200">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center py-4 px-10 rounded-xl text-white bg-brand-600 hover:bg-brand-700 focus:ring-4 focus:ring-brand-500/30 transition-all font-black text-base shadow-xl shadow-brand-500/20 active:scale-[0.98]">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Save Custom Services
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var container = input.closest('.relative');
                var img = container.querySelector('.service-img-preview');
                var icon = container.querySelector('.preview-icon');
                
                if(img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                if(icon) {
                    icon.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

