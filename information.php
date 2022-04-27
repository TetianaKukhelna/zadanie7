<?php
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$ipaddress = $ip;
$json = file_get_contents("http://ip-api.com/json/$ipaddress");
$json = json_decode($json);

$cords = $json->lat . ", " . $json->lon;
$town = "";
if($json->city != "")
    $town = $json->city;
else
    $town = "Mesto sa nedá lokalizovať alebo sa nachádzate na vidieku.";
$state = $json->country;

$json = file_get_contents("http://restcountries.eu/rest/v2/name/".$state);
$json = json_decode($json);
$maintown = $json[0]->capital;
?>



<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>GEO</title>
    <link rel="shortcut icon" type="image/jpg" href="https://findicons.com/files/icons/474/nature/128/cloud.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/myStyle.css">
</head>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content">
    <header>
        <?php include "includes/nav.php";?>
        <h1>Informácie</h1>
    </header>
    <article class="container">
        <?php
        echo "IP: " . $ipaddress . "<br>Zemepisná poloha: " . $cords  . "<br>Mesto: " . $town . "<br>Štát: " . $state . "<br>Hlavné mesto štátu: " . $maintown . "<br>";
        ?>
    </article>
</div>
<?php include "includes/footer.php";?>
</body>
</html>