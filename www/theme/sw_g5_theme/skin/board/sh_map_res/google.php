<?php 
if(!$_GET['sh_name']){$sh_name='SHINING';}else{$sh_name=$_GET['sh_name'];}
if(!$_GET['lat']){$lat='37.501509';}else{$lat=$_GET['lat'];}
if(!$_GET['lng']){$lng='126.769006';}else{$lng=$_GET['lng'];}
if(!$_GET['sh_zoom']){$sh_zoom='17';}else{$sh_zoom=$_GET['sh_zoom'];}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
<script>
function initMap() {
  var cairo = {lat: <?php echo $lat?>, lng: <?php echo $lng?>};

  var map = new google.maps.Map(document.getElementById('map'), {
    scaleControl: true,
    center: cairo,
    zoom: <?php echo $sh_zoom?>
  });

  var infowindow = new google.maps.InfoWindow;
  infowindow.setContent('<b><?php echo $sh_name?></b>');

  var marker = new google.maps.Marker({map: map, position: cairo});
  //marker.addListener('click', function() {
    infowindow.open(map, marker);
  //});
}

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=API키&callback=initMap&language=<?php echo $_GET['sh_language']?>" async defer></script>
  </body>
</html>