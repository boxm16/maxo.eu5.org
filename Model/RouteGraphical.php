
<?php
$height = count($exoduses) * 36; //counting exoduses and building height
$svgHeight = $height + 20;
$x = 30;
$y = 30;
$lap = 1200 / 20;
$time = "05";
?>
<svg width='1500' height='<?php echo $svgHeight; ?>'>
<rect x='5' width='1530' height='20' style='fill:rgb(0,0,0);' />
<rect x='5' width='20' height='<?php echo $height; ?>' style='fill:rgb(0,0,0);' />
<?php
for ($a = 0; $a < 21; $a++) {
    ?>

    <line x1='<?php echo $x; ?>' y1='20' x2='<?php echo $x; ?>' y2='<?php echo $height; ?>'style='stroke:rgb(0,0,0);stroke-width:1' />
    <?php
    $tp = $x - 17;

    $timeF = $time . ":00";
    ?>

    <text x='<?php echo $tp ?>' y='15' fill='white'><?php echo $timeF ?></text>
    <?php
    $time++;
    if ($time < 10) {
        $time = "0" . $time;
    }
    if ($time == 25) {
        $time = "01";
    }
    $x += $lap;
}
//----------------------------------------------------------------
$yI = 30;



foreach ($exoduses as $tripPeriods) {
    foreach ($tripPeriods as $tripPeriod) {
        $startPoint = $tripPeriod->getStartPoint();

        $tripPeriodColor = $tripPeriod->getColor();
        $tripPeriodLength = $tripPeriod->getLength();
        $tripPeriodStartTime = $tripPeriod->getStartTimeStamp();
        $tripPeriodEndTime = $tripPeriod->getEndTimeStamp();
        $tripPeriodDescriptionText = "$tripPeriodStartTime-$tripPeriodEndTime";
        echo "<rect x='$startPoint' y='$yI' width='$tripPeriodLength' height='20'  rx='7' style='fill:$tripPeriodColor' onmousemove=\"showTooltip(evt, '$tripPeriodDescriptionText');\" onmouseout=\"hideTooltip();\"  />";
    }
    $yI += 30;
}


echo "</svg>"
 . " <hr>";


