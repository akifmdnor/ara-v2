@extends('layouts.app')

@section('title', 'Book Car - ' . ($carModel->model_specification->model_name ?? 'Car'))
@section('description', 'Confirm your car booking')

@section('content')
    <x-affiliate-navbar :user="auth()->user()" headerText="Book Car">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl border border-gray-100 shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Book Your Car</h1>
                    <a href="{{ route('affiliate.car-listing.index') }}" class="text-red-600 hover:text-red-700 font-medium">
                        ← Back to Car Listing
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Car Details -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Selected Car</h2>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <img src="{{ $carModel->model_specification->picture_url ?? '/images/car-placeholder.jpg' }}"
                                alt="{{ $carModel->model_specification->model_name ?? 'Car' }}"
                                class="w-full h-48 object-cover rounded-lg mb-4">

                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                {{ $carModel->model_specification->model_name ?? 'Unknown Model' }}
                            </h3>

                            <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                                <div>
                                    <span class="font-medium">Doors:</span>
                                    {{ $carModel->model_specification->doors ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Seats:</span>
                                    {{ $carModel->model_specification->seats ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Luggage:</span>
                                    {{ $carModel->model_specification->luggage ?? 'N/A' }} Bags
                                </div>
                                <div>
                                    <span class="font-medium">Fuel:</span>
                                    {{ $carModel->model_specification->fuel_type ?? 'N/A' }}
                                </div>
                                <div>
                                    <span class="font-medium">Engine:</span>
                                    {{ $carModel->model_specification->fuel_tank ?? 'N/A' }} L
                                </div>
                                <div>
                                    <span class="font-medium">Transmission:</span>
                                    {{ $carModel->model_specification->transmission_type ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Booking Details</h2>

                        <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                            <div>
                                <h3 class="font-medium text-gray-900 mb-2">Pickup Details</h3>
                                <div class="text-sm text-gray-600">
                                    <div><span class="font-medium">Location:</span>
                                        {{ $searchParams['pickup_location'] ?: 'Not specified' }}</div>
                                    <div><span class="font-medium">Date:</span>
                                        {{ $searchParams['pickup_date'] ?: 'Not specified' }}</div>
                                    <div><span class="font-medium">Time:</span> {{ $searchParams['pickup_time'] }}</div>
                                </div>
                            </div>

                            <div>
                                <h3 class="font-medium text-gray-900 mb-2">Return Details</h3>
                                <div class="text-sm text-gray-600">
                                    <div><span class="font-medium">Location:</span>
                                        {{ $searchParams['return_location'] ?: 'Not specified' }}</div>
                                    <div><span class="font-medium">Date:</span>
                                        {{ $searchParams['return_date'] ?: 'Not specified' }}</div>
                                    <div><span class="font-medium">Time:</span> {{ $searchParams['return_time'] }}</div>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Price per day:</span>
                                    <span
                                        class="text-2xl font-bold text-red-600">RM{{ number_format($carModel->price_day) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-3">
                            <button
                                class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg font-semibold transition duration-200">
                                Proceed to Booking
                            </button>

                            <button onclick="window.history.back()"
                                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 px-4 rounded-lg font-semibold transition duration-200">
                                Back to Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </x-affiliate-navbar>
@endsection
