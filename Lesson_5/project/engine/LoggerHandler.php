<?php


namespace app\engine;
use app\traits\TSingletone;


class LoggerHandler
{
    private $fileHandlerInfo;
    private $fileHandlerError;

    use TSingletone;

    protected function __construct() {
        $this->fileHandlerInfo = fopen('../log/info.log', 'a');
        $this->fileHandlerError = fopen('../log/error.log', 'a');
    }

    public function writeLog(string $message, string $level): void
    {
        $lev = 'fileHandler' . $level;
        $date = date('Y-m-d H:i:s');
        fwrite($this->$lev, "$date: $message\n");
    }

    public static function logInfo(string $message): void
    {
        $logger = static::getInstance();
        $logger->writeLog($message . '. Выделено памяти - ' . memory_get_usage(), 'Info');
    }

    public static function logError(string $message): void
    {
        $logger = static::getInstance();
        $logger->writeLog($message . '. Выделено памяти - ' . memory_get_usage(), 'Error');
    }
}