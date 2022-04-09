<?php
require_once 'Controller/RouteController.php';
session_start();
if (isset($_POST["routeVersionNumber"])) {
    $routeVersionNumber = $_POST["routeVersionNumber"];
    $breakStayPoint = $_POST["breakStayPoint"];
    $firstBreakStartTime = $_POST["firstBreakStartTime"];
    $lastBreakEndTime = $_POST["lastBreakEndTime"];
    $breakTimeMinutes = $_POST["breakTimeMinutes"];
    $starterTrip = "ab";
    $firstTripStartTime = "06:00:00";
    $lastTripStartTime = "21:00:00";
    $abTripTimeMinutes = "60";
    $abTripTimeSeconds = "00";
    $baTripTimeMinutes = "60";
    $baTripTimeSeconds = "00";
    $abBusCount = "4";
    $baBusCount = "4";
    $intervalTime = "00:00:00";

    $routeController = new RouteController();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
            }



            input[type="number"] {
                width:45px;
            }


            table, tr, td, th {

                border:1px solid black;
            }

            #tooltip {
                background: cornsilk;
                border: 1px solid black;
                border-radius: 5px;
                padding: 5px;
            }
        </style>
        <script>
            function showTooltip(evt, text) {
                let tooltip = document.getElementById("tooltip");
                tooltip.innerHTML = text;
                tooltip.style.display = "block";
                tooltip.style.left = evt.pageX + 10 + 'px';
                tooltip.style.top = evt.pageY + 10 + 'px';
            }

            function hideTooltip() {
                var tooltip = document.getElementById("tooltip");
                tooltip.style.display = "none";
            }
        </script>
    </head>
    <body>
        <div id="tooltip" display="none" style="position: absolute; display: none;"></div>

        <?php
        $routeWithBreaksVariations = $routeController->createExodudesVariationsWithBreakInSelectedRoute($routeVersionNumber, $breakStayPoint, $firstBreakStartTime, $lastBreakEndTime, $breakTimeMinutes);

        $exodusesVariations = $routeWithBreaksVariations->getExodusesVariationsWithBreaks();
        if (is_string($exodusesVariations)) {//if it is string it means its a warning
            echo $exodusesVariations;
        } else {
            //var_dump($exoduses);
            foreach ($exodusesVariations as $exoduses) {
//i whant here telika an array of exoduses variations
                // include 'Model/RouteGraphical.php';
            }
        }
        ?>

        
        
    </body>
</html>
