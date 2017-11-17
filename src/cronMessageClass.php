<?php

  require_once 'configClass.php';

  /**
   * Description of cronMessageClass
   *
   * @author mainvoid007
   */
  class cronMessageClass
  {

      private $config;
      private $filePath;

      /**
       * 
       * @param configClass $config
       * @param type $filePath
       */
      public function __construct ( configClass $config, $filePath ) {
          $this->config = $config;
          $this->filePath = $filePath;
      }

      public function sendEmailOnError ( $message ) {
          mail ( $this->config->adminEmail, $this->get_subjectString (), $this->get_message ( $message ) );
      }

      public function sendSmsOnError () {
          ;
      }

      /**
       * 
       * @param type $message
       * @return type
       */
      private function get_message ( $message ) {
          return$this->get_firstLine () . "\nMessage from File:\n" . $message;
      }

      /**
       * 
       * @return string
       */
      private function get_firstLine () {
          $firstLine = "\n";
          $firstLine .= "\nServer-IP : \t" . $this->config->serverIP;
          $firstLine .= "\nServer-Name : \t" . $this->config->serverName;
          $firstLine .= "\nPath to Lock-Folder : \t" . $this->config->pathToLockFolder;
          $firstLine .= "\nPath to Log-File-Folder : \t" . $this->config->pathToLogFileFolder;
          return $firstLine;
      }

      /**
       * 
       * @param type $pre
       * @return type
       */
      private function get_subjectString ( $pre = "ERROR ON - " ) {
          return $pre . " ( " . $this->config->serverName . " ) " . $this->extractFileNameFromPath ( $this->filePath );
      }

      /**
       * 
       * @param type $path
       * @return type
       */
      private function extractFileNameFromPath ( $path ) {
          $pathArray = explode ( '/', $path );
          return $pathArray[ count ( $pathArray ) - 1 ];
      }

  }

?>
