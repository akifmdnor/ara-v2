<template>
    <Navbar>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Pending Bookings (Left) -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Pending Bookings</h2>
                    <a href="#" class="text-[#EC2028] text-sm font-semibold"
                        >View All</a
                    >
                </div>
                <div class="space-y-4">
                    <BookingCard
                        v-for="booking in pendingBookings"
                        :key="booking.code + booking.status"
                        v-bind="booking"
                    />
                </div>
            </div>
            <!-- Processed Bookings (Right) -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg font-semibold">Processed Booking</h2>
                    <a href="#" class="text-[#EC2028] text-sm font-semibold"
                        >View All</a
                    >
                </div>
                <div class="space-y-4">
                    <BookingCard
                        v-for="booking in processedBookings"
                        :key="booking.code + booking.status"
                        v-bind="booking"
                    />
                </div>
            </div>
        </div>
    </Navbar>
</template>

<script>
import Navbar from "../Navbar.vue";
import BookingCard from "./BookingCard.vue";

export default {
    name: "Dashboard",
    components: { Navbar, BookingCard },
    data() {
        return {
            pendingBookings: [
                {
                    code: "BK2326",
                    branch: "ARA Car Rental - HQ",
                    amount: "2,231.12",
                    dateTime: "08/08/2024 12:08PM",
                    status: "Pending",
                    image: "/car.png",
                    showDate: true,
                },
                {
                    code: "BK2327",
                    branch: "ARA Car Rental - HQ",
                    amount: "1,500.00",
                    dateTime: "08/08/2024 13:00PM",
                    status: "Pending",
                    image: "/car.png",
                    showDate: true,
                },
                {
                    code: "BK2328",
                    branch: "ARA Car Rental - HQ",
                    amount: "3,000.00",
                    dateTime: "08/08/2024 14:30PM",
                    status: "Pending",
                    image: "/car.png",
                    showDate: true,
                },
            ],
            processedBookings: [
                {
                    code: "BK2326",
                    branch: "ARA Car Rental - HQ",
                    carModel: "Hyundai Staria Max",
                    dateTime: "08/08/2024 12:08PM",
                    status: "Processing",
                    image: "/car.png",
                    showDate: true,
                },
                {
                    code: "BK2327",
                    branch: "ARA Car Rental - HQ",
                    carModel: "Hyundai Staria Max",
                    dateTime: "08/08/2024 13:00PM",
                    status: "Completed",
                    image: "/car.png",
                    showDate: true,
                },
                {
                    code: "BK2328",
                    branch: "ARA Car Rental - HQ",
                    carModel: "Hyundai Staria Max",
                    dateTime: "08/08/2024 14:30PM",
                    status: "Cancelled",
                    image: "/car.png",
                    showDate: true,
                },
            ],
        };
    },
};
</script>
