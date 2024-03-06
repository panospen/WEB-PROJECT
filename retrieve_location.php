<?php
    include("php/config.php");

    $username = $_GET['username'];
    $sql = "SELECT id, username, latitude, longitude FROM users";
    $result = mysqli_query($con, $sql);

    $geojson = array(
        'type' => 'FeatureCollection',
        'features' => array()
    );

    while($row = mysqli_fetch_assoc($result)){
        $properties = $row;
        unset($properties['latitude']);
        unset($properties['longitude']);
        
        $feature = array(
            'type' => 'Feature',
            'geometry' => array(
                'type' => 'Point',
                'coordinates' => array(
                    floatval($row['longitude']),
                    floatval($row['latitude'])
                )
                ),
                'properties' => $properties
        );

        array_push($geojson['features'], $feature);
    }

    echo json_encode($geojson, JSON_NUMERIC_CHECK);
?>