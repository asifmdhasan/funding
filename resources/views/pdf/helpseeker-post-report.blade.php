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
        .letterhead h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .letterhead p { margin: 2px 0 0 0; font-size: 12px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        h3 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .total-row td { font-weight: bold; background-color: #fafafa; }
        .file-preview img { max-width: 150px; max-height: 150px; }
    </style>
</head>
<body>

<!-- Letterhead -->
<div class="letterhead">
    <h1>Crowd Funding System</h1>
    <p style="font-size: 1.2rem">Help Post Donation Report</p>
</div>

<div class="header">
    <div>
        <strong style="font-size: 1.2rem">Help Post Title:</strong>
        <span style="font-size: 1.2rem">{{ $post->title }}</span>
    </div>
    <div>
        <strong style="font-size: 1.2rem">Report Date:</strong>
        <span style="font-size: 1.2rem">{{ now()->format('d M Y') }}</span>
    </div>
</div>

<div class="header mb-2">
    <div>
        <strong>Required Amount:</strong> {{ number_format($post->required_amount, 2) }} BDT
    </div>
    <div>
        <strong>Total Collected:</strong> {{ number_format($totalAmount, 2) }} BDT
    </div>
</div>

@if($post->file_path)
<div class="file-preview mb-3">
    <strong>Attached File / Image:</strong>
    <div>
        @if(Str::endsWith($post->file_path, ['jpg','jpeg','png','gif']))
            <img src="{{ public_path($post->file_path) }}" alt="Post File">
        @else
            <a href="{{ public_path($post->file_path) }}">Download File</a>
        @endif
    </div>
</div>
@endif

<table>
    <thead>
        <tr>
            <th>Donation Date</th>
            <th>Donor Name</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donations as $donation)
            <tr>
                <td style="text-align:center">{{ \Carbon\Carbon::parse($donation->created_at)->format('d M Y') }}</td>
                <td style="text-align:center">{{ $donation->donor->name ?? 'N/A' }}</td>
                <td style="text-align:center">{{ number_format($donation->amount, 2) }} BDT</td>
            </tr>
        @endforeach

        <tr class="total-row">
            <td></td>
            <td style="text-align:right; font-size: 1.2rem;">Total</td>
            <td style="text-align:center; font-size: 1.2rem;">{{ number_format($totalAmount, 2) }} BDT</td>
        </tr>
    </tbody>
</table>

</body>
</html>
