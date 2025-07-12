@extends('layouts.app')

@section('title', 'Login')
@section('description', 'Login securely to your account')
@section('body-class', 'bg-gray-50')

@section('content')
    <div class="flex justify-center items-center px-4 py-8 min-h-screen bg-gray-50">
        <div class="p-8 w-full max-w-sm bg-white rounded-xl shadow-lg">
            <!-- Logo or brand -->
            <div class="mb-6 text-center">
                <img src="https://www.aracarrental.com.my/images/web/homepage/new/ara-logo.png" alt="ARA Logo"
                    class="mx-auto w-auto h-12" />
                <h2 class="mt-4 text-2xl font-bold text-gray-800">Welcome Back</h2>
                <p class="text-sm text-gray-500">Please login to your account</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 borderrounded-md focus:outline-none focus:ring-2 focus:ring-[#EC2028] @error{{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                        placeholder="you@example.com" required />
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#EC2028] {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="********" required />
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-sm text-gray-500 hover:text-[#EC2028]">
                            Show
                        </button>

                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-[#EC2028] text-white font-semibold py-2 rounded-md hover:bg-[#d51c24] transition">
                    Login
                </button>
            </form>

            <!-- Error messages -->
            @if ($errors->any())
                <div class="mt-4 text-sm text-center text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const toggleButton = event.target;

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleButton.textContent = 'Hide';
                } else {
                    passwordInput.type = 'password';
                    toggleButton.textContent = 'Show';
                }
            }
        </script>
    @endpush
@endsection
