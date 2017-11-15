<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fileHandler
 *
 * @author olaf
 */

require_once 'configClass.php';
date_default_timezone_set('Europe/Berlin');
class fileHandler 
{
    private $handler;
    private $pathToLogFileFolder;
    private $fileNameWithoutExtension;
    private $logFileName;
    private $config;
    
    public function __construct(configClass $config)
    {
        $this->config = $config;
        $this->pathToLogFileFolder = $this->config->get_pathToLogFileFolder();
        $this->fileNameWithoutExtension = $this->config->get_fileNameWithoutExtension();
        $this->createHandler();
    }

    protected function createHandler()
    {
        if(! is_dir($this->pathToLogFileFolder."/".$this->fileNameWithoutExtension))
            mkdir($this->pathToLogFileFolder."/".$this->fileNameWithoutExtension);
        $this->logFileName = "log_".date('d_m_Y', time()) .".txt";
        $this->handler = fopen($this->pathToLogFileFolder."/".$this->fileNameWithoutExtension."/".$this->logFileName, 'a+');
    }

    public function write($message)
    {
        fwrite($this->handler, $message);
    }   
    
    public function __destruct()
    {
         fclose($this->handler);
    }
}

?>
