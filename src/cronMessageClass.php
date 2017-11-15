<?php
require_once 'configClass.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cronMessageClass
 *
 * @author olaf
 */
class cronMessageClass
{
    private $config;
    private $filePath;
    public function __construct(configClass $config, $filePath)
    {
        $this->config = $config;
        $this->filePath = $filePath; 
    }
    
    public function sendEmailOnError($message)
    {
        mail($this->config->get_liveSendEmailAddress(), $this->get_subjectString(), $this->get_message($message));
    }
    
    public function sendSmsOnError()
    {
        ;
    }
    
    private function get_message($message)
    {
        return$this->get_firstLine() . "\nMessage from File:\n".$message;
    }
    
    private function get_firstLine()
    {
        $firstLine  = "\n";
        $firstLine .= "\nServer-IP : \t" . $this->config->get_serverIP();
        $firstLine .= "\nServer-Name : \t" . $this->config->get_serverName();
        $firstLine .= "\nPath to Lock-Folder : \t" . $this->config->get_pathToLockFolder();
        $firstLine .= "\nPath to Log-File-Folder : \t" . $this->config->get_pathToLogFileFolder();
        return $firstLine;
    }
    
    private function get_subjectString($pre = "ERROR ON - ")
    {
        return $pre . " ( ".$this->config->get_serverName()." ) " . $this->extractFileNameFromPath($this->filePath);     
    }
    
    private function extractFileNameFromPath($path)
    {
        $pathArray = explode('/', $path);
        return $pathArray[count($pathArray) -1];
    }
}

?>
