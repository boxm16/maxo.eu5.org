<?php

require_once 'Model/Route.php';
require_once 'TimeCalculator.php';
require_once 'SequenceCreator.php';

class RouteController {

    private $timeCalculator;
    private $haltTimeMinutes;

    function __construct() {
        $this->timeCalculator = new TimeCalculator();
        $this->haltTimeMinutes = 5; //this will be changed if haltTime will come  from frontend
    }

    public function getRouteVersionsWithoutBreaks($starterTrip, $firstTripStartTime, $lastTripStartTime, $abTripTimeMinutes, $abTripTimeSeconds, $baTripTimeMinutes, $baTripTimeSeconds, $abBusCount, $baBusCount, $intervalTime) {
        $allVersions = array();
        $initialSequence = $this->getInitialSequence($starterTrip, $firstTripStartTime, $abTripTimeMinutes, $abTripTimeSeconds, $baTripTimeMinutes, $baTripTimeSeconds, $abBusCount, $baBusCount, $intervalTime);
        $allPossibleSequencesFromInitialSequence = $this->getAllPossibleSequencesFromInitialSequence($initialSequence, $starterTrip, $firstTripStartTime, $abBusCount, $baBusCount, $abTripTimeMinutes, $abTripTimeSeconds, $baTripTimeMinutes, $baTripTimeSeconds, $intervalTime);

        foreach ($allPossibleSequencesFromInitialSequence as $sequence) {

            $route = new Route($sequence, $lastTripStartTime, $abTripTimeMinutes, $abTripTimeSeconds, $baTripTimeMinutes, $baTripTimeSeconds);

            array_push($allVersions, $route);
        }
        $_SESSION["routeVersionWithoutBreak"] = $allVersions;
        return $allVersions;
    }

    private function getInitialSequence($starterTrip, $firstTripStartTime, $abTripTimeMinutes, $abTripTimeSeconds, $baTripTimeMinutes, $baTripTimeSeconds, $abBusCount, $baBusCount, $intervalTime) {
        $initialSequence = array();

        $startTime = $firstTripStartTime; //can change here, this is perritos

        if ($starterTrip == "ab") {
            $goTrip = "ab";
            $returnTrip = "ba";
            $goBusCount = $abBusCount;
            $returnBusCount = $baBusCount;
        } else {
            $goTrip = "ba";
            $returnTrip = "ab";
            $goBusCount = $baBusCount;
            $returnBusCount = $abBusCount;
        }

        while ($goBusCount > 0) {
            $busTripIgnitionCode = new ExodusIgnitionCode($goTrip, $startTime);
            $startTime = $this->increaseStartTimeByInterval($startTime, $intervalTime);
            array_push($initialSequence, $busTripIgnitionCode);
            $goBusCount--;
        }

        if ($returnTrip == "ab") {
            $returnTripTimeSeconds = $this->timeCalculator->getSecondsFromMinutesAndSeconds($abTripTimeMinutes, $abTripTimeSeconds);
            $returnTripTimeSeconds = $returnTripTimeSeconds + ($this->haltTimeMinutes * 60);
        } else {

            $returnTripTimeSeconds = $this->timeCalculator->getSecondsFromMinutesAndSeconds($baTripTimeMinutes, $baTripTimeSeconds);
            $returnTripTimeSeconds = $returnTripTimeSeconds + ($this->haltTimeMinutes * 60);
        }

        $startTime = $this->decreaseStartTimeByReturnTime($startTime, $returnTripTimeSeconds);

        while ($returnBusCount > 0) {
            $busTripIgnitionCode = new ExodusIgnitionCode($returnTrip, $startTime);
            $startTime = $this->increaseStartTimeByInterval($startTime, $intervalTime);
            array_push($initialSequence, $busTripIgnitionCode);
            $returnBusCount--;
        }
        return $initialSequence;
    }

    private function increaseStartTimeByInterval($startTime, $intervalTime) {
        $seconds = $this->timeCalculator->getSecondsFromTimeStamp($startTime);
        $intervalSeconds = $this->timeCalculator->getSecondsFromTimeStamp($intervalTime);
        $resultSeconds = $seconds + $intervalSeconds;
        $time = $this->timeCalculator->getTimeStampFromSeconds($resultSeconds);

        return $time;
    }

