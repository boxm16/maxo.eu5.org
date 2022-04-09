<?php

require_once 'Exodus.php';
require_once 'Model/ExodusIgnitionCode.php';
require_once 'Controller/TimeCalculator.php';

class Route {

    private $ignitionSequence;
    private $lastTripStartTime;
    private $abTripTimeMinutes;
    private $abTripTimeSeconds;
    private $baTripTimeMinutes;
    private $baTripTimeSeconds;
    private $exodusesWithoutBreak;
    private $exodusesCount;
    private $timeCalculator;
    private $exodusesVariationsWithBreaks;
    private $breaksPool; //this is my magic pool, here i keep breaks when i iterate through all possible breaks variations, to see if they cross over

    function __construct($ignitionSequence, $lastTripStartTime, $abTripTimeMinutes, $abTripTimeSeconds, $baTripTimeMinutes, $baTripTimeSeconds) {
        $this->ignitionSequence = $ignitionSequence;
        $this->lastTripStartTime = $lastTripStartTime;
        $this->abTripTimeMinutes = $abTripTimeMinutes;
        $this->abTripTimeSeconds = $abTripTimeSeconds;
        $this->baTripTimeMinutes = $baTripTimeMinutes;
        $this->baTripTimeSeconds = $baTripTimeSeconds;
        $this->timeCalculator = new TimeCalculator();
        $this->exodusesWithoutBreak = array();
        $this->exodusesVariationsWithBreaks = array();
        $this->breaksPool = array();
    }

    public function getExodusesWithoutBreak() {
        $exoduses = array();
        foreach ($this->ignitionSequence as $exodusIgnitionCode) {
            $exodus = new Exodus($exodusIgnitionCode, $this->lastTripStartTime, $this->abTripTimeMinutes, $this->abTripTimeSeconds, $this->baTripTimeMinutes, $this->baTripTimeSeconds);
            $exodusWithoutBreak = $exodus->getTripPeriodsWithoutBreak();
            array_push($exoduses, $exodusWithoutBreak);
        }
        $this->exodusesWithoutBreak = $exoduses;
        $this->exodusesCount = count($exoduses);
        return $exoduses;
    }

    function getExodusesCount() {
        return $this->exodusesCount;
    }

    function getExodusesVariationsWithBreaks() {
        return $this->exodusesVariationsWithBreaks;
    }

    function setExodusesVariationsWithBreaks($exodusesWithBreak) {
        $this->exodusesVariationsWithBreaks = $exodusesWithBreak;
    }

    public function createExodudesVariationsWithBreaks($breakStayPoint, $firstBreakStartTime, $lastBreakEndTime, $breakTimeMinutes) {



        $firstBreakStartTimeInSeconds = $this->timeCalculator->getSecondsFromTimeStamp($firstBreakStartTime);
        $lastBreakEndTimeInSeconds = $this->timeCalculator->getSecondsFromTimeStamp($lastBreakEndTime);
        $breakTimeSeconds = "00";
        $breakTimeInSeconds = $this->timeCalculator->getSecondsFromMinutesAndSeconds($breakTimeMinutes, $breakTimeSeconds);
        $exodusesCount = $this->getExodusesCount();
        $allBreaksTime = $exodusesCount * $breakTimeInSeconds;
        if ($firstBreakStartTimeInSeconds + $allBreaksTime > $lastBreakEndTimeInSeconds) {
            $this->setExodusesVariationsWithBreaks("<h1>მოცემულუ შესვენებების რაოდენობა არ ეტევა მოვემულ ფარგლებში. დაბრუნდი უკან და გაზარდე შესვენებების ფარგლები</h1>");
            return;
        }

        $purifiedExoduses = $this->purifyRouteExoduses($breakStayPoint, $firstBreakStartTimeInSeconds, $lastBreakEndTimeInSeconds, $breakTimeInSeconds);

        $allPossibleBreaksArray = $this->getAllPossibleBreaksStartTimes($purifiedExoduses);


        $start = microtime(true);


        $validBreaksStartTimesSequences = $this->permutationOfMultidimensionalArray($allPossibleBreaksArray, $breakTimeInSeconds, $firstBreakStartTime, $lastBreakEndTime, $breakTimeMinutes);
        if ($validBreaksStartTimesSequences == 0) {
            $this->setExodusesVariationsWithBreaks("<h1>მოცემული პარამეტრებით არ იძებნება არცერთი ვარიანთი. შეცვალე პარამეტრები და სცადე თავიდან</h1>");
            return;
        }

        $stop = microtime(true) - $start;


        printf('<hr /><p>
       Execution time: %f sec<br/>
       Memory usage: %d Kb</p>',
                $stop,
                memory_get_peak_usage(true) / 1024);
    }

