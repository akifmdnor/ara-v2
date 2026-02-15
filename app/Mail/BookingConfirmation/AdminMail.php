<?php

namespace App\Mail\BookingConfirmation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingId;
    public $deposit;
    public $paymentMethod;
    public $duration;
    public $carModel;
    public $carLocation;
    public $pickupDateTime;
    public $pickupLocation;
    public $dropOffDateTime;
    public $dropOffLocation;
    public $customerName;
    public $nric;
    public $phone;
    public $email;
    public $address;

    public function __construct($data)
    {
        $this->bookingId = $data['bookingId'];
        $this->deposit = $data['deposit'];
        $this->paymentMethod = $data['paymentMethod'];
        $this->duration = $data['duration'];
        $this->carModel = $data['carModel'];
        $this->carLocation = $data['carLocation'];
        $this->pickupDateTime = $data['pickupDateTime'];
        $this->pickupLocation = $data['pickupLocation'];
        $this->dropOffDateTime = $data['dropOffDateTime'];
        $this->dropOffLocation = $data['dropOffLocation'];
        $this->customerName = $data['customerName'];
        $this->nric = $data['nric'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->address = $data['address'];
    }

    public function build(): AdminMail
    {
        return $this->from('reservation@aracarrental.com.my')
            ->subject('New Booking Received – ' . $this->bookingId)
            ->view('mail.booking-confirmation.admin');
    }
}