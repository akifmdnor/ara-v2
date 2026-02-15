<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Payment Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #000; line-height: 1.5;">
    <div style="border: 1px solid #ccc; padding: 20px; max-width: 600px; margin: auto;">

        <div style="margin-bottom: 12px;">
            Hello {{ $customerName }},<br>
            Thank you for completing the payment for your booking <strong>{{ $bookingId }}</strong>. We are pleased
            to confirm that your booking is now fully paid and secured.
        </div>

        <h4 style="text-decoration: underline; margin-bottom: 6px;">Your booking details</h4>
        <div style="margin-bottom: 6px;"><strong>Booking ID:</strong> {{ $bookingId }}</div>
        <br><strong>Payment Status:</strong> Fully Paid
    </div>

    <h4 style="text-decoration: underline; margin-bottom: 6px;">Car Information</h4>
    <div style="margin-bottom: 12px;"><strong>Car Model:</strong> {{ $carModel }}</div>

    <h4 style="text-decoration: underline; margin-bottom: 6px;">Pickup Information</h4>
    <div style="margin-bottom: 6px;"><strong>Pickup Date & Time:</strong> {{ $pickupDateTime }}</div>
    <div style="margin-bottom: 12px;"><strong>Pickup Location:</strong> {{ $pickupLocation }}</div>

    <h4 style="text-decoration: underline; margin-bottom: 6px;">Drop Off Information</h4>
    <div style="margin-bottom: 6px;"><strong>Drop Off Date & Time:</strong> {{ $dropOffDateTime }}</div>
    <div style="margin-bottom: 12px;"><strong>Drop Off Location:</strong> {{ $dropOffLocation }}</div>

    <div style="margin-bottom: 12px;">
        Our team is now finalizing the necessary preparations to ensure a smooth experience for you.
    </div>

    <div style="margin-bottom: 12px;">
        <strong>Please note:</strong> We do not automatically send a full payment receipt with this email. If you
        require your complete payment receipt, kindly contact us at <a
            href="mailto:admin@aracarrental.com.my">admin@aracarrental.com.my</a>.
    </div>

    <div style="margin-bottom: 12px;">
        If you have any further questions or need additional assistance, please feel free to reach out.
    </div>

    <div style="margin-bottom: 12px;">Thank you for choosing ARACAR Rental. We look forward to serving you soon!
    </div>

    <div style="margin-bottom: 12px;"><strong>Best regards,<br>ARACAR Reservation Team</strong></div>

    <br>
    <div style="font-size: 12px; color: #888;">
        For any questions, please connect with our Customer Service Team at <strong>+603 8322 6469</strong> |
        E-mail: <a href="mailto:enquiry@aracarrental.com.my">enquiry@aracarrental.com.my</a> |
    </div>

    <img src="{{ URL::asset('images/ara-email-logo.png') }}" alt="ARACAR Logo"
        style="width: 150px; height: auto; margin-top: 20px;">

    <div style="font-size: 12px; color: #888; margin-top: 12px;">© All Rights Reserved</div>
    <hr>
    <div style="font-size: 12px; color: #888;">
        This is a notification email—Please do not reply. <br>
        For any questions, please connect with our Customer Service Team at <strong>+603 8322 6469</strong> |
        E-mail: <a href="mailto:enquiry@aracarrental.com.my">enquiry@aracarrental.com.my</a>
    </div>
    </div>
</body>

</html>