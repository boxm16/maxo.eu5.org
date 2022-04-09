<?php


class TripPeriod {

    private $type;
    private $startTimeInSeconds;
    private $tripPeriodTimeInSeconds;
    private $timeCalculator;

    function __construct($type, $startTimeInSeconds, $tripPeriodTimeInSeconds) {
        $this->type = $type;
        $this->startTimeInSeconds = $startTimeInSeconds;
        $this->tripPeriodTimeInSeconds = $tripPeriodTimeInSeconds;
        $this->timeCalculator=new TimeCalculator();
    }

    public function getColor() {
        if ($this->type == "ab") {
            return "blue";
        }
        if ($this->type == "ba") {
            return "green";
        }
        if ($this->type == "halt") {
            return "black";
        }
        if ($this->type == "break") {
            return "yellow";
        }
    }

    function getType() {
        return $this->type;
    }

    public function getLength() {
        return $this->tripPeriodTimeInSeconds / 60;
    }

    public function getStartPoint() {
        return $this->getPointFromTimeInSeconds($this->startTimeInSeconds);
    }

    private function getPointFromTimeInSeconds($timeInSeconds) {
        return 30 + $timeInSeconds / 60 - (5 * 60);
    }

    function getStartTimeInSeconds() {
        return $this->startTimeInSeconds;
    }

    function getEndTimeInSeconds() {
        return $this->startTimeInSeconds+$this->tripPeriodTimeInSeconds;
    }

    private function getPointFromTimeStamp($timeStamp) {
        $splittedTime = explode(":", $timeStamp);
        $hours = $splittedTime[0];
        $minutes = $splittedTime[1];

        if (count($splittedTime) == 3) {
            $seconds = $splittedTime[2];
        } else {
            $seconds = 0;
        }
        return 30 + ($hours - 5) * 60 + ($minutes) + ($seconds / 60);
    }
    
    public function  getStartTimeStamp(){
        return $this->timeCalculator->getTimeStampFromSeconds($this->startTimeInSeconds);
    }
      public function  getEndTimeStamp(){
        return $this->timeCalculator->getTimeStampFromSeconds($this->startTimeInSeconds+$this->tripPeriodTimeInSeconds);
    }

}
