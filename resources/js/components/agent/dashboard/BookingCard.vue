<template>
    <div class="flex bg-white p-4 rounded shadow items-center">
        <img :src="image" class="w-24 h-16 object-cover rounded mr-4" />
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <p class="font-bold text-[#EC2028]">{{ code }}</p>
                <span
                    v-if="showDate"
                    class="text-xs text-gray-400 flex items-center gap-1"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 inline"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                    {{ dateTime }}
                </span>
            </div>
            <p class="text-sm text-gray-600">Branch: {{ branch }}</p>
            <p v-if="amount" class="text-sm text-gray-600">
                Amount (RM): {{ amount }}
            </p>
            <p v-if="carModel" class="text-sm text-gray-600">
                Car Model: {{ carModel }}
            </p>
            <div class="flex items-center mt-1">
                <span
                    class="text-xs font-semibold px-2 py-1 rounded"
                    :class="badgeClass(status)"
                    >{{ status }}</span
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BookingCard",
    props: {
        code: String,
        branch: String,
        amount: String,
        dateTime: String,
        carModel: String,
        status: String,
        image: {
            type: String,
            default: "/car.png",
        },
        showDate: {
            type: Boolean,
            default: true,
        },
    },
    methods: {
        badgeClass(status) {
            switch (status) {
                case "Pending":
                    return "bg-orange-50 text-orange-600";
                case "Processing":
                    return "bg-purple-50 text-purple-600";
                case "Completed":
                    return "bg-green-50 text-green-600";
                case "Cancelled":
                    return "bg-red-50 text-red-600";
                default:
                    return "bg-gray-100 text-gray-500";
            }
        },
    },
};
</script>
