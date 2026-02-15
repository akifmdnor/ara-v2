<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Booking Received</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #000; line-height: 1.6;">
    <div style="border: 1px solid #ccc; padding: 20px; max-width: 600px; margin: auto;">

        <p>Hello ARACAR Reservation Team,</p>
        <p>A new car rental booking has been received. Please review the details below and proceed with the necessary
            actions to ensure the booking is processed efficiently.</p>

        <h4 style="text-decoration: underline; margin-bottom: -10px;">Booking Details</h4>
        <ul>
            <li><strong>Booking ID:</strong> {{ $bookingId }}</li>
            <li><strong>Deposit Paid:</strong> RM {{ $deposit }}</li>
            <li><strong>Deposit Payment Method:</strong> {{ $paymentMethod }}</li>
            <li><strong>Duration:</strong> {{ $duration }}</li>
        </ul>

        <h4 style="text-decoration: underline; margin-bottom: -10px;">Car Information</h4>
        <ul>
            <li><strong>Car Model:</strong> {{ $carModel }}</li>
            <li><strong>Car Location (Branch):</strong> {{ $carLocation }}</li>
        </ul>

        <h4 style="text-decoration: underline; margin-bottom: -10px;">Pickup Information</h4>
        <ul>
            <li><strong>Pickup Date & Time:</strong> {{ $pickupDateTime }}</li>
            <li><strong>Pickup Location:</strong> {{ $pickupLocation }}</li>
        </ul>

        <h4 style="text-decoration: underline; margin-bottom: -10px;">Drop Off Information</h4>
        <ul>
            <li><strong>Drop Off Date & Time:</strong> {{ $dropOffDateTime }}</li>
            <li><strong>Drop Off Location:</strong> {{ $dropOffLocation }}</li>
        </ul>

        <h4 style="text-decoration: underline; margin-bottom: -10px;">Customer Information</h4>
        <ul>
            <li><strong>Name:</strong> {{ $customerName }}</li>
            <li><strong>NRIC:</strong> {{ $nric }}</li>
            <li><strong>Phone Number:</strong> {{ $phone }}</li>
            <li><strong>Email Address:</strong> {{ $email }}</li>
            <li><strong>Address:</strong> {{ $address }}</li>
        </ul>

        <h4 style="text-decoration: underline; margin-bottom: -10px;">Next Steps</h4>
        <ol>
            <li><strong>Verify Payment & Booking Data:</strong> Confirm that the deposit is received and all customer
                information is accurate.</li>
            <li><strong>Assign Resources:</strong> Coordinate with the relevant branch or team to assign the appropriate
                car unit and delivery staff.</li>
            <li><strong>Update Booking Status:</strong> Log into the admin dashboard to update the booking status and
                ensure all details are correctly entered.</li>
            <li><strong>Follow-Up:</strong> Prepare to send the balance invoice to the customer once the car and staff
                assignments are completed.</li>
        </ol>

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