<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

<div class="bg-white p-6 rounded-lg shadow w-full max-w-md">

    <h2 class="text-xl font-bold mb-4 text-center">
        Verify Registration OTP
    </h2>

    @if(session('success'))
        <div class="mb-3 text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @error('otp')
        <div class="mb-3 text-red-600">
            {{ $message }}
        </div>
    @enderror

    <form method="POST" action="{{ route('customer.reg.otp.verify') }}">
        @csrf

        <input type="hidden" name="customer_id" value="{{ $customerId }}">

        <div class="mb-4">
            <label class="block mb-1 font-medium">OTP</label>
            <input type="text" name="otp"
                   class="w-full border p-2 rounded"
                   placeholder="Enter 6-digit OTP">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
            Verify OTP
        </button>
    </form>

</div>

</body>
</html>
