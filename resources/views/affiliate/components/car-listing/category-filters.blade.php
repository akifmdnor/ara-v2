<div class="flex flex-wrap mb-4">
    <button @click="setCategory('All')"
        :class="searchParams.category.includes('All') ? 'bg-red-600 text-white shadow-md' :
            'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'"
        class="px-3 py-3 font-medium rounded-tl-lg shadow-sm transition duration-200">
        All
    </button>
    <template x-for="(category, index) in categories" :key="category">
        <button @click="toggleCategory(category)"
            :class="[
                searchParams.category.includes(category) ? 'bg-red-600 text-white shadow-md' :
                'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50',
                index === categories.length - 1 ? 'rounded-tr-lg' : ''
            ]"
            class="px-3 py-3 font-medium shadow-sm transition duration-200" x-text="category">
        </button>
    </template>
</div>
