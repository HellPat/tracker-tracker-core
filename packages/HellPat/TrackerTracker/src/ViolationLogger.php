<?php


namespace HellPat\TrackerTracker;


interface ViolationLogger
{
    /**
     * @param string $violation the JSON-Representation of the violation as posted by the browser
     */
    public function log(string $violation);
}