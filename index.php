<?php
require __DIR__.'/vendor/autoload.php';
$api = new \Yandex\Geo\Api();

// Можно искать по точке
//$api->setPoint(30.5166187, 50.4452705);

// Или можно икать по адресу
//var_dump($_POST);
if (isset($_POST['find']) and !empty($_POST['adress'])){
    $api->setQuery($_POST['adress']);
}


// Настройка фильтров
$api
    ->setLimit(1) // кол-во результатов
    ->setLang(\Yandex\Geo\Api::LANG_US) // локаль ответа
    ->load();

$response = $api->getResponse();
$response->getFoundCount(); // кол-во найденных адресов
$response->getQuery(); // исходный запрос
$response->getLatitude(); // широта для исходного запроса
$response->getLongitude(); // долгота для исходного запроса

// Список найденных точек
$array=[];
$collection = $response->getList();
foreach ($collection as $item) {
    $array['address'] = $item->getAddress(); // вернет адрес
    $array['latitude'] = $item->getLatitude(); // широта
    $array['longitude'] = $item->getLongitude(); // долгота
     $item->getData(); // необработанные данные
    return $array;
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
</head>
<body>

<form method="post">
    <input name="adress" value="" type="text" placeholder="Адрес">
    <input type="submit" value="Найти" name="find">
</form>




</body>
</html>
