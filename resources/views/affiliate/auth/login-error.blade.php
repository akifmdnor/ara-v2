@extends('affiliate.layouts.app')

@section('title', 'Login Failed')
@section('description', 'Agent login failed')
@section('body-class', 'bg-gray-50')

@section('content')
    <div class="flex justify-center items-center px-4 py-8 min-h-screen bg-gray-50">
        <div class="p-8 w-full max-w-sm text-center bg-white rounded-xl shadow-lg">
            <img src="https://www.aracarrental.com.my/images/web/homepage/new/ara-logo.png" alt="ARA Logo"
                class="mx-auto mb-4 w-auto h-12" />
            <h2 class="mb-2 text-2xl font-bold text-red-600">Login Failed</h2>
            <p class="mb-6 text-gray-700">The email or password you entered is incorrect.</p>
            <a href="{{ route('affiliate.login') }}"
                class="inline-block bg-[#EC2028] text-white px-6 py-2 rounded-md font-semibold hover:bg-[#d51c24] transition">Try
                Again</a>
        </div>
    </div>
@endsection
