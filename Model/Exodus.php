<?php

require_once 'TripPeriod.php';
require_once 'Controller/TimeCalculator.php';

class Exodus {

    private $ignitionCode;
    private $lastTripStartTime;
    private $abTripTimeMinutes;
    private $abTripTimeSeconds;
    private $baTripTimeMinutes;
    private $baTripTimeSeconds;
    private $timeCalculator;

    function __construct($ignitionCode, $lastTripStartTime, $abTripTimeMinutes, $abTripTimeSeconds, $baTripTimeMinutes, $baTripTimeSeconds) {
        $this->ignitionCode = $ignitionCode;
        $this->lastTripStartTime = $lastTripStartTime;
        $this->abTripTimeMinutes = $abTripTimeMinutes;
        $this->abTripTimeSeconds = $abTripTimeSeconds;
        $this->baTripTimeMinutes = $baTripTimeMinutes;
        $this->baTripTimeSeconds = $baTripTimeSeconds;

        $this->timeCalculator = new TimeCalculator();
    }

    public function getTripPeriodsWithoutBreak() {

        $tripPeriods = array();
        $tripPeriodType = $this->ignitionCode->getTripPeriodType();
        $startTime = $this->ignitionCode->getStartTime(); //$startTIme is timeStamp
        $startTimeInSeconds = $this->timeCalculator->getSecondsFromTimeStamp($startTime);
        $lastTripStartTimeInSeconds = $this->timeCalculator->getSecondsFromTimeStamp($this->lastTripStartTime);


        while ($startTimeInSeconds < $lastTripStartTimeInSeconds) {

            if ($tripPeriodType == "ab") {
                $tripPeriodTimeInSeconds = ($this->abTripTimeMinutes * 60) + $this->abTripTimeSeconds;
                $tripPeriod = new TripPeriod($tripPeriodType, $startTimeInSeconds, $tripPeriodTimeInSeconds);
                array_push($tripPeriods, $tripPeriod);
                $startTimeInSeconds += $tripPeriodTimeInSeconds;
                $tripPeriod = new TripPeriod("halt", $startTimeInSeconds, 300);
                array_push($tripPeriods, $tripPeriod);
                $startTimeInSeconds += 300;
                $tripPeriodType = "ba";
            } else {
                $tripPeriodTimeInSeconds = ($this->baTripTimeMinutes * 60) + $this->baTripTimeSeconds;
                $tripPeriod = new TripPeriod($tripPeriodType, $startTimeInSeconds, $tripPeriodTimeInSeconds);
                array_push($tripPeriods, $tripPeriod);
                $startTimeInSeconds += $tripPeriodTimeInSeconds;
                $tripPeriod = new TripPeriod("halt", $startTimeInSeconds, 300);
                array_push($tripPeriods, $tripPeriod);
                $startTimeInSeconds += 300;
                $tripPeriodType = "ab";
            }
        }




        return $tripPeriods;
    }

    public function getTripPeriodsWithBreak($breakStartTime, $breakTimeInSeconds) {

        $tripPeriods = array();
        $tripPeriodType = $this->ignitionCode->getTripPeriodType();
        $startTime = $this->ignitionCode->getStartTime(); //$startTIme is timeStamp
        $startTimeInSeconds = $this->timeCalculator->getSecondsFromTimeStamp($startTime);
        $lastTripStartTimeInSeconds = $this->timeCalculator->getSecondsFromTimeStamp($this->lastTripStartTime);


        while ($startTimeInSeconds < $lastTripStartTimeInSeconds) {

            if ($tripPeriodType == "ab") {
                $tripPeriodTimeInSeconds = ($this->abTripTimeMinutes * 60) + $this->abTripTimeSeconds;
                $tripPeriod = new TripPeriod($tripPeriodType, $startTimeInSeconds, $tripPeriodTimeInSeconds);
                array_push($tripPeriods, $tripPeriod);
                $startTimeInSeconds += $tripPeriodTimeInSeconds;

                //break period 
                if ($startTimeInSeconds == $breakStartTime) {
                    $tripPeriod = new TripPeriod("break", $breakStartTime, $breakTimeInSeconds);

                    $startTimeInSeconds += $breakTimeInSeconds;
                    array_push($tripPeriods, $tripPeriod);
                }
                //----end



                $tripPeriod = new TripPeriod("halt", $startTimeInSeconds, 300);
                array_push($tripPeriods, $tripPeriod);
                $startTimeInSeconds += 300;
                $tripPeriodType = "ba";
            } else {
                $tripPeriodTimeInSeconds = ($this->baTripTimeMinutes * 60) + $this->baTripTimeSeconds;
                $tripPeriod = new TripPeriod($tripPeriodType, $startTimeInSeconds, $tripPeriodTimeInSeconds);
                array_push($tripPeriods, $tripPeriod);
                $startTimeInSeconds += $tripPeriodTimeInSeconds;

                //break period 
                if ($startTimeInSeconds == $breakStartTime) {
                    $tripPeriod = new TripPeriod("break", $breakStartTime, $breakTimeInSeconds);

                    $startTimeInSeconds += $breakTimeInSeconds;
                    array_push($tripPeriods, $tripPeriod);
                }
                //----end


                $tripPeriod = new TripPeriod("halt", $startTimeInSeconds, 300);
                array_push($tripPeriods, $tripPeriod);
                $startTimeInSeconds += 300;
                $tripPeriodType = "ab";
            }
        }




        return $tripPeriods;
    }

}
