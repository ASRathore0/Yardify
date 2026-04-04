const fs = require('fs');
const file = 'resources/views/partials/one-x-one.blade.php';
const content = fs.readFileSync(file, 'utf8');

const startStr = '<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">';
const endStr = '<div class="mt-12 text-center">';

const startIndex = content.indexOf(startStr);
const endIndex = content.indexOf(endStr);

if (startIndex !== -1 && endIndex !== -1) {
    const newPart = `
            @forelse($items as $item)
                @php
                    $sellerName = $item->user->name ?? 'Unknown Seller';
                    $initials = collect(explode(' ', $sellerName))->map(function($v) { return substr($v, 0, 1); })->take(2)->implode('');
                    $initials = strtoupper($initials);
                    $colors = ['from-blue-100 to-slate-200', 'from-pink-100 to-slate-200', 'from-yellow-100 to-slate-200', 'from-green-100 to-slate-200', 'from-purple-100 to-slate-200'];
                    $colorClass = $colors[$item->id % count($colors)];
                    $imageUrl = $item->image_path ? asset('storage/'.$item->image_path) : 'https://placehold.co/600x400/e2e8f0/475569?text=No+Image';
                @endphp
                <div onclick="openDeal(this)" 
                    data-title="{{ $item->title }}"
                    data-price="₹{{ number_format($item->price, 2) }}"
                    data-image="{{ $imageUrl }}"
                    data-condition="{{ $item->condition ?? 'N/A' }}"
                    data-desc="{{ $item->description }}"
                    data-seller="{{ $sellerName }}"
                    data-location="{{ $item->location_text }}"
                    data-avatar="{{ $initials }}"
                    data-color="{{ $colorClass }}"
                    class="bg-white rounded-[1.25rem] border border-slate-200 overflow-hidden deal-card flex flex-col cursor-pointer group">
                    <div class="relative h-56 bg-slate-100 overflow-hidden">
                        <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2.5 py-1 rounded-md text-[10px] font-black text-slate-700 shadow-sm uppercase tracking-wider z-10">
                            {{ $item->condition ?? 'Listed' }}
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $item->type == 'sell' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }} uppercase">{{ $item->type }}</span>
                            <span class="text-[10px] font-bold text-slate-400">{{ $item->category }}</span>
                        </div>
                        <h3 class="text-[17px] font-bold text-slate-800 leading-snug line-clamp-2 mb-2 group-hover:text-[#046c9f] transition-colors">{{ $item->title }}</h3>
                        <div class="text-lg font-black text-[#046c9f] mb-3">₹{{ number_format($item->price, 2) }} {{ $item->type == 'rent' ? '/period' : '' }}</div>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $item->description }}</p>
                        
                        <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br {{ $colorClass }} flex items-center justify-center text-[10px] font-bold text-slate-600 border border-slate-100 shadow-sm">{{ $initials }}</div>
                                <div>
                                    <p class="text-[12px] font-bold text-slate-700 leading-none mb-0.5">{{ $sellerName }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium leading-none"><i class="fas fa-map-marker-alt mr-0.5"></i> {{ Str::limit($item->location_text, 15) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-500">
                    <i class="fas fa-box-open text-4xl mb-3 text-slate-300"></i>
                    <p class="text-lg font-medium">No items listed yet. Be the first to post an ad!</p>
                </div>
            @endforelse
            </div>
            
            `;

    fs.writeFileSync(file, content.substring(0, startIndex + startStr.length) + newPart + content.substring(endIndex));
    console.log('Successfully updated one-x-one grid view.');
} else {
    console.error('Could not find start or end tags.');
}
