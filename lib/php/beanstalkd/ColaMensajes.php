<?php

class ColaMensajes {

    private $pheanstalk;
    private $tubeName;

    function __construct($tube) {
        $dir = dirname(__FILE__);
        require_once($dir . '/pheanstalk_init.php');
        $this->pheanstalk = new Pheanstalk('127.0.0.1');
        $this->pheanstalk->useTube($tube);
        $this->tubeName = $tube;
    }

    function push($data, $priority = 1024, $delay = 0, $ttr = 4000) {
        try {
            return $this->pheanstalk->put($data, $priority, $delay, $ttr);
        } catch (Exception $e) {
            return -1;
        }
    }

    function pop($timeout = 300) {
        try {
            $job = $this->pheanstalk->reserveFromTube($this->tubeName, $timeout);
            return $job;
        } catch (Exception $e) {
            return null;
        }
    }

    function deleteJob($job) {
        try {
            $this->pheanstalk->delete($job);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function printStats() {
        try {
            $this->pheanstalk->printTubeStats($this->tubeName);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

?>