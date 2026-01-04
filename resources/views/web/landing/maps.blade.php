<script>
    function initialize() {
        distance();
        // distance2();
        distance3();
        // initMap();
    }

    function distance() {

        var options = {
            componentRestrictions: {
                country: "my"
            }
        };

        var input = document.getElementById('pickup_location');
        if (input && input instanceof HTMLInputElement) {
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            document.getElementById('pickup_location').value = place.name;
                var latInput = document.getElementById('pickup_latitude');
                var lngInput = document.getElementById('pickup_longitude');
                if (latInput) latInput.value = place.geometry.location.lat();
                if (lngInput) lngInput.value = place.geometry.location.lng();
        });
        }
    }

    function distance2() {

        var options = {
            componentRestrictions: {
                country: "my"
            }
        };

        var input = document.getElementById('return_location');
        if (input && input instanceof HTMLInputElement) {
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            document.getElementById('return_location').value = place.name;
                var latInput = document.getElementById('return_latitude');
                var lngInput = document.getElementById('return_longitude');
                if (latInput) latInput.value = place.geometry.location.lat();
                if (lngInput) lngInput.value = place.geometry.location.lng();
        });
        }
    }

    function distance3() {

        var options = {
            componentRestrictions: {
                country: "my"
            }
        };

        var input = document.getElementById('return_location_2');
        if (input && input instanceof HTMLInputElement) {
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            document.getElementById('return_location_2').value = place.name;
                var latInput = document.getElementById('return_latitude');
                var lngInput = document.getElementById('return_longitude');
                if (latInput) latInput.value = place.geometry.location.lat();
                if (lngInput) lngInput.value = place.geometry.location.lng();
        });
        }
    }
</script>
<script>
    // Set up callback for Google Maps API
    window.googleMapsCallback = function() {
        try {
            if (typeof initialize === 'function') {
                initialize();
            }
            if (typeof initializeSearchAutocomplete === 'function') {
                initializeSearchAutocomplete();
            }
        } catch (error) {
            console.log('Google Maps callback error:', error);
            }
    };
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('google.maps.api_key') }}&libraries={{ config('google.maps.library') }}&callback=googleMapsCallback"
    async defer></script>
