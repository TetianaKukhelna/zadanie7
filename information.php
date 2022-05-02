<?php
require_once 'database/config.php';

function check_status($jsondata) {
    if ($jsondata["status"] == "OK") return true;
    return false;
}

function google_getCountry($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
}
function google_getProvince($jsondata) {
    return Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
}
function google_getCity($jsondata) {
    return Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
}
function google_getStreet($jsondata) {
    return Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
}
function google_getPostalCode($jsondata) {
    return Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
}
function google_getCountryCode($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
}
function google_getAddress($jsondata) {
    return $jsondata["results"][0]["formatted_address"];
}

/*
* Searching in Google Geo json, return the long name given the type. 
* (If short_name is true, return short name)
*/

function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
    foreach( $array as $value) {
        if (in_array($type, $value["types"])) {
            if ($short_name)    
                return $value["short_name"];
            return $value["long_name"];
        }
    }
}

function Get_Address_From_Google_Maps($lat, $lon) {

    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$lon}&sensor=false&key=".PLACES_API_KEY;
    
    // Make the HTTP request
    $data = @file_get_contents($url);
    // Parse the json response
    $jsondata = json_decode($data,true);

    // If the json data is invalid, return empty array
    if (!check_status($jsondata))   return array();
    
    $address = array(
        'country' => google_getCountry($jsondata),
        'province' => google_getProvince($jsondata),
        'city' => google_getCity($jsondata),
        'street' => google_getStreet($jsondata),
        'postal_code' => google_getPostalCode($jsondata),
        'country_code' => google_getCountryCode($jsondata),
        'formatted_address' => google_getAddress($jsondata),
    );
    
    return $address;
}

$lat = $_GET['lat'];
$lng = $_GET['lng'];

$address = Get_Address_From_Google_Maps($lat, $lng);

$json = new stdclass();

$cords = $lat . ", " . $lng;

$url  = "https://restcountries.com/v3.1/name/".$address['country'];

$json = file_get_contents($url);
print_r($json);

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
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
   
    <script src="scripts/script.js"></script>
 <script async src="https://maps.googleapis.com/maps/api/js?key=<?=PLACES_API_KEY?>&libraries=places&callback=initMap">
</script>
</head>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content">
    <header>
        <?php include "includes/nav.php";?>
        <h1>Informácie</h1>
    </header>
    <article class="container">
        <div class="input-group mb-3">
            <input id="pac-input"  type="text" class="form-control" placeholder="Address here" aria-label="Recipient's username" aria-describedby="basic-addon2">
        </div>

        <?php
    
        echo "Zemepisná poloha: " . $lat . ", ".$lng  . "<br>";
        echo "Mesto: " . $address['city'] . "<br>";
        echo "Štát: " . $address['country'] . "<br>";
        echo "Hlavné mesto štátu: " . $maintown . "<br>";
        ?>
    </article>
</div>
<?php include "includes/footer.php";?>
</body>
</html>