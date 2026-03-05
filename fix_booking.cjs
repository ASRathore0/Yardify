const fs = require('fs');
let c = fs.readFileSync('app/Http/Controllers/BookingController.php', 'utf8');

const regex = /Booking::create\([\s\S]*?if \(\$request->ajax\(\)/;
const replacement = `Booking::create([
            'vendor_id' => $vendor->id,
            'user_id' => auth()->id(),
            'service_name' => $request->service_name,
            'price' => $request->price ?? $vendor->base_price ?? 0,
            'status' => 'pending',
            'scheduled_at' => $request->scheduled_at,
            'notes' => $request->notes,
        ]);

        if ($request->ajax()`;

c = c.replace(regex, replacement);
fs.writeFileSync('app/Http/Controllers/BookingController.php', c);
console.log('Fixed BookingController');