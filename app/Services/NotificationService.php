<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation\CustomerMail;
use App\Mail\BookingConfirmation\AdminMail;
use App\Mail\FullPayment\CustomerFullPaymentMail;
use App\Mail\FullPayment\NotifyAllMail;

class NotificationService
{
    /**
     * Send booking deposit confirmation emails
     *
     * @param Booking $booking
     * @param float $amountPaid
     * @return void
     */
    public function sendDepositConfirmationEmails(Booking $booking, float $amountPaid): void
    {
        $user = $booking->user;

        // Send customer confirmation email
        Mail::to($user->email)->send(new CustomerMail([
            'email' => $user->email,
            'customerName' => $user->name,
            'bookingId' => 'BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT),
            'deposit' => number_format($amountPaid, 2),
            'duration' => $booking->duration_days . ' Days ' . $booking->duration_hours . ' Hours',
            'carModel' => $booking->car_model->model_specification->model_name,
            'pickupDateTime' => date('d/m/Y h:i:s A', strtotime($booking->pickup_datetime)),
            'pickupLocation' => $booking->pickup_location,
            'dropOffDateTime' => date('d/m/Y h:i:s A', strtotime($booking->dropoff_datetime)),
            'dropOffLocation' => $booking->dropoff_location
        ]));

        // Send admin notification email
        Mail::to('booking@aracarrental.com.my')
            ->bcc('admin@araacarrental.com.my')
            ->send(new AdminMail([
                'bookingId' => 'BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT),
                'deposit' => number_format($amountPaid, 2),
                'paymentMethod' => ucfirst($booking->payment_method),
                'duration' => $booking->duration_days_real . ' Days ' . $booking->duration_hours_real . ' Hours',
                'carModel' => $booking->car_model->model_specification->model_name,
                'carLocation' => $booking->car_model->branch->city,
                'pickupDateTime' => date('d/m/Y h:i:s A', strtotime($booking->pickup_datetime)),
                'pickupLocation' => $booking->pickup_location,
                'dropOffDateTime' => date('d/m/Y h:i:s A', strtotime($booking->dropoff_datetime)),
                'dropOffLocation' => $booking->dropoff_location,
                'customerName' => $user->name,
                'nric' => $user->nric ?? '',
                'phone' => $user->phone_number ?? '',
                'email' => $user->email,
                'address' => $user->address ?? ''
            ]));
    }

    /**
     * Send full payment confirmation emails
     *
     * @param Booking $booking
     * @return void
     */
    public function sendFullPaymentConfirmationEmails(Booking $booking): void
    {
        $user = $booking->user;

        // Send customer full payment confirmation
        Mail::to($user->email)->send(new CustomerFullPaymentMail([
            'email' => $user->email,
            'customerName' => $user->name,
            'bookingId' => 'BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT),
            'carModel' => $booking->car_model->model_specification->model_name,
            'pickupDateTime' => date('d/m/Y h:i:s A', strtotime($booking->pickup_datetime)),
            'pickupLocation' => $booking->pickup_location,
            'dropOffDateTime' => date('d/m/Y h:i:s A', strtotime($booking->dropoff_datetime)),
            'dropOffLocation' => $booking->dropoff_location
        ]));

        // Send notification to all team members
        Mail::to([
            'booking@aracarrental.com.my',
            $booking->branch->email ?? null,
            $booking->staff->email ?? null
        ])->send(new NotifyAllMail([
            'bookingId' => 'BK' . str_pad($booking->id, 4, '0', STR_PAD_LEFT),
            'carModel' => $booking->car_model->model_specification->model_name,
            'pickupDateTime' => date('d/m/Y h:i:s A', strtotime($booking->pickup_datetime)),
            'pickupLocation' => $booking->pickup_location,
            'dropOffDateTime' => date('d/m/Y h:i:s A', strtotime($booking->dropoff_datetime)),
            'dropOffLocation' => $booking->dropoff_location,
            'customerName' => $user->name
        ]));
    }
}