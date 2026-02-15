<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Car Rental Booking Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #000; line-height: 1.6;">

    <div style="border: 1px solid #ccc; padding: 20px; max-width: 600px; margin: auto;">
        <p>Hello {{ $customerName }},</p>

        <p>Thank you for choosing ARACAR Rental! We're delighted to confirm that we've received your booking and have
            started processing it.</p>

        <h4 style="text-decoration:underline; margin-bottom:-10px">Your booking details</h4>
        <ul>
            <li><strong>Booking ID:</strong> {{ $bookingId }}</li>
            <li><strong>Deposit Paid:</strong> RM {{ $deposit }}</li>
            <li><strong>Duration:</strong> {{ $duration }}</li>
        </ul>

        <h4 style="text-decoration:underline; margin-bottom:-10px">Car Information</h4>
        <ul>
            <li><strong>Car Model:</strong> {{ $carModel }}</li>
        </ul>

        <h4 style="text-decoration:underline; margin-bottom:-10px">Pickup Information</h4>
        <ul>
            <li><strong>Pickup Date & Time:</strong> {{ $pickupDateTime }}</li>
            <li><strong>Pickup Location:</strong> {{ $pickupLocation }}</li>
        </ul>

        <h4 style="text-decoration:underline; margin-bottom:-10px">Drop Off Information</h4>
        <ul>
            <li><strong>Drop Off Date & Time:</strong> {{ $dropOffDateTime }}</li>
            <li><strong>Drop Off Location:</strong> {{ $dropOffLocation }}</li>
        </ul>

        <h4 style="text-decoration:underline; margin-bottom:-10px">Next Steps</h4>
        <p>We'll assign the car unit and delivery staff for your booking shortly. After that, you'll receive an invoice
            for the remaining balance along with a secure payment link via email.</p>

        <p>If you have any questions or need to make changes, please reach out to us at <a
                href="mailto:enquiry@aracarrental.com.my">enquiry@aracarrental.com.my</a>. We look forward to serving
            you soon!</p>

        <img src="{{ URL::asset('images/ara-email-logo.png') }}" alt="ARACAR Logo"
            style="width: 150px; height: auto; margin-top: 20px;">

        <p style="font-size: 12px; color: #888;">© All Rights Reserved</p>
        <hr>
        <p style="font-size: 12px; color: #888;">
            This is a notification email—Please do not reply. <br>
            For any questions, please connect with our Customer Service Team at <strong>+603 8322 6469</strong> |
            E-mail: <a href="mailto:enquiry@aracarrental.com.my">enquiry@aracarrental.com.my</a>
        </p>
    </div>
</body>

</html>