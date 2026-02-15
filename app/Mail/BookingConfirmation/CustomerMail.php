<?php

namespace App\Mail\BookingConfirmation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $customerName;
    public $bookingId;
    public $deposit;
    public $duration;
    public $carModel;
    public $pickupDateTime;
    public $pickupLocation;
    public $dropOffDateTime;
    public $dropOffLocation;

    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->customerName = $data['customerName'];
        $this->bookingId = $data['bookingId'];
        $this->deposit = $data['deposit'];
        $this->duration = $data['duration'];
        $this->carModel = $data['carModel'];
        $this->pickupDateTime = $data['pickupDateTime'];
        $this->pickupLocation = $data['pickupLocation'];
        $this->dropOffDateTime = $data['dropOffDateTime'];
        $this->dropOffLocation = $data['dropOffLocation'];
    }

    public function build(): CustomerMail
    {
        return $this->from('reservation@aracarrental.com.my')
            ->subject('Your Car Rental Booking Confirmation – ' . $this->bookingId)
            ->view('mail.booking-confirmation.customer');
    }
}