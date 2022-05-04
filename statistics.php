<?php
require_once "database/Database.php";
date_default_timezone_set('Europe/Bratislava');

try {
    $conn = (new Database())->getConnection();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$ipaddress = getenv("REMOTE_ADDR"); //ip
$json = file_get_contents("http://ip-api.com/json/$ipaddress");
$json = json_decode($json);

$country = $json->country; //country
$flag = $json->countryCode; //flag

$stmt = $conn->prepare("SELECT ip, visit, id, country FROM visitors");
$stmt->execute();
$visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "insert into info (
    city,
    country,
    country_kod,
    data_time,
    latitude,
    longtitude)
values (
    :city,
    :country,
    :country_kod,
    :data_time,
    :latitude,
    :longtitude)
;";

$stmt = $conn->prepare($sql);
$stmt->execute([
    ':city'=>$json->city,
    ':country'=>$json->country,
    ':country_kod' => $json->countryCode,
    ':data_time' => date('Y-m-d H:i:s', time()),
    ':latitude' => $json->lat,
    ':longtitude' => $json->lon
]);
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
    <link rel="stylesheet" href="styles/myStyle.css">
    <script>

        <?php 
        $stmt = $conn->prepare("select id, CONCAT(country,' ', city) as title, latitude, longtitude as longitude, data_time from info");
        $stmt->execute();
        $visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>

        var json = <?=json_encode($visitors)?>;

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="scripts/statistic.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content">
    <header>
        <?php include "includes/nav.php";?>
        <h1>Štatistika návštevnosti</h1>
    </header>
    <article>
    <?php 
        $country_code = $_GET['country'];
        if($country_code):

            $stmt = $conn->prepare("select id, country, country_kod, CONCAT(country,' ', city) as title, latitude, longtitude as longitude, data_time from info WHERE country_kod=:country_kod");
            $stmt->execute([
                ':country_kod' => $country_code
            ]);
            $visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);
     ?>

<table>
      <?php foreach($visitors as $visitor):?>
            <tr>
            <td><img src="https://ipdata.co/flags/<?=strtolower($visitor['country_kod'])?>.png" alt="<?$visitor['country']?>"/> </td>
            <td><?=$visitor['title']?></td>
            <td><?=$visitor['data_time']?></td>
            </tr>
       <?php endforeach; ?>
       </table>
    <?php else: ?>
        <div id="map-canvas" style="width: 100%; height: 600px;"></div>

    <?php
    $stmt = $conn->prepare("select country, country_kod, count(*) as visitors from info group by country, country_kod ORDER BY visitors");
    $stmt->execute();
    $visitors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    ?>
   <table>
       <tr>
           <th></th>
           <th>Krajina</th>
           <th>Počet návštev</th>
       </tr>
       <?php foreach($visitors as $visitor):?>
           <tr>
           <td><img src="https://ipdata.co/flags/<?=strtolower($visitor['country_kod'])?>.png" alt="<?$visitor['country']?>" /></td>
           <td><a href="?country=<?=$visitor['country_kod']?>"><?=$visitor['country']?></a></td>
           <td><?=$visitor['visitors']?></td>
           </tr>
       <?php endforeach; ?>
   </table>
    <?php endif;?>
   
    </article>
</div>
<?php include "includes/footer.php";?>
</body>
</html>