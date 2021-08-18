<?php
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);
include  '../vendor/autoload.php';

session_start();
if (!isset($_SESSION['access_token'])) {
    header('Location: index.php');
}
$dateFrom = (isset($_POST['date_from']))? $_POST['date_from'] : '2017-01-01';
$dateTill = (isset($_POST['date_till']))? $_POST['date_till'] : '2017-01-09';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <script src="js/main.js"></script>
    <script >
        let map, elementMap,decode,encoded_data,date_from,
            date_till,latLngA,latLngB,bounds,marker,
            latLngStop,title, icon, startLat,startLgn,
            startAddress, startTime;

        function initMap() {
            elementMap = document.getElementById("map");
            map = new google.maps.Map(elementMap, {
                center: { lat: 41.7206, lng: 26.3468 },
                zoom: 14,
            });
            latLngA = undefined;
            date_from = document.getElementById('date_from').value;
            date_till = document.getElementById('date_till').value;
            $.getJSON('/routes.php?date_from='+date_from+'&date_till='+date_till, function(data) {
               data.data.units[0].routes.forEach(function (element) {
                   encoded_data = element.polyline;
                   startLat = element.start.lat;
                   startLgn = element.start.lng;
                   startAddress = element.start.address;
                   startTime = element.start.time;
                   if (encoded_data !== undefined) {
                        if (latLngA === undefined) {
                            latLngA = latLngB = new google.maps.LatLng(startLat, startLgn);
                            icon = "http://maps.google.com/mapfiles/ms/icons/green-dot.png";
                            addMarker(startLat, startLgn, 'START FROM \n' +startAddress, startTime, icon);
                        } else {
                            latLngB = new google.maps.LatLng(startLat, startLgn);
                        }

                       decode = google.maps.geometry.encoding.decodePath(encoded_data);
                       let line = new google.maps.Polyline({
                           path: decode,
                           strokeColor: '#00008B',
                           strokeOpacity: 1.0,
                           strokeWeight: 4,
                           zIndex: 3
                       });

                       line.setMap(map);
                   }
                   if (element.type === "stop") {
                       icon = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png";
                       addMarker(startLat, startLgn, startAddress, startTime, icon);
                   }
               });
                icon = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
                addMarker(startLat, startLgn, 'END IN \n' +startAddress, startTime, icon);
                bounds = new google.maps.LatLngBounds();
                bounds.extend(latLngA);
                bounds.extend(latLngB);
                map.fitBounds(bounds);
            });


        }
    </script>
</head>
<body>
<div id="container">
    <div id="sidebar">
        <form action="" method="post" >
        <div class="divField">Date From:
            <input type="text" class="datepicker" name="date_from" id="date_from" value="<?=$dateFrom?>" />
        </div>
            <div class="divField">Till:

                <input type="text" class="datepicker" name="date_till" id="date_till" value="<?=$dateTill?>" />

            </div>
            <div class="divButton">
                <br /><br /><br />
            <input type="submit" value="Submit" />
            </div>
        </form>
    </div>
</div>

<div id="map"></div>
<div id="footer"></div>
<script
        src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap&libraries=geometry&v=weekly"
        async
></script>
</body>
</html>


