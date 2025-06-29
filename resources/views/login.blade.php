@extends('layouts.app')

@section('title', 'Login')
@section('description', 'Login securely to your account')
@section('body-class', 'bg-gray-50')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-8">
        <div class="w-full max-w-sm bg-white p-8 rounded-xl shadow-lg">
            <!-- Logo or brand -->
            <div class="text-center mb-6">
                <img src="https://www.aracarrental.com.my/images/web/homepage/new/ara-logo.png" alt="ARA Logo"
                    class="mx-auto h-12 w-auto" />
                <h2 class="text-2xl font-bold text-gray-800 mt-4">Welcome Back</h2>
                <p class="text-sm text-gray-500">Please login to your account</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#EC2028] @error('email') border-red-500 @enderror"
                        placeholder="you@example.com" required />
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#EC2028] @error('password') border-red-500 @enderror"
                            placeholder="********" required />
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-3 flex items-center text-sm text-gray-500 hover:text-[#EC2028]">
                            Show
                        </button>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
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
                <div class="mt-4 text-sm text-red-600 text-center">
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
