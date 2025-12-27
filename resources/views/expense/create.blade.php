@extends('layouts.expense')

@section('content')
<div class="min-h-screen bg-slate-50 py-12 px-4">
    <div class="max-w-xl mx-auto">
        <a href="{{ route('expense.index') }}" class="inline-flex items-center text-sm font-bold text-indigo-600 mb-6 hover:text-indigo-800 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            BACK TO DASHBOARD
        </a>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="bg-indigo-600 px-8 py-10 text-white">
                <h2 class="text-2xl font-black tracking-tight mb-2">Create a New Group</h2>
                <p class="text-indigo-100 text-sm opacity-90">Start tracking shared expenses with your roommates or friends in seconds.</p>
            </div>

            <form id="createGroupForm" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Group Identity</label>
                    <input name="name" type="text" placeholder="e.g. Apartment 4B or Trip to Goa" required 
                        class="w-full px-4 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-300">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Add Members</label>
                    <div class="relative">
                        <input name="members" type="text" placeholder="John, Sarah, Mike..." 
                            class="w-full px-4 py-4 rounded-2xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-300">
                        <div class="mt-2 flex items-center gap-2 px-1">
                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" /></svg>
                            <p class="text-[11px] text-slate-500">Separate names or emails with commas.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex flex-col gap-3">
                    <button type="submit" id="submitBtn" 
                        class="w-full bg-slate-900 text-white font-black py-4 rounded-2xl hover:bg-black transition-all shadow-lg shadow-slate-200 flex justify-center items-center gap-2">
                        <span>CREATE GROUP</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    
                    <a href="{{ route('expense.index') }}" 
                        class="w-full text-center py-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition">
                        Cancel and go back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('createGroupForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const originalText = btn.innerHTML;
    
    // UI Feedback: Loading state
    btn.disabled = true;
    btn.innerHTML = '<span class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></span> Processing...';

    const fd = new FormData(this); 
    const obj = {};
    fd.forEach((v,k) => obj[k] = v);

    try {
        const res = await fetch("{{ route('expense.groups.store') }}", {
            method: 'POST', 
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }, 
            body: JSON.stringify(obj)
        });

        const js = await res.json();
        
        if(js.status === 'success'){
            window.location = "{{ url('/expense-management/groups') }}/" + js.group.id;
        } else {
            throw new Error('Failed');
        }
    } catch (error) {
        alert('Something went wrong. Please check your data.');
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
});
</script>
@endsection