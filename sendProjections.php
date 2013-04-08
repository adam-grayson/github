<?php
    require ('mysql_connect.php');
    $playerIds = $_POST['players'];
    $date = $_POST['date'];

    $changedDateArray = explode('/', $date);
    $month = sprintf("%02d", $changedDateArray[0]);
    $day = sprintf("%02d", $changedDateArray[1]);
    $year = $changedDateArray[2];

    $date = date("$year-$month-$day");
    $dbc = db_connect();
    $playerIdsArray = explode(',', $playerIds);
    $response = "";
    
    for ($i=0; $i<count($playerIdsArray); $i++)
    {
        $type = substr($playerIdsArray[$i], 0, 1);
        $playerId = substr($playerIdsArray[$i], 1);
        
        $query = "SELECT projection FROM projections WHERE player = '$playerId' AND date LIKE '$date%'";
        $result = $dbc->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $projection = $row['projection'];
        }
        
        $response = $response.$projection;
    }
    echo $response;
?>