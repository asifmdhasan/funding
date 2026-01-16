<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .letterhead {
            width: 100%;
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }
        .letterhead h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .letterhead p { margin: 2px 0 0 0; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f2f2f2; }
        .total-row td { font-weight: bold; background-color: #fafafa; }
    </style>
</head>
<body>

<div class="letterhead">
    <h1 style=" padding-bottom: 1rem;">Crowd Funding System</h1>
    <p style="font-size: 1.2rem; padding-bottom: 2rem;">Donor Donation Report</p>
</div>

<p>
    <strong style="font-size: 1.2rem;">Donor Name:</strong> <span style="font-size: 1.2rem;">{{ $donor->name }}</span><br>
    <strong style="font-size: 1.2rem;">Donor Email:</strong> <span style="font-size: 1.2rem;">{{ $donor->email }}</span><br>
    <strong style="font-size: 1.2rem;">Donor Phone:</strong> <span style="font-size: 1.2rem;">{{ $donor->phone ?? '-' }}</span><br>
    {{-- <strong style="font-size: 1.2rem;">Report Date:</strong> {{ now()->format('d M Y') }} --}}
</p>

<table>
    <thead>
        <tr>
            <th style="font-size: 1.2rem;">Date</th>
            <th style="font-size: 1.2rem;">Crisis Name</th>
            <th style="font-size: 1.2rem;">City</th>
            <th style="font-size: 1.2rem;">Amount</th>
            
        </tr>
    </thead>
    <tbody>
        @forelse($donations as $donation)
            <tr>
                <td style="font-size: 1.2rem; text-align:center;">{{ $donation->created_at->format('d M Y') }}</td>
                <td style="font-size: 1.2rem; text-align:center;">{{ $donation->crisis->title ?? 'N/A' }}</td>
                <td style="font-size: 1.2rem; text-align:center;">{{ $donation->crisis->city ?? '-' }}</td>
                <td style="font-size: 1.2rem; text-align:center;">{{ number_format($donation->amount, 2) }} BDT</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center;">No donations found.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="3" style="font-size: 1.2rem; text-align:right;">Total=</td>
            <td style="font-size: 1.2rem; text-align:center;">{{ number_format($totalAmount, 2) }} BDT</td>
        </tr>
    </tfoot>
</table>

</body>
</html>
