<?php

namespace App\Mail\FullPayment;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerFullPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $customerName;
    public $bookingId;
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
        $this->carModel = $data['carModel'];
        $this->pickupDateTime = $data['pickupDateTime'];
        $this->pickupLocation = $data['pickupLocation'];
        $this->dropOffDateTime = $data['dropOffDateTime'];
        $this->dropOffLocation = $data['dropOffLocation'];
    }

    public function build(): CustomerFullPaymentMail
    {
        return $this->from('reservation@aracarrental.com.my')
            ->subject("✅ Payment Received – {$this->bookingId} is Now Fully Paid")
            ->view('mail.full-payment.customer');
    }
}