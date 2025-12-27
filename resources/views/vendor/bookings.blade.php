<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Bookings</title>
  <style>body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#f8fafc;margin:0;color:#0f172a}.wrap{max-width:900px;margin:20px auto;padding:12px}.card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 2px 12px rgba(2,8,23,.04);padding:12px}</style>
</head>
<body>
  @include('vendor.partials.nav')
  <div class="wrap">
    <div class="card" style="margin-top:12px;">
      <h2 style="margin:0 0 10px;">Bookings</h2>
      @if($bookings->count())
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Service</th>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Status</th>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Scheduled</th>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Price</th>
            </tr>
          </thead>
          <tbody>
            @foreach($bookings as $b)
              <tr>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">{{ $b->service_name }}</td>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">{{ ucfirst($b->status) }}</td>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">{{ optional($b->scheduled_at)->format('d M Y, h:i A') }}</td>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">₹{{ $b->price }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div style="margin-top:10px;">{{ $bookings->links() }}</div>
      @else
        <div>No bookings yet.</div>
      @endif
    </div>
  </div>
</body>
</html>