    private function purifyRouteExoduses($breakStayPoint, $firstBreakStartTimeInSeconds, $lastBreakEndTimeInSeconds, $breakTimeInSeconds) {
        $typeOne = "";
        $typeBoth = false;
        if ($breakStayPoint == "A") {
            $typeOne = "ba";
        }
        if ($breakStayPoint == "B") {
            $typeOne = "ab";
        }
        if ($breakStayPoint == "AandB") {
            $typeBoth = true;
        }

        $newExoduses = array();
        $exoduses = $this->getExodusesWithoutBreak();
        foreach ($exoduses as $exodus) {
            $newExodus = array();
            foreach ($exodus as $tripPeriod) {
                if ($tripPeriod->getType() == $typeOne || $typeBoth) {
                    if ($tripPeriod->getType() != "halt") {

                        $tripPeriodEndTimeInSeconds = $tripPeriod->getEndTimeInSeconds();

                        if ($tripPeriodEndTimeInSeconds >= $firstBreakStartTimeInSeconds) {


                            if ($tripPeriodEndTimeInSeconds + $breakTimeInSeconds <= $lastBreakEndTimeInSeconds) {
                                array_push($newExodus, $tripPeriod);
                            }
                        }
                    }
                }
            }
            array_push($newExoduses, $newExodus);
        }
        $this->setExodusesVariationsWithBreaks($newExoduses);
        return $newExoduses;
    }

    public function getAllPossibleBreaksStartTimes($exoduses) {
        //here I get All Possible Breaks Start Times

        $startTimesArray = array();

        for ($x = 0; $x < count($exoduses); $x++) {
            $tripPeriods = $exoduses[$x];
            $insideArray = array();
            foreach ($tripPeriods as $tripPeriod) {
                $breakStartTime = $tripPeriod->getEndTimeInSeconds();
                array_push($insideArray, $breakStartTime);
            }
            $startTimesArray[$x] = $insideArray;
        }

        return $startTimesArray;
    }

    //this is my magic function fo iteration and chek

