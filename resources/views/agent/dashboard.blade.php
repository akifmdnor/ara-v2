@extends('layouts.app')

@section('title', 'Agent Dashboard')
@section('description', 'Agent Dashboard - Manage your bookings')

@section('content')
    <x-agent-navbar :user="auth()->user()">
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
                        <x-booking-card :code="$booking->bk_id" :branch="$booking->branch->name ?? ''" :amount="number_format($booking->amount, 2)" :dateTime="$booking->pickup_datetime
                            ? date('d/m/Y h:iA', strtotime($booking->pickup_datetime))
                            : ''"
                            :status="$booking->booking_status" :image="$booking->car_model && $booking->car_model->model_specification
                                ? $booking->car_model->model_specification->picture_url
                                : '/car.png'" :showDate="true" />
                    @endforeach
                    @if ($pendingCount > 10)
                        <div id="pending-more" class="hidden">
                            @foreach ($pendingBookings->slice(10) as $booking)
                                <x-booking-card :code="$booking->bk_id" :branch="$booking->branch->name ?? ''" :amount="number_format($booking->amount, 2)" :dateTime="$booking->pickup_datetime
                                    ? date('d/m/Y h:iA', strtotime($booking->pickup_datetime))
                                    : ''"
                                    :status="$booking->booking_status" :image="$booking->car_model && $booking->car_model->model_specification
                                        ? $booking->car_model->model_specification->picture_url
                                        : '/car.png'" :showDate="true" />
                            @endforeach
                        </div>
                    @endif
                    @if ($pendingCount === 0)
                        <div class="py-4 text-center text-gray-400">No pending bookings.</div>
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
                        <x-booking-card :code="$booking->bk_id" :branch="$booking->branch->name ?? ''" :carModel="$booking->car_model->name ?? ''" :dateTime="$booking->pickup_datetime
                            ? date('d/m/Y h:iA', strtotime($booking->pickup_datetime))
                            : ''"
                            :status="$booking->booking_status" :image="$booking->car_model && $booking->car_model->model_specification
                                ? $booking->car_model->model_specification->picture_url
                                : '/car.png'" :showDate="true" />
                    @endforeach
                    @if ($processedCount > 10)
                        <div id="processed-more" class="hidden">
                            @foreach ($processedBookings->slice(10) as $booking)
                                <x-booking-card :code="$booking->bk_id" :branch="$booking->branch->name ?? ''" :carModel="$booking->car_model->name ?? ''" :dateTime="$booking->pickup_datetime
                                    ? date('d/m/Y h:iA', strtotime($booking->pickup_datetime))
                                    : ''"
                                    :status="$booking->booking_status" :image="$booking->car_model && $booking->car_model->model_specification
                                        ? $booking->car_model->model_specification->picture_url
                                        : '/car.png'" :showDate="true" />
                            @endforeach
                        </div>
                    @endif
                    @if ($processedCount === 0)
                        <div class="py-4 text-center text-gray-400">No processed bookings.</div>
                    @endif
                </div>
            </div>
        </div>
    </x-agent-navbar>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pendingBtn = document.getElementById('pending-view-all');
            const processedBtn = document.getElementById('processed-view-all');
            const pendingSection = document.getElementById('pending-section');
            const processedSection = document.getElementById('processed-section');
            const pendingMore = document.getElementById('pending-more');
            const processedMore = document.getElementById('processed-more');
            const dashboardGrid = document.getElementById('dashboard-bookings');

            let pendingExpanded = false;
            let processedExpanded = false;

            if (pendingBtn) {
                pendingBtn.addEventListener('click', function() {
                    if (!pendingExpanded) {
                        if (pendingMore) pendingMore.classList.remove('hidden');
                        pendingSection.classList.add('col-span-2', 'w-full');
                        processedSection.classList.add('hidden');
                        dashboardGrid.classList.remove('md:grid-cols-2');
                        pendingBtn.textContent = 'Back';
                        pendingExpanded = true;
                    } else {
                        if (pendingMore) pendingMore.classList.add('hidden');
                        pendingSection.classList.remove('col-span-2', 'w-full');
                        processedSection.classList.remove('hidden');
                        dashboardGrid.classList.add('md:grid-cols-2');
                        pendingBtn.textContent = 'View All';
                        pendingExpanded = false;
                    }
                });
            }
            if (processedBtn) {
                processedBtn.addEventListener('click', function() {
                    if (!processedExpanded) {
                        if (processedMore) processedMore.classList.remove('hidden');
                        processedSection.classList.add('col-span-2', 'w-full');
                        pendingSection.classList.add('hidden');
                        dashboardGrid.classList.remove('md:grid-cols-2');
                        processedBtn.textContent = 'Back';
                        processedExpanded = true;
                    } else {
                        if (processedMore) processedMore.classList.add('hidden');
                        processedSection.classList.remove('col-span-2', 'w-full');
                        pendingSection.classList.remove('hidden');
                        dashboardGrid.classList.add('md:grid-cols-2');
                        processedBtn.textContent = 'View All';
                        processedExpanded = false;
                    }
                });
            }
        });
    </script>
@endpush
