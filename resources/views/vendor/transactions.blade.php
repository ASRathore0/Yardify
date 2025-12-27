<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transactions</title>
  <style>body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:#f8fafc;margin:0;color:#0f172a}.wrap{max-width:900px;margin:20px auto;padding:12px}.card{background:#fff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 2px 12px rgba(2,8,23,.04);padding:12px}</style>
</head>
<body>
  @include('vendor.partials.nav')
  <div class="wrap">
    <div class="card" style="margin-top:12px;">
      <h2 style="margin:0 0 10px;">Transactions</h2>
      @if($transactions->count())
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Type</th>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Amount</th>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Status</th>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Description</th>
              <th style="text-align:left;border-bottom:1px solid #e2e8f0;padding:8px;">Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transactions as $t)
              <tr>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">{{ ucfirst($t->type) }}</td>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">₹{{ $t->amount }}</td>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">{{ ucfirst($t->status) }}</td>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">{{ $t->description }}</td>
                <td style="padding:8px;border-bottom:1px solid #f1f5f9;">{{ $t->created_at->format('d M Y') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div>No transactions yet.</div>
      @endif
    </div>
  </div>
</body>
</html>
