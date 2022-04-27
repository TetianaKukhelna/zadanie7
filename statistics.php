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
$visitors = $stmt->fetchAll(PDO::FETCH_NUM);

function visitorExist($visitors, $ipaddress, $country){
    foreach($visitors as $visitor){
        if($ipaddress == $visitor[0] && $country == $visitor[3]){
            return true;
        }
    }
    return false;
}

function visitorTime($visitor){
    $time_now = date('Y-m-d H:i:s', time());
    $time_diff = $visitor[1];
    $time_now = date_create_from_format('Y-m-d H:i:s', $time_now);
    $time_diff = date_create_from_format('Y-m-d H:i:s', $time_diff);
    $time = $time_now->diff($time_diff);
    $tmp = $time->f + $time->s + $time->i*60 + $time->h*3600 + $time->d*86400;
    if($tmp > 86400){ //day time in seconds
        return true;
    }
    return false;
}

if(!visitorExist($visitors, $ipaddress, $country)){
    $stmt = $conn->prepare("INSERT INTO visitors(ip, country, visit) VALUES ('".$ipaddress."','".$country."','".date('Y-m-d H:i:s', time())."')");
    $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM stats_visits");
    $stmt->execute();
    $stats = $stmt->fetchAll(PDO::FETCH_NUM);

    $tmp = 0;
    $countryExist = false;
    foreach($stats as $s){
        if($s[1] == $country){
            $tmp++;
            $countryExist = true;
        }
    }

    if($countryExist == false){
        $stmt = $conn->prepare("INSERT INTO stats_visits(country, sumary, country_code) VALUES ('".$country."','". 1 ."','".strtolower($flag)."')");
        $stmt->execute();
    }else{
        $stmt = $conn->prepare("UPDATE stats_visits SET sumary='".($tmp+1)."' WHERE country='".$country."'");
        $stmt->execute();
    }


}else{
    foreach ($visitors as $visitor){
        if($ipaddress == $visitor[0] && visitorTime($visitor) && $country == $visitor[3]){
            $stmt = $conn->prepare("UPDATE visitors SET visit='".date('Y-m-d H:i:s', time())."' WHERE ip='".$ipaddress."'");
            $stmt->execute();

            $tmp = 0;
            foreach($visitors as $v){
                if($country == $v[3]){
                    $tmp++;
                }
            }
            $stmt = $conn->prepare("UPDATE stats_visits SET sumary='".$tmp."' WHERE country='".$country."'");
            $stmt->execute();
        }
    }
}

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
</head>
<body class="d-flex flex-column min-vh-100">
<div class="wrapper flex-grow-1 center-content">
    <header>
        <?php include "includes/nav.php";?>
        <h1>Štatistika návštevnosti</h1>
    </header>
    <article>
        <?php
        $stmt = $conn->prepare("SELECT country, sumary, country_code FROM stats_visits ORDER BY sumary");
        $stmt->execute();
        $visitors = $stmt->fetchAll(PDO::FETCH_NUM);
        ?>
        <table>
            <tr>
                <th></th>
                <th>Krajina</th>
                <th>Počet návštev</th>
            </tr>
            <?php
            for($i = 0; $i < count($visitors); $i++){
                echo "<tr>";
                    echo "<td><img src='https://ipdata.co/flags/".$visitors[$i][2].".png' alt='".$visitors[$i][2]."'></td>";
                    echo "<td>".$visitors[$i][0]."</td>";
                    echo "<td>".$visitors[$i][1]."</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </article>
</div>
<?php include "includes/footer.php";?>
</body>
</html>