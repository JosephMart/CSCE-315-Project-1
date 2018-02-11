<?php

class Logger
{
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

    public function info($log) {
        $date = $this->getDate();
        $msg = $date . ' [INFO] ' . $log;
        $this->write($msg);
    }

    public function error($log) {
        $date = $this->getDate();
        $msg = $date . ' [ERROR] ' . $log;
        $this->write($msg);
    }

    private function getDate() {
        $originalTime = microtime(true);
        $micro = sprintf("%06d", ($originalTime - floor($originalTime)) * 1000000);
        return date('Y-m-d H:i:s.'.$micro, $originalTime);
    }

    private function write($msg) {
        file_put_contents($this->logFilePath, $msg . "\n", FILE_APPEND);
    }
} // ends class, NEEDED!!
?>