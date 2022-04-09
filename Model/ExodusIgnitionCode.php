<?php

class ExodusIgnitionCode {

    private $tripPeriodType;
    private $startTime;
    function __construct($tripPeriodType, $startTime) {
        $this->tripPeriodType = $tripPeriodType;
        $this->startTime = $startTime;
    }

    function getTripPeriodType() {
        return $this->tripPeriodType;
    }

    function getStartTime() {
        return $this->startTime;
    }

    function setTripPeriodType($tripPeriodType) {
        $this->tripPeriodType = $tripPeriodType;
    }

    function setStartTime($startTime) {
        $this->startTime = $startTime;
    }



}
