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
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            document.getElementById('pickup_location').value = place.name;
            document.getElementById('pickup_latitude').value = place.geometry.location.lat();
            document.getElementById('pickup_longitude').value = place.geometry.location.lng();
        });
    }

    function distance2() {

        var options = {
            componentRestrictions: {
                country: "my"
            }
        };

        var input = document.getElementById('return_location');
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            document.getElementById('return_location').value = place.name;
            document.getElementById('return_latitude').value = place.geometry.location.lat();
            document.getElementById('return_longitude').value = place.geometry.location.lng();
        });
    }

    function distance3() {

        var options = {
            componentRestrictions: {
                country: "my"
            }
        };

        var input = document.getElementById('return_location_2');
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            document.getElementById('return_location_2').value = place.name;
            document.getElementById('return_latitude').value = place.geometry.location.lat();
            document.getElementById('return_longitude').value = place.geometry.location.lng();
        });
    }
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('google.maps.api_key') }}&libraries={{ config('google.maps.library') }}&callback={{ config('google.maps.callback') }} "
    async defer></script>
<script>
    $(document).ready(function() {
        let map;

        async function initMap() {
            // The location of center
            const position = {
                lat: 3.940853,
                lng: 101.693207
            };
            // Request needed libraries.
            //@ts-ignore
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            // The map, centered
            map = new Map(document.getElementById("map"), {
                zoom: 6.8,
                center: position,
                mapId: google.maps.MapTypeId.ROADMAP,
            });

            var locations = [
                @foreach ($branches as $branch)
                    ['{{ $branch->branch_name }}',
                        '{{ $branch->address_latitude }}',
                        '{{ $branch->address_longitude }}'
                    ],
                @endforeach
            ];

            var i;
            for (i = 0; i < locations.length; i++) {
                // A marker with a with a URL pointing to a PNG.
                const pinImg = document.createElement("img");
                pinImg.src =
                    "https://firebasestorage.googleapis.com/v0/b/ara-website-282103.appspot.com/o/map-pin.png?alt=media&token=bb68345f-f219-4946-8c7c-e66f6712689d";

                const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
                    map: map,
                    content: pinImg,
                    position: {
                        lat: Number(locations[i][1]),
                        lng: Number(locations[i][2])
                    },
                    title: 'ARA',
                });
            }
        }

        initMap();
    })
</script>
