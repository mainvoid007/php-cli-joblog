<?php

/**
 * Description of configClass
 *
 * @author mainvoid007
 */
class configClass {

    private $serverName;
    private $serverIP;
    private $adminEmail;
    //private $adminTel;
    private $liveSendEmailAddress;
    //private $liveSendSmsAddress;
    private $pathToLockFolder;
    //private $logToMonitor;
    private $logToConsole;
    private $logToFile;
    //private $logToDatabase;
    private $log;
    private $pathToLogFileFolder;
    private $liveSendEmailOnError;
    private $fileName;
    private $fileNameWithoutExtension;

    public function __construct($cronjobNamePath) {
        $this->set_Names($cronjobNamePath);
        $ini = parse_ini_file(__DIR__ . "/config/cronLogConfig.ini");
        foreach ($ini as $var => $value) {
            $this->$var = $value;
        }
    }

    private function set_Names($cronjobNamePath) {
        $pathArray = explode('/', $cronjobNamePath);
        $this->fileName = $pathArray[count($pathArray) - 1];

        $nameArray = explode('.', $this->fileName);
        $this->fileNameWithoutExtension = $nameArray[0];
    }

    public function get_fileName() {
        return $this->fileName;
    }

    public function get_fileNameWithoutExtension() {
        return $this->fileNameWithoutExtension;
    }

    public function is_liveSendEmailOnError() {
        return $this->liveSendEmailOnError;
    }

    public function get_serverName() {
        return $this->serverName;
    }

    public function get_serverIP() {
        return $this->serverIP;
    }

    public function get_adminEmail() {
        return $this->adminEmail;
    }

    public function get_liveSendEmailAddress() {
        return $this->liveSendEmailAddress;
    }

    public function get_pathToLockFolder() {
        return $this->pathToLockFolder;
    }

    public function is_logToConsole() {
        return $this->logToConsole;
    }

    public function is_logToFile() {
        return $this->logToFile;
    }

    public function get_log() {
        return $this->log;
    }

    public function get_pathToLogFileFolder() {
        return $this->pathToLogFileFolder;
    }

}

?>
