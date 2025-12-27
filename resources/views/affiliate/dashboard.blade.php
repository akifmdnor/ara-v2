@extends('affiliate.layouts.app')

@section('title', 'Agent Dashboard')
@section('description', 'Agent Dashboard - Manage your bookings')

@section('content')


    <x-affiliate.affiliate-navbar :user="auth()->user()">
        <div class="flex justify-end w-full">
            <div class="flex gap-4 items-center px-5 py-2 max-w-full bg-gray-100 rounded-[20px]">
                <div class="py-2 px-4 bg-white rounded-[20px]">
                    <span class="text-base text-gray-500">Your Unique Code</span>
                    <span class="font-mono text-base font-bold text-[#4B5563]">{{ auth()->user()->unique_code }}</span>
                    <button title="Copy" onclick="copyToClipboard('{{ auth()->user()->unique_code }}')"
                        class="p-2 m-1 rounded border">
                        <img src="{{ asset('icons/copy.svg') }}" alt="Copy" class="w-5 h-5 text-gray-400" />
                    </button>
                    <button title="Share" class="p-2 m-1 rounded border">
                        <img src="{{ asset('icons/share.svg') }}" alt="Share" class="w-5 h-5 text-gray-400" />
                    </button>
                </div>
            </div>
        </div>
        <div id="dashboard-bookings" class="grid grid-cols-1 gap-8 md:grid-cols-2">
            <!-- Pending Bookings (Left) -->
            <div id="pending-section">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Pending Bookings</h2>
                    <button id="pending-view-all" class="text-[#EC2028] text-sm font-semibold focus:outline-none">View
                        All</button>
                </div>
                <div class="space-y-4">
                    @php $pendingCount = $pendingBookings->count(); @endphp
                    @foreach ($pendingBookings->take(10) as $booking)
                        <x-affiliate.booking-card :code="$booking->bk_id" :branch="$booking->car_model->branch->branch_name ?? ''" :amount="number_format($booking->amount, 2)" :dateTime="$booking->pickup_datetime
                            ? date('d/m/Y h:iA', strtotime($booking->pickup_datetime))
                            : ''"
                            :status="$booking->booking_status" :image="$booking->car_model && $booking->car_model->model_specification
                                ? $booking->car_model->model_specification->picture_url
                                : '/car.png'" :showDate="true" />
                    @endforeach
                    @if ($pendingCount > 10)
                        <div id="pending-more" class="hidden">
                            @foreach ($pendingBookings->slice(10) as $booking)
                                <x-affiliate.booking-card :code="$booking->bk_id" :branch="$booking->car_model->branch->branch_name ?? ''" :amount="number_format($booking->amount, 2)"
                                    :dateTime="$booking->pickup_datetime
                                        ? date('d/m/Y h:iA', strtotime($booking->pickup_datetime))
                                        : ''" :status="$booking->booking_status" :image="$booking->car_model && $booking->car_model->model_specification
                                        ? $booking->car_model->model_specification->picture_url
                                        : '/car.png'" :showDate="true" />
                            @endforeach
                        </div>
                    @endif
                    @if ($pendingCount === 0)
                        <div class="py-4 text-center text-gray-400">No pending
                            bookings.</div>
                    @endif
                </div>
            </div>

            <!-- Processed Bookings (Right) -->
            <div id="processed-section">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Processed Booking</h2>
                    <button id="processed-view-all" class="text-[#EC2028] text-sm font-semibold focus:outline-none">View
                        All</button>
                </div>
                <div class="space-y-4">
                    @php $processedCount = $processedBookings->count(); @endphp
                    @foreach ($processedBookings->take(10) as $booking)
                        <x-affiliate.booking-card :code="$booking->bk_id" :branch="$booking->car_model->branch->branch_name ?? ''" :carModel="$booking->car_model->name ?? ''"
                            :dateTime="$booking->pickup_datetime
                                ? date('d/m/Y h:iA', strtotime($booking->pickup_datetime))
                                : ''" :status="$booking->booking_status" :image="$booking->car_model && $booking->car_model->model_specification
                                ? $booking->car_model->model_specification->picture_url
                                : '/car.png'" :showDate="true"
                            :amount="number_format($booking->amount, 2)" />
                    @endforeach
                    @if ($processedCount > 10)
                        <div id="processed-more" class="hidden">
                            @foreach ($processedBookings->slice(10) as $booking)
                                <x-affiliate.booking-card :code="$booking->bk_id" :branch="$booking->car_model->branch_name ?? ''" :carModel="$booking->car_model->name ?? ''"
                                    :dateTime="$booking->pickup_datetime
                                        ? date('d/m/Y h:iA', strtotime($booking->pickup_datetime))
                                        : ''" :status="$booking->booking_status" :image="$booking->car_model && $booking->car_model->model_specification
                                        ? $booking->car_model->model_specification->picture_url
                                        : '/car.png'" :showDate="true"
                                    :amount="number_format($booking->amount, 2)" />
                            @endforeach
                        </div>
                    @endif
                    @if ($processedCount === 0)
                        <div class="py-4 text-center text-gray-400">No processed
                            bookings.</div>
                    @endif
                </div>
            </div>
        </div>
    </x-affiliate.affiliate-navbar>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pendingBtn = document.getElementById('pending-view-all');
            const processedBtn = document.getElementById(
                'processed-view-all');
            const pendingSection = document.getElementById(
                'pending-section');
            const processedSection = document.getElementById(
                'processed-section');
            const pendingMore = document.getElementById('pending-more');
            const processedMore = document.getElementById('processed-more');
            const dashboardGrid = document.getElementById(
                'dashboard-bookings');

            let pendingExpanded = false;
            let processedExpanded = false;

            if (pendingBtn) {
                pendingBtn.addEventListener('click', function() {
                    if (!pendingExpanded) {
                        if (pendingMore) pendingMore.classList
                            .remove('hidden');
                        pendingSection.classList.add('col-span-2',
                            'w-full');
                        processedSection.classList.add('hidden');
                        dashboardGrid.classList.remove(
                            'md:grid-cols-2');
                        pendingBtn.textContent = 'Back';
                        pendingExpanded = true;
                    } else {
                        if (pendingMore) pendingMore.classList.add(
                            'hidden');
                        pendingSection.classList.remove(
                            'col-span-2', 'w-full');
                        processedSection.classList.remove('hidden');
                        dashboardGrid.classList.add(
                            'md:grid-cols-2');
                        pendingBtn.textContent = 'View All';
                        pendingExpanded = false;
                    }
                });
            }
            if (processedBtn) {
                processedBtn.addEventListener('click', function() {
                    if (!processedExpanded) {
                        if (processedMore) processedMore.classList
                            .remove('hidden');
                        processedSection.classList.add('col-span-2',
                            'w-full');
                        pendingSection.classList.add('hidden');
                        dashboardGrid.classList.remove(
                            'md:grid-cols-2');
                        processedBtn.textContent = 'Back';
                        processedExpanded = true;
                    } else {
                        if (processedMore) processedMore.classList
                            .add('hidden');
                        processedSection.classList.remove(
                            'col-span-2', 'w-full');
                        pendingSection.classList.remove('hidden');
                        dashboardGrid.classList.add(
                            'md:grid-cols-2');
                        processedBtn.textContent = 'View All';
                        processedExpanded = false;
                    }
                });
            }
        });
    </script>
@endpush
