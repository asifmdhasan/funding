<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .letterhead {
            width: 100%;
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .letterhead h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .letterhead p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        .header {
            width: 100%;
            margin-bottom: 15px;
        }

        .header td {
            font-size: 14px;
            padding: 5px 0;
        }

        h3 {
            margin: 20px 0 5px;
            font-size: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row td {
            font-weight: bold;
            background-color: #fafafa;
        }
    </style>
</head>
<body>

{{-- Letterhead --}}
<div class="letterhead">
    <h1>Crowd Funding System</h1>
    <p>Donor Donation Report</p>
</div>

<table class="header">
    <tr>
        <td><strong>Donor Name:</strong> {{ $donor->name }}</td>
        <td style="text-align:right;">
            <strong>Report Date:</strong> {{ now()->format('d M Y') }}
        </td>
    </tr>
</table>

{{-- ================= CRISIS DONATIONS ================= --}}
<h3>Crisis Donations</h3>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Crisis</th>
            <th>Category</th>
            <th>Amount (BDT)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($crisisDonations as $row)
            <tr>
                <td>{{ \Carbon\Carbon::parse($row->last_donation_date)->format('d M Y') }}</td>
                <td>{{ $row->crisis->title ?? 'N/A' }}</td>
                <td>{{ $row->crisis->category->name ?? 'N/A' }}</td>
                <td>{{ number_format($row->total_amount, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No crisis donations found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- ================= HELPSEEKER POST DONATIONS ================= --}}
<h3>Helpseeker Post Donations</h3>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Post Title</th>
            <th>Helpseeker</th>
            <th>Amount (BDT)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($helpseekerDonations as $row)
            <tr>
                <td>{{ \Carbon\Carbon::parse($row->last_donation_date)->format('d M Y') }}</td>
                <td>{{ $row->helpseekerPost->title ?? 'N/A' }}</td>
                <td>{{ $row->helpseekerPost->helpseeker->name ?? 'N/A' }}</td>
                <td>{{ number_format($row->total_amount, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No helpseeker post donations found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- ================= GRAND TOTAL ================= --}}
<table style="margin-top:15px;">
    <tr class="total-row">
        <td colspan="3" style="text-align:right;">Grand Total</td>
        <td>{{ number_format($totalAmount, 2) }} BDT</td>
    </tr>
</table>

</body>
</html>
