function addMarker(lat, lng, address, time, icon)
{
    latLngStop = new google.maps.LatLng(lat, lng);
    title = address + "\n\n " + time;
    marker = new google.maps.Marker({
        position: latLngStop,
        title: title,
        icon: icon
    });
    marker.setMap(map);
}
$( function() {
    $( ".datepicker" ).datepicker({
        dateFormat : "yy-mm-dd"
    });
} );