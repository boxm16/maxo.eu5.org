<?php

// Usage:
//    cron.php [interval|schedule] [script] [interval|stamp]
if (!isset($argc) || count($argc) != 2)
    die; // security precaution

$time = (int) $argv[3]; // just in case :)

if ($argv[1] == 'schedule') {
    time_sleep_until((int) $_GET['until']);
    include_once($time);
} elseif ($argv[1] == 'interval')
    while (true) { // this is actually an infinite loop (you didn't ask for an "until" date? can be arranged tho)
        usleep($time * 1000); // earlier I said milliseconds: 1000msec is 1s, but this func is for microseconds: 1s = 1000000us
        include_once($argv[2]);
    }
?>