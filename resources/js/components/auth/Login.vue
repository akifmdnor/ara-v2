<template>
    <div
        class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-8"
    >
        <div class="w-full max-w-sm bg-white p-8 rounded-xl shadow-lg">
            <!-- Logo or brand -->
            <div class="text-center mb-6">
                <img
                    src="https://www.aracarrental.com.my/images/web/homepage/new/ara-logo.png"
                    alt="ARA Logo"
                    class="mx-auto h-12 w-auto"
                />
                <h2 class="text-2xl font-bold text-gray-800 mt-4">
                    Welcome Back
                </h2>
                <p class="text-sm text-gray-500">
                    Please login to your agent account
                </p>
            </div>

            <!-- Form -->
            <form @submit.prevent="submitLogin" class="space-y-5">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Email</label
                    >
                    <input
                        type="email"
                        v-model="email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#EC2028]"
                        placeholder="you@example.com"
                        required
                    />
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Password</label
                    >
                    <div class="relative">
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            v-model="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#EC2028]"
                            placeholder="********"
                            required
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-3 flex items-center text-sm text-gray-500 hover:text-[#EC2028]"
                        >
                            {{ showPassword ? "Hide" : "Show" }}
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-[#EC2028] text-white font-semibold py-2 rounded-md hover:bg-[#d51c24] transition"
                >
                    Login
                </button>
            </form>

            <!-- Optional: error or status -->
            <div v-if="error" class="mt-4 text-sm text-red-600 text-center">
                {{ error }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            email: "",
            password: "",
            showPassword: false,
            error: null,
        };
    },
    methods: {
        async submitLogin() {
            this.error = null;
            try {
                if (!this.email || !this.password) {
                    throw new Error("Email and password are required.");
                }

                const response = await axios.post("/agent/login", {
                    email: this.email,
                    password: this.password,
                });

                // On success, redirect to dashboard
                window.location.href = "/agent/dashboard";
            } catch (err) {
                if (err.response && err.response.status === 422) {
                    // Laravel validation or auth error
                    this.error =
                        err.response.data.errors?.email?.[0] ||
                        err.response.data.message ||
                        "Invalid credentials.";
                } else {
                    this.error = err.message || "Login failed.";
                }
            }
        },
    },
};
</script>
