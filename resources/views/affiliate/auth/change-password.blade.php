@extends('affiliate.layouts.app')

@section('title', 'Change Password')
@section('description', 'Change your agent account password')
@section('body-class', 'bg-gray-50')

@section('content')
    <div class="flex justify-center items-center px-4 py-8 min-h-screen bg-gray-50">
        <div class="p-8 w-full max-w-sm text-center bg-white rounded-xl shadow-lg">
            <img src="https://www.aracarrental.com.my/images/web/homepage/new/ara-logo.png" alt="ARA Logo"
                class="mx-auto mb-4 w-auto h-12" />
            <h2 class="mb-2 text-2xl font-bold text-gray-800">Change Password</h2>
            <p class="mb-6 text-gray-700">Please set a new password for your account.</p>
            <form method="POST" action="#">
                @csrf
                <div class="mb-4">
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#EC2028]"
                        placeholder="New Password" required />
                </div>
                <div class="mb-6">
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#EC2028]"
                        placeholder="Confirm New Password" required />
                </div>
                <button type="submit"
                    class="w-full bg-[#EC2028] text-white font-semibold py-2 rounded-md hover:bg-[#d51c24] transition">Change
                    Password</button>
            </form>
        </div>
    </div>
@endsection
