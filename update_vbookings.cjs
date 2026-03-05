const fs = require('fs');
let file = 'resources/views/vendor/bookings.blade.php';
let content = fs.readFileSync(file, 'utf8');

content = content.replace(
/\{\{\s*ucfirst\(\$b->status\)\s*\}\}/g,
`<form action="{{ route('vendor.bookings.update', $b->id) }}" method="POST" style="display:flex; gap:4px;">
  @csrf
  @method('PUT')
  <select name="status" onchange="this.form.submit()" style="padding:4px; border-radius:4px; border:1px solid #cbd5e1;">
    <option value="pending" {{ $b->status == 'pending' ? 'selected' : '' }}>Pending</option>
    <option value="confirmed" {{ $b->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
    <option value="completed" {{ $b->status == 'completed' ? 'selected' : '' }}>Completed</option>
    <option value="cancelled" {{ $b->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
  </select>
</form>`
);

fs.writeFileSync(file, content);
console.log('Vendor Bookings updated!');