    function permutationOfMultidimensionalArray(array $anArray, $breakTimeInSeconds, $firstBreakStartTime, $lastBreakEndTime, $breakTimeMinutes) {

        // Quick exit
        if (empty($anArray)) {
            return 0;
        }
        // Amount of possible permutations: count(a[0]) * count(a[1]) * ... * count(a[N])
        $permutationCount = 1;
        // Store informations about every row of matrix: count and cumulativeCount
        $matrixInfo = array();
        $cumulativeCount = 1;

        foreach ($anArray as $aRow) {

            $rowCount = count($aRow);
            $permutationCount *= $rowCount;
            // this save a lot of time!
            $matrixInfo[] = array(
                'count' => $rowCount,
                'cumulativeCount' => $cumulativeCount
            );
            $cumulativeCount *= $rowCount;
        }
        $cumulativeCount *= $rowCount;

        /* just my junk here. can delete anytime
          foreach ($matrixInfo as $mi) {
          echo "COUNT :" . $mi["count"];
          echo " CUMULATIVE COUNT :" . $mi["cumulativeCount"];
          echo "<br>";
          }
          echo "PERMUTATION COUNT:" . $permutationCount;
          echo "<hr><hr>";
         */

        // Save the array keys
        $arrayKeys = array_keys($anArray);
        // It needs numeric index to work
        $matrix = array_values($anArray);

        // Number of row
        $rowCount = count($matrix);
        // Number of valid permutation
        $validPermutationCount = 0;
        // Contain all permutations
        $permutations = array();

        // Iterate through all permutation numbers
        for ($currentPermutation = 0; $currentPermutation < $permutationCount; $currentPermutation++) {

            for ($currentRowIndex = 0; $currentRowIndex < $rowCount; $currentRowIndex++) {

                // Here the magic!
                // I = int(P / (Count(c[K-1]) * ... * Count(c[0]))) % Count(c[K])
                // where:
                // I: the current Row index
                // P: the current permutation number
                // c[]: array of the current Row
                // K: number of the current Row
                $index = intval($currentPermutation / $matrixInfo[$currentRowIndex]['cumulativeCount']) % $matrixInfo[$currentRowIndex]['count'];

                //and this is my Magic
                $breakStartTime = $matrix[$currentRowIndex][$index];

                if (!$this->breakStartTimeValid($breakStartTime, $breakTimeInSeconds)) {
                    unset($permutations[$currentPermutation]);
                    $dispatcher = false;
                    $this->breaksPool = array(); //here i just empty the breaksPool, not initializing
                    break;
                }
                array_push($this->breaksPool, $breakStartTime);

                $dispatcher = true;
                // Save Row into current permutation
                $permutations[$currentPermutation][$currentRowIndex] = $breakStartTime;
            }

            // Restore array keys
            if ($dispatcher == true && count($arrayKeys) == count($permutations[$currentPermutation])) {
                $validPermutationCount++;

                echo "ვარიანტის ნომერი: $validPermutationCount. ";
                echo "შესვენებების ფარგლები: $firstBreakStartTime -- $lastBreakEndTime. ";
                echo "შესვენების ხანგრძლივობა: $breakTimeMinutes წუთი";
                $permutations[$currentPermutation] = array_combine($arrayKeys, $permutations[$currentPermutation]);
                $this->breaksPool = array(); //here i just empty the breaksPool, not initializing
                //-----------

                $exoduses = array();

                for ($x = 0; $x < count($permutations[$currentPermutation]); $x++) {

                    $breakStartTime = $permutations[$currentPermutation][$x];

                    $exodus = new Exodus($this->ignitionSequence[$x], $this->lastTripStartTime, $this->abTripTimeMinutes, $this->abTripTimeSeconds, $this->baTripTimeMinutes, $this->baTripTimeSeconds);
                    $tripPeriodsWithBreak = $exodus->getTripPeriodsWithBreak($breakStartTime, $breakTimeInSeconds);

                    array_push($exoduses, $tripPeriodsWithBreak);
                }


                include 'Model/RouteGraphical.php';
            }



            // Save memory!!
            // Use $isValidCallback to check permutation, store into DB, etc..
            // *** Comment this line if you want that function return all
            //     permutation. Memory warning!!
            unset($permutations[$currentPermutation]);
        }



        return $validPermutationCount;
    }

    private function breakStartTimeValid($breakStartTime, $breakTimeInSeconds) {
        $breakEndTime = $breakStartTime + $breakTimeInSeconds;
        foreach ($this->breaksPool as $poolBreakStartTime) {
            $poolBreakEndTime = $poolBreakStartTime + $breakTimeInSeconds;
            if ($breakStartTime == $poolBreakStartTime) {
                return false;
            }
            if ($breakStartTime > $poolBreakStartTime && $breakStartTime < $poolBreakEndTime) {
                return false;
            }
            if ($breakEndTime > $poolBreakStartTime && $breakEndTime < $poolBreakEndTime) {
                return false;
            }
        }


        return true;
    }

}
