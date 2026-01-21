<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 100px 20px;
            background-color: #f9f9f9;
        }
        .success-container {
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .btn-return {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            font-size: 16px;
            color: white;
            background-color: #4CAF50;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-return:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="success-container">
    <h1>🎉 Payment Successful!</h1>
    <p>Thank you for your donation.</p>

    <a href="{{ route('donor.donations') }}" class="btn-return">Go to My Donations</a>
</div>

<script>
    // Launch confetti
    confetti({
        particleCount: 150,
        spread: 70,
        origin: { y: 0.6 }
    });
</script>

</body>
</html>
