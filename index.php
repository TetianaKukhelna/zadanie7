<?php

require_once 'database/config.php';

$lat = $_GET['lat'];
$lng = $_GET['lng'];

$url = "http://dataservice.accuweather.com/locations/v1/cities/geoposition/search?apikey=${WEATHER_API_KEY}&q=$lat,$lng";

$json = file_get_contents($url);
$json = json_decode($json);

$url = "http://dataservice.accuweather.com/forecasts/v1/daily/1day/".$json->Key."?apikey=${WEATHER_API_KEY}&language=sk-SK&details=true&metric=true";
$json = file_get_contents($url);
$json = json_decode($json);

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>GEO</title>
    <link rel="shortcut icon" type="image/jpg" href="https://findicons.com/files/icons/474/nature/128/cloud.png"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
   
<script src="scripts/script.js"></script>
 <script async src="https://maps.googleapis.com/maps/api/js?key=<?=PLACES_API_KEY?>&libraries=places&callback=initMap">
</script>
 <link rel="stylesheet" href="styles/myStyle.css">
</head>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content">
    <header>
        <?php
        include "includes/nav.php";
        ?>
        <h1>Počasie</h1>
    </header>
    <article class="container">
        <div class="input-group mb-3">
            <input id="pac-input"  type="text" class="form-control" placeholder="Address here" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <?php
        echo "Stav cez deň: " . $json->DailyForecasts[0]->Day->IconPhrase . "<br>Stav v noci: " . $json->DailyForecasts[0]->Night->IconPhrase . "<br>";
        echo "Status: " . $json->Headline->Text . "<br>";
        ?>
        <?php
        echo "Najmenšia teplota: " . $json->DailyForecasts[0]->Temperature->Minimum->Value .$json->DailyForecasts[0]->Temperature->Minimum->Unit . " Najväčšia teplota: " . $json->DailyForecasts[0]->Temperature->Maximum->Value .$json->DailyForecasts[0]->Temperature->Maximum->Unit . "<br>";
        ?>
        <br>
        <table>
            <tr>
                <th>Východ slnka</th>
                <th>Západ slnka</th>
            </tr>
            <?php
            echo "<tr><td>" . $json->DailyForecasts[0]->Sun->Rise . "</td><td>" . $json->DailyForecasts[0]->Sun->Set . "</td></tr>";
            ?>
        </table>
        <br>
        <table>
            <tr>
                <th>Východ mesiaca</th>
                <th>Východ mesiaca</th>
            </tr>
            <tr>
                <?php
                echo "<tr><td>" . $json->DailyForecasts[0]->Moon->Rise . "</td><td>" . $json->DailyForecasts[0]->Moon->Set . "</td></tr>";
                ?>
            </tr>
        </table>
        <?php echo "Fáza mesiaca: " . $json->DailyForecasts[0]->Moon->Phase . "<br>"?>
        <br>
        <table>
            <tr>
                <th>Deň</th>
                <th>Noc</th>
            </tr>
            <?php
            echo "<tr><td>Vietor: " . $json->DailyForecasts[0]->Day->Wind->Speed->Value . $json->DailyForecasts[0]->Day->Wind->Speed->Unit . " " . $json->DailyForecasts[0]->Day->Wind->Direction->Localized . "</td>";
            echo "<td>Vietor: " . $json->DailyForecasts[0]->Night->Wind->Speed->Value . $json->DailyForecasts[0]->Night->Wind->Speed->Unit . " " . $json->DailyForecasts[0]->Night->Wind->Direction->Localized . "</td></tr>";
            echo "<tr><td>Zrážky: " . $json->DailyForecasts[0]->Day->TotalLiquid->Value . $json->DailyForecasts[0]->Day->TotalLiquid->Unit . "</td>";
            echo "<td>Zrážky: " . $json->DailyForecasts[0]->Night->TotalLiquid->Value . $json->DailyForecasts[0]->Night->TotalLiquid->Unit . "</td></tr>";
            echo "<tr><td>Dážď: " . $json->DailyForecasts[0]->Day->Rain->Value . $json->DailyForecasts[0]->Day->Rain->Unit . "</td>";
            echo "<td>Dážď: " . $json->DailyForecasts[0]->Night->Rain->Value . $json->DailyForecasts[0]->Night->Rain->Unit . "</td></tr>";
            echo "<tr><td>Sneh: " . $json->DailyForecasts[0]->Day->Snow->Value . $json->DailyForecasts[0]->Day->Snow->Unit . "</td>";
            echo "<td>Sneh: " . $json->DailyForecasts[0]->Night->Snow->Value . $json->DailyForecasts[0]->Night->Snow->Unit . "</td></tr>";
            echo "<tr><td>Ľad: " . $json->DailyForecasts[0]->Day->Ice->Value . $json->DailyForecasts[0]->Day->Ice->Unit . "</td>";
            echo "<td>Ľad: " . $json->DailyForecasts[0]->Night->Ice->Value . $json->DailyForecasts[0]->Night->Ice->Unit . "</td></tr>";
            ?>
        </table>
    </article>
</div>
<?php include "includes/footer.php";?>
</body>
</html>