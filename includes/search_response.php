
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
    <tr>
        <th><?=$json->DailyForecasts[0]->Sun->Rise?></th>
        <th><?=$json->DailyForecasts[0]->Sun->Set?></th>
    </tr>
</table>
<br>
<table>
    <tr>
        <th>Východ mesiaca</th>
        <th>Východ mesiaca</th>
    </tr>
    <tr>
        <th><?=$json->DailyForecasts[0]->Moon->Rise?></th>
        <th><?=$json->DailyForecasts[0]->Moon->Set?></th>
    </tr>
</table>
<?php echo "Fáza mesiaca: " . $json->DailyForecasts[0]->Moon->Phase . "<br>"?>
<br>
<table>
    <tr>
        <th>Deň</th>
        <th>Noc</th>
    </tr>
    <tr>
        <th>Vietor: <?=$json->DailyForecasts[0]->Day->Wind->Speed->Value . $json->DailyForecasts[0]->Day->Wind->Speed->Unit . " " . $json->DailyForecasts[0]->Day->Wind->Direction->Localized?></th>
        <th>Vietor: <?=$json->DailyForecasts[0]->Night->Wind->Speed->Value . $json->DailyForecasts[0]->Night->Wind->Speed->Unit . " " . $json->DailyForecasts[0]->Night->Wind->Direction->Localized?></th>
    </tr>
    <tr>
        <th>Zrážky: <?=$json->DailyForecasts[0]->Day->TotalLiquid->Value . $json->DailyForecasts[0]->Day->TotalLiquid->Unit?></th>
        <th>Zrážky: <?=$json->DailyForecasts[0]->Night->TotalLiquid->Value . $json->DailyForecasts[0]->Night->TotalLiquid->Unit?></th>
    </tr>

    <tr>
        <th>Dážď: $json->DailyForecasts[0]->Day->Rain->Value . $json->DailyForecasts[0]->Day->Rain->Unit</th>
        <th>Dážď: $json->DailyForecasts[0]->Night->Rain->Value . $json->DailyForecasts[0]->Night->Rain->Unit</th>
    </tr>

    <?php

    echo "<tr><td>Sneh: " . $json->DailyForecasts[0]->Day->Snow->Value . $json->DailyForecasts[0]->Day->Snow->Unit . "</td>";
    echo "<td>Sneh: " . $json->DailyForecasts[0]->Night->Snow->Value . $json->DailyForecasts[0]->Night->Snow->Unit . "</td></tr>";
    echo "<tr><td>Ľad: " . $json->DailyForecasts[0]->Day->Ice->Value . $json->DailyForecasts[0]->Day->Ice->Unit . "</td>";
    echo "<td>Ľad: " . $json->DailyForecasts[0]->Night->Ice->Value . $json->DailyForecasts[0]->Night->Ice->Unit . "</td></tr>";
    ?>
</table>