    private function decreaseStartTimeByReturnTime($startTime, $returnTripTimeSeconds) {

        $seconds = $this->timeCalculator->getSecondsFromTimeStamp($startTime);
        $resultSeconds = $seconds - $returnTripTimeSeconds;
        $time = $this->timeCalculator->getTimeStampFromSeconds($resultSeconds);

        return $time;
    }

//-------------------------for all possible sequences and down

    private function getAllPossibleSequencesFromInitialSequence($initialSequence, $starterTrip, $firstTripStartTime, $abBusCount, $baBusCount, $abTripTimeMinutes, $abTripTimeSeconds, $baTripTimeMinutes, $baTripTimeSeconds, $intervalTime) {
        if ($starterTrip == "ab") {
            $goTrip = "ab";
            $returnTrip = "ba";
            $goBusCount = $abBusCount;
            $returnBusCount = $baBusCount;
            $goTripTimeInSeconds = ($abTripTimeMinutes * 60) + ($abTripTimeSeconds * 1);
            $returnTripTimeInSeconds = ($baTripTimeMinutes * 60) + ($baTripTimeSeconds * 1);
        } else {
            $goTrip = "ba";
            $returnTrip = "ab";
            $goBusCount = $baBusCount;
            $returnBusCount = $abBusCount;
            $goTripTimeInSeconds = ($baTripTimeMinutes * 60) + ($baTripTimeSeconds * 1);
            $returnTripTimeInSeconds = ($abTripTimeMinutes * 60) + ($abTripTimeSeconds * 1);
        }
        if ($goBusCount <= $returnBusCount) {
            $allPossibleSequences = array();
            array_push($allPossibleSequences, $initialSequence);
            return $allPossibleSequences;
        }
        $index = -1;
        $standartSequence = array();

        foreach ($initialSequence as $busTripIgnitionCode) {

            $index++;
            $one = $this->timeCalculator->getSecondsFromTimeStamp($busTripIgnitionCode->getStartTime());
            $two = $this->haltTimeMinutes * 60;
            $three = $returnTripTimeInSeconds;
            $four = $this->timeCalculator->getSecondsFromTimeStamp($firstTripStartTime);
            if ($one - $two - $three >= $four) {
                break;
            }
            array_push($standartSequence, $busTripIgnitionCode);
        }
        if (count($standartSequence) != count($initialSequence)) {
            $nonStandartSequence = array();
            $pararellSequence = array();

            for ($x = $index; $x < count($initialSequence); $x++) {
                $ignitionCode = $initialSequence[$x];
                array_push($nonStandartSequence, $ignitionCode);
                if ($ignitionCode->getTripPeriodType() == $goTrip) {
                    array_push($pararellSequence, "o");
                } else {
                    array_push($pararellSequence, "W");
                }
            }

            $sequenceCreator = new SequenceCreator();
            $intervalTimeInSeconds = $this->timeCalculator->getSecondsFromTimeStamp($intervalTime);
            $allNonStandartSequences = $sequenceCreator->getAllPossibleSequencesOfNonStardartSequence($nonStandartSequence, $pararellSequence, $intervalTimeInSeconds);

            $allPosibleSequences = $this->combineStandartAndAllNonStandartSequencese($standartSequence, $allNonStandartSequences);
        } else {
            $allPosibleSequences = array($initialSequence);
        }
        return $allPosibleSequences;
    }

    private function combineStandartAndAllNonStandartSequencese($standartSequence, $allNonStandartSequences) {
        $allPossibleSequences = array();
        foreach ($allNonStandartSequences as $nonStandartSequence) {
            $combinedSequence = array_merge($standartSequence, $nonStandartSequence);
            array_push($allPossibleSequences, $combinedSequence);
        }

        return $allPossibleSequences;
    }

    //----------------------with breaks------

    public function createExodudesVariationsWithBreakInSelectedRoute($routeVersionNumber, $breakStayPoint, $firstBreakStartTime, $lastBreakEndTime, $breakTimeMinutes) {

       //here i take selected route and gave order to create inside it all possible versions of exoduses with break
       // 
        $route = $_SESSION["routeVersionWithoutBreak"][$routeVersionNumber];

        $route->createExodudesVariationsWithBreaks($breakStayPoint, $firstBreakStartTime, $lastBreakEndTime, $breakTimeMinutes);


        return $route;
    }

}
