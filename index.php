<?php
require __DIR__ . '/vendor/autoload.php';
$api = new \Yandex\Geo\Api();
session_start();
// Можно искать по точке
//$api->setPoint(30.5166187, 50.4452705);

// Или можно икать по адресу
if (isset($_POST['find']) and !empty($_POST['adress'])) {
    $api->setQuery($_POST['adress']);

    // Настройка фильтров
    $api
        ->setLimit(10)// кол-во результатов
        ->setLang(\Yandex\Geo\Api::LANG_US)// локаль ответа
        ->load();

    $response = $api->getResponse();
    $response->getFoundCount(); // кол-во найденных адресов
    $response->getQuery(); // исходный запрос
    $response->getLatitude(); // широта для исходного запроса
    $response->getLongitude(); // долгота для исходного запроса

// Список найденных точек
    $array = [];
    $collection = $response->getList();

    $_SESSION['collection'] = $collection;
}


function getAddress($collection)
{
    $i = 0;

    foreach ($collection as $item) { ?>
        <tr>
            <td> <?= ++$i ?> </td>
            <td>
                <a href="index.php?latit=<?= $item->getLatitude() ?>&&long=<?= $item->getLongitude() ?>"><?= $item->getAddress() ?></a>
            <td> <?= $item->getLatitude(); ?> </td>
            <td> <?= $item->getLongitude(); ?> </td>
        </tr>
    <?php }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            display: table;
            border-collapse: separate;
            border-spacing: 2px;
            border-color: grey;
        }

        table {
            margin: 1em 20px 0 0;
            border: 0;
            border-top: 1px solid #999;
            border-left: 1px solid #999;
        }

        td, th {
            border: 0;
            border-right: 1px solid #999;
            border-bottom: 1px solid #999;
            padding: .2em .3em;
        }

        thead th {
            text-align: center;
            padding: .2em .5em;
        }

        thead td, thead th {
            background: #ddf;

        }

    </style>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript">
    </script>
    <script type="text/javascript">
        ymaps.ready(init);
        var myMap,
            myPlacemark;

        <?php
        if (isset($_POST['find']) and !empty($_POST['adress']) and !empty($_GET['latit']) and !empty($_GET['long'])){
            $latit = 55.753215 ;
            $long = 37.622504;
        }else if (isset($_GET['latit']) and isset($_GET['long'])){
            $latit = $_GET['latit'];
            $long = $_GET['long'];
        }else {
            $latit = 55.753215 ;
            $long = 37.622504;
        }
        ?>

        function init() {
            myMap = new ymaps.Map("map", {
                center: [<?= $latit ?>, <?= $long ?>],
                zoom: 7
            });

            myPlacemark = new ymaps.Placemark([<?= $latit ?>, <?= $long ?>], {
//                hintContent: 'Москва!',
//                balloonContent: 'Столица России'
            });

            myMap.geoObjects.add(myPlacemark);

        }
    </script>

</head>
<body>

<form method="post">
    <input name="adress" value="" type="text" placeholder="Адрес">
    <input type="submit" value="Найти" name="find">
</form>


<?php

if ((isset($_POST['find']) and !empty($_POST['adress'])) or (!empty($_GET['latit']) and !empty($_GET['long']))) { ?>
    <table>
        <tbody>
        <tr style="background-color: #ddf">
            <th>№</th>
            <th>Адрес</th>
            <th>Широта</th>
            <th>Долгота</th>
        </tr>
        <?php getAddress($_SESSION['collection']) ?>
        </tbody>
    </table>
<?php }

?>

<div id="map" style="width: 600px; height: 400px"></div>

</body>
</html>
