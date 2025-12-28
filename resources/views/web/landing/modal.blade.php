<div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="about-text-all">
                <div class="container-fluid nav-container">
                    <p class="about-text-1">Ara Car Rental<br></p>
                    <p class="about-text-2">“Trusted Brand, You Can Rely On”<br></p>
                    <p class="about-text-3">Based in Klang Valley, and established since 2010. ARA Car Rental is part of
                        a bigger family in Malaysian Car Rental Organisation known as KOPKES (Koperasi Pengusaha Kereta
                        Sewa Malaysia Berhad). Thus, our vehicle can be access and booked
                        NATIONWIDE.<br><br>Focusing in providing door-to-door car rental delivery service, ARA Car
                        Rental has proven to deliver the BEST in both Vehicle Quality as well as Responsive Support Team
                        NATIONWIDE. The recognition by our customers
                        proven with more than 85% of our customers are regular / repeat customer.<br><br><br>Choose from
                        variety of our vehicle as well as other services :<br><br>· Hire and drive<br><br>· Long term
                        leasing<br><br>· City tour<br><br>· Tour
                        package<br><br>· Airport transfer<br><br>· VVIP transfer<br><br>· Wedding car<br><br></p>
                    <p class="about-text-2">Contact Us<br></p>
                    <p class="about-text-3"><span><img class="about-icon" src="images/web/homepage/Icon%20Location.svg">
                            E-1-01,
                            Blok E, Jalan Vita 1 Plaza Crystalville, Lingkaran Cyber Point Timur, 63000 Cyberjaya,
                            Selangor</span></p>
                    <p class="about-text-3"><span><img class="about-icon"
                                src="images/web/homepage/Icon%20Email.svg">&nbsp;
                            &nbsp;admin@aracarrental.com.my</span></p>
                    <p class="about-text-3"><span><img class="about-icon"
                                src="images/web/homepage/Icon%20Phone.svg">&nbsp;
                            &nbsp;+6 019-244 6969 (Office hours)<br>&nbsp; &nbsp; &nbsp; &nbsp; +6 03-8322 6469
                            (Hotline)</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="availabilityModal" tabindex="-1" role="dialog" aria-labelledby="availabilityModalLabel"
    style="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-frame-manual mobile-modal" style="min-width: 900px">

            <div class="modal-body"
                style="padding-left:40px; padding-right:40px; padding-top:24px; padding-bottom:24px; ">
                <div class="pb-3 d-flex justify-content-between align-items-center">
                    <span class="modal-title-manual" id="availabilityModalLabel">
                        Manual Confirmation Required for Limited Availability
                    </span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                    </button>
                </div>

                <p class="modal-body-manual">Due to limited availability, this request requires manual confirmation by
                    our team before booking can
                    be finalized. Please complete your information below so that we can attempt to secure an additional
                    unit (if available) and notify you via e-mail if one becomes available.</p>
                <form id="availabilityForm" {{-- action="{{ route('web.listing.send-email') }}" --}} method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" style="font-weight: 500;">NAME</label>
                        <input type="text" class="bg-white form-control" style="height:50px;" id="name"
                            name="customer_name">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email" style="font-weight: 500;">EMAIL</label>
                            <input type="email" class="bg-white form-control font-weight-normal" style="height:50px;"
                                id="email" name="customer_email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile" style="font-weight: 500;">MOBILE NUMBER</label>
                            <input type="text" class="bg-white form-control" style="height:50px;" id="mobile"
                                name="customer_phone">
                            <div class="pt-3 form-row">
                                <div class="form-group col-md-6">
                                    <span style="width:176px; padding-right:48px">
                                        <button type="button" class="btn" data-dismiss="modal"
                                            style="height:48px; color:#444444; padding-left:5px; padding-right:5px; background-color:#b3b3b3; width:176px; border:#C4C4C4;">Cancel</button>
                                    </span>
                                </div>
                                <div class="form-group col-md-6">
                                    <span style="width:176px"> <button type="submit" class="btn"
                                            style="height:48px; color:#FFFFFF; padding-left:5px; padding-right:5px; background-color:#999999; width:176px;"
                                            id="requestButton" disabled>Request Availability</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="successMessage" style="display: none; text-align: center; margin-top: 20px;">
                    <p style="color: green;">Request has been sent!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const mobileInput = document.getElementById('mobile');
        const requestButton = document.getElementById('requestButton');

        function validateForm() {
            const isNameFilled = nameInput.value.trim() !== "";
            const isEmailFilled = emailInput.value.trim() !== "";
            const isMobileFilled = mobileInput.value.trim() !== "";
            const isFormValid = isNameFilled && isEmailFilled && isMobileFilled;

            requestButton.disabled = !isFormValid;

            if (isFormValid) {
                requestButton.style.backgroundColor = '#ec2028';
                requestButton.style.color = 'white';
            } else {
                requestButton.style.backgroundColor = '#999999';
                requestButton.style.color = '';
            }
        }

        nameInput.addEventListener('input', validateForm);
        emailInput.addEventListener('input', validateForm);
        mobileInput.addEventListener('input', validateForm);
    });

    $(document).ready(function() {
        // When the modal is about to be shown
        $('#availabilityModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var modelName = button.data('model-car-name');
            var pickupDate = button.data('model-pickup-date-time');
            var returnDate = button.data('model-return-date-time');
            var pickupLocation = button.data('model-pickup-location');
            var returnLocation = button.data('model-return-location');

            var modal = $(this);
            modal.find('#availabilityForm').append('<input type="hidden" name="model_name" value="' +
                modelName + '">');
            modal.find('#availabilityForm').append('<input type="hidden" name="pickup_date" value="' +
                pickupDate + '">');
            modal.find('#availabilityForm').append('<input type="hidden" name="return_date" value="' +
                returnDate + '">');
            modal.find('#availabilityForm').append(
                '<input type="hidden" name="pickup_location" value="' +
                pickupLocation + '">');
            modal.find('#availabilityForm').append(
                '<input type="hidden" name="return_location" value="' +
                returnLocation + '">');


        });

        // Submit form via AJAX
        $('#availabilityForm').on('submit', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#availabilityForm')[0].reset();
                    $('#requestButton').prop('disabled', true).css('background-color',
                        '#999999').css('color', '');
                    $('#successMessage').show();
                },
                error: function(xhr, status, error) {
                    // Handle error
                }
            });
        });

        $('#requestButton').on('click', function() {
            $('#availabilityForm').submit();
        });
    });
</script>
