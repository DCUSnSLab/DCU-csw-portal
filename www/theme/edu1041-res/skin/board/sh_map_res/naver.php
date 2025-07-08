<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=API키입력&callback=initMap"></script>
<body>
    <?php
    $sh_x=$_GET["sh_x"]; 
    $sh_y=$_GET["sh_y"]; 
    $sh_name=$_GET["sh_name"]; 
    $sh_set=$_GET["sh_set"];
    $sh_zoom=$_GET['sh_zoom'];

    if(!$sh_x){$sh_x='37.5015274';}
    if(!$sh_y){$sh_y='126.7690272';}
    if(!$sh_set){
    $sh_name = iconv('euc-kr','utf-8',$_GET['sh_name']); 
    }
    $sh_height=$_GET["sh_height"]; 
    $sh_width=$_GET["sh_width"];
    if(!$sh_height or !$sh_width){
        $sh_height = '480';
        $sh_width = '700';
    }

    if(!$sh_zoom){$sh_zoom='16';}
    ?>

    <div id="map" style="width:100%;height:<?php echo $sh_height?>px;"></div>
    <script>


    var map = new naver.maps.Map('map', {
        center: new naver.maps.LatLng(<?=$sh_x?>,<?=$sh_y?>), //지도의 초기 중심 좌표
        useStyleMap: true,
        zoom: <?php echo $sh_zoom?>, //지도의 초기 줌 레벨
        minZoom: 1, //지도의 최소 줌 레벨
        mapTypeControl: true, //지도 유형 컨트롤의 표시 여부
        mapTypeControlOptions: { //지도 유형 컨트롤의 옵션
            style: naver.maps.MapTypeControlStyle.BUTTON,
            position: naver.maps.Position.TOP_LEFT
        },
        zoomControl: true, //줌 컨트롤의 표시 여부
        zoomControlOptions: { //줌 컨트롤의 옵션
            position: naver.maps.Position.TOP_RIGHT
                    
        }
    });
    //정보창

    var contentString = [
        '<div class="iw_inner"  style="padding:10px 20px">',
        "   <h5 style='margin:0'><?=$sh_name?></h5>",
        '</div>'
    ].join('');

    var marker = new naver.maps.Marker({
        position: new naver.maps.LatLng(<?=$sh_x?>,<?=$sh_y?>),
        map: map
    });

    var infowindow = new naver.maps.InfoWindow({
        content: contentString,
        anchorSize: new naver.maps.Size(15, 5),
        pixelOffset: new naver.maps.Point(0, -10)
    });

    naver.maps.Event.addListener(marker, "click", function(e) {
        if (infowindow.getMap()) {
            infowindow.close();
        } else {
            infowindow.open(map, marker);
        }
    });

    infowindow.open(map, marker);

    //setOptions 메서드를 통해 옵션을 조정할 수도 있습니다.
    map.setOptions("mapTypeControl", true); //지도 유형 컨트롤의 표시 여부

    </script>
</body>
</html>