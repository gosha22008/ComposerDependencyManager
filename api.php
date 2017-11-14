<?php
require_once 'index.php';
echo '<pre>';
var_dump($array);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Быстрый старт. Размещение интерактивной карты на странице</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript">
    </script>
    <script type="text/javascript">
    ymaps.ready(init);
        var myMap,
            myPlacemark;

        function init(){
            myMap = new ymaps.Map("map", {
                center: [55.76, 37.64],
                zoom: 7
            });

            myPlacemark = new ymaps.Placemark([<?=$array['latitude']?>, <?=$array['longitude']?>], {
                //hintContent: 'Москва!',
                //balloonContent: 'Столица России'
            });

            myMap.geoObjects.add(myPlacemark);
        }
    </script>
</head>

<body>
    <div id="map" style="width: 600px; height: 400px"></div>
</body>

</html>