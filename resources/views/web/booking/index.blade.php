@extends('web.layouts.app')

@section('title', 'Booking & Payment - ARA Car Rental')

@section('content')
    <div class="w-full min-h-screen bg-white">
        {{-- Navigation --}}
        @include('web.components.navbar')

        {{-- Main Content --}}
        <div class="w-full bg-white">
            {{-- Stepper --}}
            <div class="mx-auto max-w-[1280px] pt-12">
                @include('web.components.stepper', ['currentStep' => 4])
            </div>

            {{-- Content Area --}}
            <div class="flex mx-auto max-w-[1280px] gap-2.5 pt-12 pb-[148px]">
                {{-- Sidebar --}}
                <div class="shrink-0 w-[300px]">
                    @include('web.components.booking-sidebar', [
                        'carDetails' => $carDetails,
                        'addons' => $addons ?? [],
                    ])
                </div>

                {{-- Main Content --}}
                <div class="flex flex-col flex-1 w-[968px] gap-2.5" x-data="{ showStripeForm: false }">
                    {{-- Payment Card - Figma Design --}}
                    <div class="flex flex-col items-center justify-center gap-6 p-6 bg-white border border-[#e4e4e7] rounded-lg min-h-[766px]"
                        style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05), 0px 6px 24px 0px rgba(0,0,0,0.05);">

                        {{-- Header Section --}}
                        <div class="flex flex-col gap-1 justify-center items-center text-center">
                            <p class="text-sm font-medium text-[#18181b] leading-5">
                                Pay booking deposit
                            </p>
                            <p class="text-[30px] font-semibold text-[#ff6a0c] leading-[38px]">
                                RM {{ number_format($carDetails['security_deposit'] ?? 0, 2) }}
                            </p>
                            <p class="text-sm font-medium text-[#18181b] leading-5">
                                now via:
                            </p>
                        </div>

                        {{-- Payment Selection (Default View) --}}
                        <div x-show="!showStripeForm" class="flex gap-6 justify-center items-center w-full">
                            {{-- Credit Card Button (Stripe) --}}
                            <div class="flex flex-col gap-1 items-center">
                                <button @click="showStripeForm = true; initializeStripe()"
                                    class="flex items-center justify-center gap-[6px] h-11 px-[10px] py-2 bg-white border border-[#e4e4e7] rounded-lg hover:border-[#ec2028] transition-colors"
                                    style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.6667 3.33334H3.33333C2.41286 3.33334 1.66667 4.07954 1.66667 5.00001V15C1.66667 15.9205 2.41286 16.6667 3.33333 16.6667H16.6667C17.5871 16.6667 18.3333 15.9205 18.3333 15V5.00001C18.3333 4.07954 17.5871 3.33334 16.6667 3.33334Z"
                                            stroke="#3F3F46" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M1.66667 8.33334H18.3333" stroke="#3F3F46" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="text-lg font-medium text-[#3f3f46] leading-[26px]">Credit Card</span>
                                </button>
                                <div class="flex gap-1 items-start">
                                    <span class="text-xs font-medium text-[#18181b] leading-[18px]">Powered by</span>
                                    <span class="text-xs font-semibold text-[#635bff] leading-[18px]">stripe</span>
                                </div>
                            </div>

                            {{-- Online Banking Button (Billplz) --}}
                            <div class="flex flex-col gap-1 items-center">
                                <form action="{{ route('web.billplz.process', ['booking' => $booking->id]) }}"
                                    method="POST" id="billplz-form">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center justify-center gap-[6px] h-11 px-[10px] py-2 bg-white border border-[#e4e4e7] rounded-lg hover:border-[#ec2028] transition-colors"
                                        style="box-shadow: 0px 1px 3px 0px rgba(0,0,0,0.07);">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M8.5 15.5833C12.4119 15.5833 15.5833 12.4119 15.5833 8.49999C15.5833 4.58806 12.4119 1.41666 8.5 1.41666C4.58807 1.41666 1.41667 4.58806 1.41667 8.49999C1.41667 12.4119 4.58807 15.5833 8.5 15.5833Z"
                                                stroke="#3F3F46" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M1.41667 8.5H15.5833" stroke="#3F3F46" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M8.5 1.41666C10.2663 3.33129 11.2589 5.85567 11.2589 8.49999C11.2589 11.1443 10.2663 13.6687 8.5 15.5833C6.73369 13.6687 5.74113 11.1443 5.74113 8.49999C5.74113 5.85567 6.73369 3.33129 8.5 1.41666Z"
                                                stroke="#3F3F46" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-lg font-medium text-[#3f3f46] leading-[26px]">Online
                                            Banking</span>
                                    </button>
                                </form>
                                <div class="flex gap-1 items-start">
                                    <span class="text-xs font-medium text-[#18181b] leading-[18px]">Powered by</span>
                                    <img src="https://www.billplz.com/assets/brand/logo-1cd67bf944e1f4f8927c49257cea2aeb.svg"
                                        alt="Billplz" class="h-[18px]">
                                </div>
                            </div>
                        </div>

                        {{-- Stripe Payment Form --}}
                        <div x-show="showStripeForm" x-transition class="w-full max-w-md mx-auto">
                            {{-- Back Button --}}
                            <div class="flex justify-start mb-4">
                                <button @click="showStripeForm = false"
                                    class="flex items-center gap-2 text-sm font-medium text-[#3f3f46] hover:text-[#18181b]">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M15 18l-6-6 6-6"/>
                                    </svg>
                                    Back to Payment Options
                                </button>
                            </div>

                            {{-- Stripe Form --}}
                            <div class="bg-white rounded-lg p-6 border border-[#e4e4e7]"
                                style="box-shadow: 0px 2px 6px 0px rgba(0,0,0,0.05);">
                                <div class="text-center mb-4">
                                    <h3 class="text-lg font-semibold text-[#18181b] mb-2">Enter Card Details</h3>
                                    <p class="text-sm text-[#6b6b74]">Secure payment powered by Stripe</p>
                                </div>

                                <form id="payment-form" class="space-y-4">
                                    <div id="payment-element">
                                        <!--Stripe.js injects the Payment Element-->
                                    </div>
                                    <button id="submit" class="w-full bg-[#635bff] text-white py-3 px-4 rounded-lg font-medium hover:bg-[#5a52e0] transition-colors">
                                        <div class="spinner hidden" id="spinner"></div>
                                        <span id="button-text">Pay RM {{ number_format($carDetails['security_deposit'] ?? 0, 2) }}</span>
                                    </button>
                                    <div id="payment-message" class="hidden text-sm text-red-600 mt-2"></div>
                                </form>

                                <div class="text-center mt-4">
                                    <img src="https://js.stripe.com/v3/fingerprinted/img/powered_by_stripe@2x.png"
                                         alt="Powered by Stripe" style="width: 120px; height: auto;">
                                </div>
                            </div>
                        </div>

                        {{-- Terms Text (only show when not in Stripe form) --}}
                        <div x-show="!showStripeForm" class="flex flex-col gap-2 items-center text-sm leading-5 text-center">
                            <p class="font-normal text-[#6b6b74]">
                                By making payment, you agree that you have read and understood our
                            </p>
                            <div class="flex gap-2 justify-center items-center">
                                <a href="#" class="font-medium text-[#3f3f46] underline hover:text-[#18181b]">Terms &
                                    Conditions</a>
                                <span class="font-normal text-[#6b6b74]">and</span>
                                <a href="#" class="font-medium text-[#3f3f46] underline hover:text-[#18181b]">Privacy
                                    Policy</a>
                            </div>
                        </div>

                        {{-- Email Quotation Link --}}
                        <div x-show="!showStripeForm" class="flex justify-center items-center pt-4">
                            <a href="#" class="text-center text-sm font-medium text-[#3f3f46] underline hover:text-[#18181b]">
                                Email this quotation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Stripe JavaScript --}}
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Global variables for Stripe
        let stripe;
        let elements;

        // Initialize Stripe when the form becomes visible
        function initializeStripe() {
            if (typeof window.stripeInitialized === 'undefined') {
                // This is your publishable API key.
                stripe = Stripe('{{ config("services.stripe.key") }}');

                // The items the customer wants to buy
                const items = [{
                    id: {{ $booking->id }}
                }];

                initialize();
                checkStatus();

                // Mark as initialized to prevent re-initialization
                window.stripeInitialized = true;
            }
        }

        // Fetches a payment intent and captures the client secret
        async function initialize() {
            const { clientSecret } = await fetch('/payment/process/stripe', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    items: [{ id: {{ $booking->id }} }]
                }),
            }).then((r) => r.json());

            elements = stripe.elements({
                clientSecret
            });

            const paymentElementOptions = {
                layout: "accordion",
            };

            const paymentElement = elements.create("payment", paymentElementOptions);
            paymentElement.mount("#payment-element");

            // Add form submit handler
            document
                .querySelector("#payment-form")
                .addEventListener("submit", handleSubmit);
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route("web.booking.success", ["booking" => $booking->id]) }}',
                },
            });

            // This point will only be reached if there is an immediate error when
            // confirming the payment. Otherwise, your customer will be redirected to
            // your `return_url`.
            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occurred.");
            }

            setLoading(false);
        }

        // Fetches the payment intent status after payment submission
        async function checkStatus() {
            const clientSecret = new URLSearchParams(window.location.search).get(
                "payment_intent_client_secret"
            );

            if (!clientSecret) {
                return;
            }

            const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

            switch (paymentIntent.status) {
                case "succeeded":
                    showMessage("Payment succeeded!");
                    break;
                case "processing":
                    showMessage("Your payment is processing.");
                    break;
                case "requires_payment_method":
                    showMessage("Your payment was not successful, please try again.");
                    break;
                default:
                    showMessage("Something went wrong.");
                    break;
            }
        }

        // ------- UI helpers -------

        function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-message");

            if (messageContainer) {
                messageContainer.classList.remove("hidden");
                messageContainer.textContent = messageText;

                setTimeout(function() {
                    messageContainer.classList.add("hidden");
                    messageContainer.textContent = "";
                }, 4000);
            }
        }

        // Show a spinner on payment submission
        function setLoading(isLoading) {
            const submitButton = document.querySelector("#submit");
            const spinner = document.querySelector("#spinner");
            const buttonText = document.querySelector("#button-text");

            if (submitButton && spinner && buttonText) {
                if (isLoading) {
                    // Disable the button and show a spinner
                    submitButton.disabled = true;
                    spinner.classList.remove("hidden");
                    buttonText.classList.add("hidden");
                } else {
                    submitButton.disabled = false;
                    spinner.classList.add("hidden");
                    buttonText.classList.remove("hidden");
                }
            }
        }

        // Add CSS for spinner
        const style = document.createElement('style');
        style.textContent = `
            #payment-form {
                width: 100%;
                max-width: 400px;
                align-self: center;
            }

            .hidden {
                display: none;
            }

            #payment-message {
                color: rgb(220, 38, 38);
                font-size: 14px;
                line-height: 20px;
                padding-top: 8px;
                text-align: center;
            }

            #payment-element {
                margin-bottom: 16px;
            }

            /* spinner/processing state, errors */
            .spinner,
            .spinner:before,
            .spinner:after {
                border-radius: 50%;
            }

            .spinner {
                color: #ffffff;
                font-size: 22px;
                text-indent: -99999px;
                margin: 0px auto;
                position: relative;
                width: 20px;
                height: 20px;
                box-shadow: inset 0 0 0 2px;
                -webkit-transform: translateZ(0);
                -ms-transform: translateZ(0);
                transform: translateZ(0);
            }

            .spinner:before,
            .spinner:after {
                position: absolute;
                content: "";
            }

            .spinner:before {
                width: 10.4px;
                height: 20.4px;
                background: #ffffff;
                border-radius: 20.4px 0 0 20.4px;
                top: -0.2px;
                left: -0.2px;
                -webkit-transform-origin: 10.4px 10.2px;
                transform-origin: 10.4px 10.2px;
                -webkit-animation: loading 2s infinite ease 1.5s;
                animation: loading 2s infinite ease 1.5s;
            }

            .spinner:after {
                width: 10.4px;
                height: 10.2px;
                background: #ffffff;
                border-radius: 0 10.2px 10.2px 0;
                top: -0.1px;
                left: 10.2px;
                -webkit-transform-origin: 0px 10.2px;
                transform-origin: 0px 10.2px;
                -webkit-animation: loading 2s infinite ease;
                animation: loading 2s infinite ease;
            }

            @-webkit-keyframes loading {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }

            @keyframes loading {
                0% {
                    -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                    transform: rotate(360deg);
                }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
