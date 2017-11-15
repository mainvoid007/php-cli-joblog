<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cronLockClass
 *
 * @author olaf
 */
class cronLockClass {

    private $lockPath;
    private $lockPathFile;
    private $lockTime;
    private $messenger;
    private $fileName;
    private $config;

    public function __construct(configClass $config, $messenger) {
        $this->config = $config;
        $this->lockPath = $config->get_pathToLockFolder();
        $this->fileName = $this->config->get_fileNameWithoutExtension() . ".lock";
        $this->lockPathFile = $this->lockPath . "/" . $this->fileName;
        $this->lockTime = time();
        $this->messenger = $messenger;
        $this->toggleLock();

        if ($this->getLock() === TRUE)
            exit('ABBRUCH LOCK VORHANDEN');     //  TODO: Nachricht senden
        else
            $this->createLock();
    }

    public function __destruct() {
        $temp = file($this->lockPathFile);
        if ($temp[0] == $this->lockTime) {
            $this->destroyLock();
        }
    }

    private function createLock() {
        $handle = fopen($this->lockPathFile, "w+");
        fwrite($handle, $this->lockTime);
        fclose($handle);
        $this->toggleLock();
    }

    private function destroyLock() {
        unlink($this->lockPathFile);
        $this->toggleLock();
    }

    private function toggleLock() {
        if (is_file($this->lockPathFile)) {
            if ($this->checkLockTime() === TRUE) {
                $this->destroyLock();
            } else {
                $this->lock = TRUE;
            }
        } else {
            $this->lock = FALSE;
        }
    }

    private function getLock() {
        return $this->lock;
    }

    private function checkLockTime() {
        if (filemtime($this->lockPathFile) + $this->lockTime * 60 < time()) {
            return TRUE;
        }
        return FALSE;
    }

}

?>
