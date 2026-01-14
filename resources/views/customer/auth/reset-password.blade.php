<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - GME Network</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>

<body class="min-h-screen gradient-bg flex items-center justify-center px-4">

    <div class="w-full max-w-md glass-effect p-8 rounded-3xl shadow-2xl relative">

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Reset Your Password
        </h2>

        {{-- Error Message --}}
        @if ($errors->any())
            <div class="mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 rounded border border-green-400 bg-green-100 px-4 py-3 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('customer.reset.password.post') }}" method="POST" class="space-y-5">

            @csrf

            {{-- Required hidden email field --}}
            <input type="hidden" name="email" value="{{ session('email') }}">

            <div>
                <label class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm 
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm 
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow 
                       hover:bg-indigo-700 transform hover:-translate-y-0.5 transition">
                Reset Password
            </button>

        </form>

    </div>

</body>
</html>
