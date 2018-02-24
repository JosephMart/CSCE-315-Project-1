<?php
/*****************************************
** File:    logger.php
** Project: CSCE 315 Project 1, Spring 2018
**
** This file contains the main logger functionality.
** Logs to /home/ugrads/FIRST_LETTER/NET_ID/web_project/log/log_d_M_Y.log
**
***********************************************/

class Logger
{
    //-------------------------------------------------------
    // Name: __construct
    // PreCondition:  None
    // PostCondition: None
    //---------------------------------------------------------
    public function __construct()
    {
        $logDirectory = '/home/ugrads/j/josephmart/web_project/log';
        date_default_timezone_set('America/Chicago');
        $logDirectory = rtrim($logDirectory, DIRECTORY_SEPARATOR);
        $this->logFilename = '/log_' . date('d-M-Y') . '.log';
        $this->logFilePath = $logDirectory . $this->logFilename;

        if (!file_exists($logDirectory)) {
            mkdir($logDirectory, 777, true);
        }
    }

    //-------------------------------------------------------
    // Name: info
    // PreCondition:  None
    // PostCondition: None
    //---------------------------------------------------------
    public function info($log) {
        $date = $this->getDate();
        $msg = $date . ' [INFO] ' . $log;
        $this->write($msg);
    }

    //-------------------------------------------------------
    // Name: error
    // PreCondition:  None
    // PostCondition: None
    //---------------------------------------------------------
    public function error($log) {
        $date = $this->getDate();
        $msg = $date . ' [ERROR] ' . $log;
        $this->write($msg);
    }

    //-------------------------------------------------------
    // Name: getDate
    // PreCondition:  None
    // PostCondition: None
    //---------------------------------------------------------
    private function getDate() {
        $originalTime = microtime(true);
        $micro = sprintf("%06d", ($originalTime - floor($originalTime)) * 1000000);
        return date('Y-m-d H:i:s.'.$micro, $originalTime);
    }

    //-------------------------------------------------------
    // Name: write
    // PreCondition:  Log file has been created
    // PostCondition: None
    //---------------------------------------------------------
    private function write($msg) {
        file_put_contents($this->logFilePath, $msg . "\n", FILE_APPEND);
    }
}
?>