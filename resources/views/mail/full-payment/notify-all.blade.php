<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Payment Received Notification</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #000; line-height: 1.5;">
    <div style="border: 1px solid #ccc; padding: 20px; max-width: 600px; margin: auto;">
        <div style="margin-bottom: 12px;">
            Hello Team,<br>
            Good news! The customer has completed the remaining payment for the booking listed below. Please proceed
            with final preparations and ensure a smooth handover.
        </div>

        <h4 style="text-decoration: underline; margin-bottom: 6px;">Booking details</h4>
        <div style="margin-bottom: 6px;"><strong>Booking ID:</strong> {{ $bookingId }}</div>
        <div style="margin-bottom: 12px;"><strong>Payment Status:</strong> ✅ Fully Paid</div>

        <h4 style="text-decoration: underline; margin-bottom: 6px;">Car Information</h4>
        <div style="margin-bottom: 12px;"><strong>Car Model:</strong> {{ $carModel }}</div>

        <h4 style="text-decoration: underline; margin-bottom: 6px;">Pickup Information</h4>
        <div style="margin-bottom: 6px;"><strong>Pickup Date & Time:</strong> {{ $pickupDateTime }}</div>
        <div style="margin-bottom: 12px;"><strong>Pickup Location:</strong> {{ $pickupLocation }}</div>

        <h4 style="text-decoration: underline; margin-bottom: 6px;">Drop Off Information</h4>
        <div style="margin-bottom: 6px;"><strong>Drop Off Date & Time:</strong> {{ $dropOffDateTime }}</div>
        <div style="margin-bottom: 12px;"><strong>Drop Off Location:</strong> {{ $dropOffLocation }}</div>

        <h4 style="text-decoration: underline; margin-bottom: 6px;">Customer Information</h4>
        <div style="margin-bottom: 12px;"><strong>Name:</strong> {{ $customerName }}</div>

        <div style="margin-bottom: 20px;">
            Thank you for your continued support in providing an excellent rental experience.
        </div>

        <div style="margin-bottom: 12px;"><strong>Best regards,<br>ARACAR Reservation Team</strong></div>

        <hr>
        <div style="font-size: 12px; color: #888;">
            This is a notification email—Please do not reply. <br>
            For any questions, please connect with our Customer Service Team at <strong>+603 8322 6469</strong> |
            E-mail: <a href="mailto:enquiry@aracarrental.com.my">enquiry@aracarrental.com.my</a> |
            ARACAR © All Rights Reserved
        </div>
    </div>
</body>

</html>