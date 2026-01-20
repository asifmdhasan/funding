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
    <h1>Crowd Funding System</h1>
    <p>Help Post Donation Report</p>
</div>

<p>
    <strong>Helpseeker Name:</strong> {{ auth('helpseeker')->user()->name }}<br>
    <strong>Post Title:</strong> {{ $post->title }}<br>
    <strong>Report Date:</strong> {{ now()->format('d M Y') }}
</p>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Donor Name</th>
            <th>Donor Email</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @forelse($donations as $donation)
            <tr>
                <td style="text-align:center;">{{ $donation->created_at->format('d M Y') }}</td>
                <td style="text-align:center;">{{ $donation->donor->name ?? '-' }}</td>
                <td style="text-align:center;">{{ $donation->donor->email ?? '-' }}</td>
                <td style="text-align:center;">{{ number_format($donation->amount, 2) }} BDT</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align:center;">No donations yet.</td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td colspan="3" style="text-align:right;">Total Amount</td>
            <td>{{ number_format($totalAmount, 2) }} BDT</td>
        </tr>
    </tfoot>
</table>

</body>
</html>
