<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyD4T-R81snuXT8cWl7bhFWb7Vba9b06IsI"></script>
<script type="text/javascript">
$(document).ready(function(){
    console.log('Doc on load');
    var address = 'San Diego, CA';
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({'address': address}, function(results, status) {
        if(status == google.maps.GeocoderStatus.OK) {
            if(status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                initialize(latitude, longitude);
            } else {
              alert("No results found");
            }
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });

    function initialize(latitude, longitude) {
        var latlng = new google.maps.LatLng(latitude, longitude);
        var myOptions = {
            zoom: 15,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true
        };

        var map = new google.maps.Map(document.getElementById('map'), myOptions);

        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title: 'Location, property name'
        });
    }
});
</script>
<div id="map"></div>