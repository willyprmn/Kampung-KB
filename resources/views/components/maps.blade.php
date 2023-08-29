@push('styles')
    <link href="{{ mix('css/common.css') }}" rel="stylesheet">
@endpush

<h2 class="mb-2">Persebaran Kampung KB</h2>
<hr class="blueline">

<div id="map" class="mb-3"></div>

@push('scripts')
    <script defer src="{{ asset('js/infobubble.js') }}"></script>
    <script>

        async function initMap() {

            var kampungs = [];

            var _supportsLocalStorage = !!window.localStorage
                && typeof localStorage.getItem === 'function'
                && typeof localStorage.setItem === 'function'
                && typeof localStorage.removeItem === 'function';

            if (_supportsLocalStorage
                && localStorage.getItem('mapkampung')
                && localStorage.getItem('mapkampung').length > 0
                && localStorage.getItem('mapkampung') !== 'undefined'
            ) {
                kampungs = JSON.parse(localStorage.getItem('mapkampung'));
            } else {
                var response = await fetch('/api/kampung');
                if (response.status === 200) {
                    kampungs = await response.json();
                    console.log(kampungs);
                    localStorage.setItem('mapkampung', JSON.stringify(kampungs));
                }
            }

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: {lat: -1.560135, lng: 117.4139863}
            });

            // Add some markers to the map.
            // Note: The code uses the JavaScript Array.prototype.map() method to
            // create an array of markers based on a given "locations" array.
            // The map() method here has nothing to do with the Google Maps API.
            // var markers = locations.map(function(location, name) {
            var markers = kampungs.map(kampung => {
                return new google.maps.Marker({
                    position: {lat: parseFloat(kampung.latitude), lng: parseFloat(kampung.longitude)},
                    label: String(kampung.nama),
                    url: String(kampung.url),
                });
            });

            // Add a marker clusterer to manage the markers.
            var mcOptions = {
                //imagePath: 'https://googlemaps.github.io/js-marker-clusterer/images/m',
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
                // gridSize: 50
                styles:[{
                    url: "https://googlemaps.github.io/js-marker-clusterer/images/m1.png",
                        width: 55,
                        height:55,
                        //fontFamily:"Open Sans",
                        textSize:11,
                        textColor:"black",
                        //color: #00FF00,
                    }]
            };

            var markerCluster = new MarkerClusterer(map, markers, mcOptions);
            markers.forEach(marker => {
                marker.addListener('click', () => {
                    window.location.href = marker.url;
                });
            });
        }
    </script>
    <script defer src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8S2NUCXzpL68-IXATK_4B5ZSMzQJ-HHs&callback=initMap"></script>
@endpush