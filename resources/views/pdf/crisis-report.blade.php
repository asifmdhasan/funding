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
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
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
    <h1>Crowed Funding System</h1>
    <p style="font-size: 1.2rem">Crisis Report</p>
</div>

<div class="header">
    <div><strong style="font-size: 1.2rem">Start Date:</span></strong><span style="font-size: 1.1rem"> {{ $crisis->created_at->format('d M Y') }}</div>
</div>

<p style="font-size: 1.1rem">
    <strong>Crisis:</strong> {{ $crisis->title }}<br>
    <strong>Category:</strong> {{ $crisis->category->name ?? 'N/A' }}
</p>

<table>
    <thead>
        <tr>
            <th style="font-size: 1.1rem">Donation Date</th>
            <th style="font-size: 1.1rem">Donor</th>
            <th style="font-size: 1.1rem">Amount</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($donations as $row)
            <tr>
                <td style="font-size: 1.1rem; text-align: center">{{ \Carbon\Carbon::parse($row->last_donation_date)->format('d M Y') }}</td>
                <td style="font-size: 1.1rem; text-align: center">{{ $row->donor->name }}</td>
                <td style="font-size: 1.1rem; text-align: center">{{ number_format($row->total_amount, 2) }} BDT</td>
                
            </tr>
        @endforeach

        {{-- Total Row --}}
        <tr class="total-row">
            <td></td>
            <td style="text-align:right; font-size: 1.2rem;">Total</td>
            <td style="font-size: 1.2rem;text-align: center">{{ number_format($totalAmount, 2) }} BDT</td>
            
        </tr>
    </tbody>
</table>

</body>
</html>
