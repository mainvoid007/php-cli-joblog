<?php

  /**
   * Description of fileHandler
   *
   * @author mainvoid007
   */
  require_once 'configClass.php';
  date_default_timezone_set ( 'Europe/Berlin' );

  class fileHandler
  {

      private $handler;
      private $pathToLogFileFolder;
      private $fileNameWithoutExtension;
      private $logFileName;
      private $config;

      /**
       * 
       * @param configClass $config
       */
      public function __construct ( configClass $config ) {
          $this->config = $config;
          $this->pathToLogFileFolder = $this->config->get_pathToLogFileFolder ();
          $this->fileNameWithoutExtension = $this->config->get_fileNameWithoutExtension ();
          $this->createHandler ();
      }

      protected function createHandler () {
          $dir = $this->pathToLogFileFolder . "/" . $this->fileNameWithoutExtension;
          if ( ! is_dir ( $dir ) ){
               mkdir ( $dir );
          }
          $this->logFileName = "log_" . date ( 'd_m_Y', time () ) . ".txt";
          $this->handler = fopen ( $dir . "/" . $this->logFileName, 'a+' );
      }

      public function write ( $message ) {
          fwrite ( $this->handler, $message );
      }

      public function __destruct () {
          fclose ( $this->handler );
      }

  }

?>
