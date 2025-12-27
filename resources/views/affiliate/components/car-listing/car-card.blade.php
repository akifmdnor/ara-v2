<div class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-sm transition-shadow duration-200 hover:shadow-md md:min-w-[250px]"
    @click="selectCar(car)">
    <!-- Car Image -->
    <div class="flex relative justify-center items-center aspect-square md:m-w-[250px]">
        <img :src="car.model_specification ? car.model_specification.picture_url || '/images/car-placeholder.jpg' :
            '/images/car-placeholder.jpg'"
            :alt="car.model_specification ? car.model_specification.model_name || 'Car' : 'Car'"
            class="object-contain w-full h-auto">

        <!-- Promo Badge -->
        <div x-show="car.is_promo"
            class="absolute top-2 right-2 px-2 py-1 text-xs font-bold text-white bg-yellow-500 rounded-full">
            PROMO
        </div>
    </div>

    <!-- Car Details -->
    <div>
        <!-- Car Name -->
        <h3 class="mb-4 text-lg font-bold text-center text-gray-900"
            x-text="car.model_specification ? car.model_specification.model_name || 'Unknown Model' : 'Unknown Model'">
        </h3>

        <!-- Car Specifications Grid -->
        <div class="grid grid-cols-3 gap-3 mx-3 mb-4">
            <!-- Luggage -->
            <div class="flex items-center space-x-2">
                <img src="/icons/luggage.svg" alt="Luggage" class="w-4 h-4 text-gray-500">
                <span class="text-xs text-gray-500"
                    x-text="(car.model_specification ? car.model_specification.luggage : 'N/A') + ' Luggage'"></span>
            </div>

            <!-- Seats -->
            <div class="flex items-center space-x-2">
                <img src="/icons/seat.svg" alt="Seats" class="w-4 h-4 text-gray-500">
                <span class="text-xs text-gray-500"
                    x-text="(car.model_specification ? car.model_specification.seats : 'N/A') + ' Seats'"></span>
            </div>

            <!-- Doors -->
            <div class="flex items-center space-x-2">
                <img src="/icons/door.svg" alt="Doors" class="w-4 h-4 text-gray-500">
                <span class="text-xs text-gray-500"
                    x-text="(car.model_specification ? car.model_specification.doors : 'N/A') + ' Doors'"></span>
            </div>

            <!-- Transmission -->
            <div class="flex items-center space-x-2">
                <img src="/icons/transmission.svg" alt="Transmission" class="w-4 h-4 text-gray-500">
                <span class="text-xs text-gray-500"
                    x-text="car.model_specification ? (car.model_specification.transmission_type || 'Auto') : 'Auto'"></span>
            </div>

            <!-- Engine -->
            <div class="flex items-center space-x-2">
                <img src="/icons/engine.svg" alt="Engine" class="w-4 h-4 text-gray-500">
                <span class="text-xs text-gray-500"
                    x-text="(car.model_specification ? car.model_specification.fuel_tank : 'N/A') + ' L'"></span>
            </div>

            <!-- Fuel Type -->
            <div class="flex items-center space-x-2">
                <img src="/icons/petrol.svg" alt="Fuel Type" class="w-4 h-4 text-gray-500">
                <span class="text-xs text-gray-500"
                    x-text="car.model_specification ? car.model_specification.fuel_type || 'Petrol' : 'Petrol'"></span>
            </div>
        </div>

        <!-- Action Section -->
        <div class="mt-4">
            <!-- Unavailable Car -->
            <div x-show="car.unavailable" class="px-4 py-3 w-full font-semibold text-gray-700 bg-gray-200 rounded-b-lg">
                Fully Booked
            </div>

            <!-- Available Car (Clickable) -->
            <div x-show="!car.unavailable"
                class="block px-4 py-3 w-full font-semibold text-center text-white bg-red-600 rounded-b-lg transition duration-200 hover:bg-red-700">
                View More
            </div>
        </div>
    </div>
</div>
