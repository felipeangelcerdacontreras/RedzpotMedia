<?php

$lat = empty($_GET['lat']) ? "25.585353" : $_GET['lat'];
$lng = empty($_GET['lng']) ? "-103.509512" : $_GET['lng'];

if ($lat == 0) $lat = "25.585353";
if ($lng == 0) $lng = "-103.509512"

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mapa ubicación geográfica</title>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJzmZ-nYkz0CK42vIYakjcxodXl_1z7gg&sensor=false"></script>
    <link type="text/css" rel="stylesheet" rev="stylesheet" href="../../../css/estilo.css" />
    <link type="text/css" rel="stylesheet" rev="stylesheet" href="../../../javascript/jquery/jquery-ui.css" />
    <link type="text/css" rel="stylesheet" rev="stylesheet" href="../../../css/jquery.dataTables.css" />
    <script language="javascript" src="../../../javascript/jquery/external/jquery/jquery.js"></script>
    <script language="javascript" src="../../../javascript/jquery/jquery-ui.js"></script>
    <script language="javascript" src="../../../javascript/jquery.form.js"></script>
    <script language="javascript" type="text/javascript" src="../../../javascript/misfunciones.js"></script>
    <script language="javascript" src="../../../javascript/jquery.dataTables.min.js"></script>
    <script language="javascript">
        $(document).ready(function(e) {
            $("#btnCerrar").button();
            $("#btnCerrar").click(function(e) {
                window.close();
            });

            //---- GOOGLE MAPS
            var mexico = new google.maps.LatLng(<?=$lat?>, <?=$lng?>);
            var marca = new google.maps.LatLng(<?=$lat?>, <?=$lng?>);
            var zoomMapa = 20;
            var marker;
            var map;

            function initialize() {
                var mapOptions = {
                    center: mexico,
                    zoom: zoomMapa,
                    mapTypeId: google.maps.MapTypeId.HYBRID
                };
                var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

                marker = new google.maps.Marker({
                    map:map,
                    draggable:true,
                    animation: google.maps.Animation.DROP,
                    position: marca
                });

                google.maps.event.addListener(marker, 'mouseup', onMouseMove);
                //google.maps.event.addListener(marker, 'click', toggleBounce);
            }

            function onMouseMove() {
                var aPosition = marker.getPosition();
                var lat = aPosition.lat();
                var lng = aPosition.lng();


                window.opener.document.getElementById("cli_lat").value = lat.toFixed(6);
                window.opener.document.getElementById("cli_lng").value = lng.toFixed(6);
            }

            function toggleBounce() {
                if (marker.getAnimation() != null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }

            google.maps.event.addDomListener(window, 'load', initialize);
        });
    </script>
</head>

<body onblur="window.focus();">
<div id="map-canvas"></div>
<div style="text-align:right"><br />
    <input type="button" id="btnCerrar" name="btnCerrar" value="Cerrar"  />
    <br />
</div>
</body>
</html>