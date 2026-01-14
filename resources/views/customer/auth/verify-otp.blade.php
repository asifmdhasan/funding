<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GME Network - Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen gradient-bg">

    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">

            @if ($errors->any())
                <div class="mb-6 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="text-center text-2xl font-bold text-white mb-2">
                GME Network
            </h2>

        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="glass-effect py-10 px-8 shadow-2xl sm:rounded-3xl relative overflow-hidden">

                <form method="POST" action="{{ route('customer.verify.otp.post') }}" class="space-y-6">
                    @csrf

                    <!-- Hidden email field -->
                    {{-- <input type="hidden" name="email" value="{{ session('email') }}"> --}}
                    <input type="hidden" name="email" value="{{ $email }}">


                    <div>
                        <label for="otp" class="block text-sm font-medium text-gray-700">Enter OTP</label>
                        <input type="text" name="otp" id="otp"
                            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full px-3 py-2 bg-indigo-500 hover:bg-indigo-700 text-white rounded-md">
                        Verify OTP
                    </button>
                </form>

            </div>
        </div>

    </div>

</body>
</html>
