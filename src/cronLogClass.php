<?php

/**
 * Description of cronLogClass
 *
 * @author mainvoid007
 */
require_once 'configClass.php';
require_once 'cronLockClass.php';
require_once 'cronMessageClass.php';
require_once 'fileHandler.php';

class cronLogClass {

    private $filePath;
    private $config;
    private $debug;
    private $lock;
    private $messenger;
    private $logfile;

    /**
     * 
     * @param type $pathToCronjob
     * @param type $debug
     */
    public function __construct($pathToCronjob, $debug = FALSE) {
        $this->debug = $debug;
        $this->filePath = $pathToCronjob;
        $this->config = new configClass($pathToCronjob);
        $this->setMessenger();
        $this->setLock();
    }

    public function get_config() {
        return $this->config;
    }

    private function setMessenger() {
        if ($this->debug != TRUE) {
            $this->messenger = new cronMessageClass($this->config, $this->filePath);
        }
    }

    public function setLock() {
        If ($this->debug != TRUE) {
            $this->lock = new cronLockClass($this->config, $this->messenger);
        }
    }

    /**
     * 
     * @param type $message
     * @param type $type
     */
    public function log($message, $type = 'debug') {
        if ($this->debug == FALSE && $type == 'error')
            $this->messenger->sendEmailOnError($message);
        
        if ($this->config->is_logToConsole() == TRUE || $this->debug == TRUE)
            $this->logToConsole($type, $message);

        if ($this->config->is_logToFile() == TRUE && $this->debug == FALSE)
            $this->logToFile($type, $message);
    }

    /**
     * 
     * @param type $type
     * @param type $message
     */
    public function logToMonitor($type, $message) {
        echo "\nMonitor-> " . date('H:i:s', time()) . " --> ['" . $type . "'] " . $message . "\n";
    }

    /**
     * 
     * @param type $type
     * @param type $message
     */
    public function logToFile($type, $message) {
        if (!$this->logfile instanceof fileHandler) {
            $this->logfile = new fileHandler($this->config);
        }
        $this->logfile->write(date('H:i:s', time()) . " --> ['" . $type . "'] " . $message . "\n");
    }

    /**
     * 
     * @param type $type
     * @param type $message
     */
    public function logToDatabase($type, $message) {
        echo "\nFile-> " . date('H:i:s', time()) . " --> ['" . $type . "'] " . $message . "\n";
    }

    /**
     * 
     * @param type $type
     * @param type $message
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function logToConsole($type, $message) {
        if (! defined('STDOUT')) {
            return false;
        }
        $typeMap = array(
            'debug' => array(36, '- debug -'),
            'info' => array(37, '- info  -'),
            'error' => array(31, '- error -'),
            0 => array(31, '- error -'),
            'ok' => array(32, '- success -'),
            1 => array(32, '- success -')
        );

        if (! array_key_exists($type, $typeMap))
            throw new \InvalidArgumentException(' $type parameter must be debug, info, error or success. Got ' . $type);


        $time = date('d.m.y - H:i:s', time()) . " ";
        fwrite(STDOUT, $time . "\033[" . $typeMap[$type][0] . "m" . $typeMap[$type][1] . "\033[37m  " . $message . "\r\n");
    }

}

?>
