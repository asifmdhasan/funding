<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 0; padding: 0; }
        .letterhead {
            width: 100%;
            padding: 10px 0;
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
        }
        .letterhead h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .letterhead p {
            margin: 2px 0 0 0;
            font-size: 12px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        h3 {
            margin-bottom: 10px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .total-row td {
            font-weight: bold;
            background-color: #fafafa;
        }
    </style>
</head>
<body>

<!-- Letterhead -->
<div class="letterhead">
    <h1>Crowd Funding System</h1>
    <p style="font-size: 1.2rem">Donor Donation Report</p>
</div>

<div class="header">
    <div><strong style="font-size: 1.2rem">Donor Name:</strong> <span style="font-size: 1.2rem">{{ $donor->name }}</span></div>
    <div><strong style="font-size: 1.2rem">Report Date:</strong> <span style="font-size: 1.2rem">{{ now()->format('d M Y') }}</span></div>
</div>

<table>
    <thead>
        <tr>
            <th style="font-size: 1.2rem">Crisis</th>
            <th style="font-size: 1.2rem">Category</th>
            <th style="font-size: 1.2rem">Amount</th>
            <th style="font-size: 1.2rem">Donation Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donations as $row)
            <tr>
                <td style="font-size: 1.2rem; text-align: center">{{ $row->crisis->title }}</td>
                <td style="font-size: 1.2rem; text-align: center">{{ $row->crisis->category->name ?? 'N/A' }}</td>
                <td style="font-size: 1.2rem; text-align: center">{{ number_format($row->total_amount, 2) }} BDT</td>
                <td style="font-size: 1.2rem; text-align: center">{{ \Carbon\Carbon::parse($row->last_donation_date)->format('d M Y') }}</td>
            </tr>
        @endforeach

        {{-- Total Row --}}
        <tr class="total-row">
            <td colspan="2" style="text-align:right; font-size: 1.2rem;">Total</td>
            <td style="font-size: 1.2rem; text-align: center">{{ number_format($totalAmount, 2) }} BDT</td>
            <td></td>
        </tr>
    </tbody>
</table>

</body>
</html>
