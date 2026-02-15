<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Webhook;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PaymentService
{
    /**
     * Process Stripe payment for booking deposit
     *
     * @param Booking $booking
     * @return array
     * @throws \Exception
     */
    public function processStripePayment(Booking $booking): array
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Determine if this is a second payment (deposit already paid)
        $isSecondPayment = $booking->payment_status === 'Partial';
        $amount = $isSecondPayment
            ? ($booking->amount - $booking->amount_paid) * 100  // Remaining amount for second payment
            : $booking->amount_secd * 100;  // Deposit amount for first payment

        $description = $isSecondPayment
            ? 'Full Payment of BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT)
            : 'Deposit of BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT);

        $paymentIntent = PaymentIntent::create([
            'amount' => $amount, // Convert to cents
            'currency' => 'myr',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
            'description' => $description,
            'metadata' => [
                'order_id' => 'BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT),
                'payment_type' => $isSecondPayment ? 'full' : 'deposit',
            ],
        ]);

        // Store payment intent ID for webhook processing
        $booking->update([
            'payment_intent_id' => $paymentIntent->id,
        ]);

        return [
            'client_secret' => $paymentIntent->client_secret,
            'payment_intent_id' => $paymentIntent->id,
        ];
    }

    /**
     * Process Billplz payment for booking deposit
     *
     * @param Booking $booking
     * @return string
     * @throws \Exception
     */
    public function processBillplzPayment(Booking $booking): string
    {
        $client = new Client();

        // Determine if this is a second payment (deposit already paid)
        $isSecondPayment = $booking->payment_status === 'Partial';
        $amount = $isSecondPayment
            ? ($booking->amount - $booking->amount_paid) * 100  // Remaining amount for second payment
            : $booking->amount_secd * 100;  // Deposit amount for first payment

        $description = $isSecondPayment
            ? "BK" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . " " .
            $booking->car_model->model_specification->model_name .
            " (Group " . $booking->car_model->model_specification->group . ") - Full Payment"
            : "BK" . str_pad($booking->id, 4, '0', STR_PAD_LEFT) . " " .
            $booking->car_model->model_specification->model_name .
            " (Group " . $booking->car_model->model_specification->group . ")";

        $callbackUrl = $isSecondPayment
            ? config('app.url') . '/callback/billplz/second-payment/' . $booking->id
            : config('app.url') . '/callback/billplz/first-payment/' . $booking->id;

        $billData = [
            'collection_id' => config('services.billplz.collection_id'),
            'description' => $description,
            'email' => $booking->user->email,
            'name' => $booking->user->name,
            'amount' => (app()->environment('local') ? 100 : $amount),
            'callback_url' => $callbackUrl,
            'redirect_url' => route('web.billplz.success', $booking->id),
        ];

        $response = $client->post('https://www.billplz.com/api/v3/bills', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(config('services.billplz.api_key') . ":")
            ],
            'json' => $billData
        ]);

        $billplzResult = json_decode($response->getBody()->getContents());

        // Store bill ID for tracking
        $booking->update([
            'billplz_bill_id' => $billplzResult->id,
        ]);

        return $billplzResult->url;
    }

    /**
     * Handle Stripe webhook
     *
     * @param string $payload
     * @param string $signature
     * @return array
     * @throws \Exception
     */
    public function handleStripeWebhook(string $payload, string $signature): array
    {
        $endpoint_secret = config('services.stripe.webhook_secret');

        // Verify webhook signature
        $event = Webhook::constructEvent($payload, $signature, $endpoint_secret);

        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;

            // Find booking by payment intent ID
            $booking = Booking::where('payment_intent_id', $paymentIntent->id)->first();

            if ($booking) {
                $payment_status_before = $booking->payment_status;

                // Determine payment type from metadata
                $paymentType = $paymentIntent->metadata['payment_type'] ?? 'deposit';

                // Update payment status and amount
                $booking->amount_paid = $booking->amount_paid + ($paymentIntent->amount / 100);
                $booking->payment_status = $paymentType === 'full' ? 'Paid' : 'Partial';
                $booking->save();

                return [
                    'booking' => $booking,
                    'payment_status_before' => $payment_status_before,
                    'amount_paid' => $booking->amount_paid,
                ];
            }
        }

        return [];
    }

    /**
     * Handle Billplz callback
     *
     * @param array $callbackData
     * @param string $paymentType
     * @param int $bookingId
     * @return array
     */
    public function handleBillplzCallback(array $callbackData, string $paymentType, int $bookingId): array
    {
        $paymentStatus = [
            'first-payment' => 'Partial',
            'second-payment' => 'Paid'
        ];

        if ($callbackData['paid'] == "true") {
            $booking = Booking::find($bookingId);
            $payment_status_before = $booking->payment_status;

            // Update amount paid and payment status
            $booking->amount_paid = $booking->amount_paid + (intval($callbackData['amount']) / 100);
            $booking->payment_status = $paymentStatus[$paymentType];
            $booking->save();

            return [
                'booking' => $booking,
                'payment_status_before' => $payment_status_before,
                'amount_paid' => $booking->amount_paid,
                'payment_type' => $paymentType,
            ];
        }

        return [];
    }
}
