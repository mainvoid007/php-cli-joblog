<?php

/**
 * Description of configClass
 *
 * @author mainvoid007
 */
class configClass {

    private $fileName;
    private $fileNameWithoutExtension;

    /**
     * 
     * @param String $cronjobNamePath
     */
    public function __construct($cronjobNamePath) {
        $this->set_Names($cronjobNamePath);
        $this->ini = parse_ini_file(__DIR__ . "/config/cronLogConfig.ini");
        foreach ($this->ini as $var => $value) {
            $this->$var = $value;
        }
    }

    /**
     * 
     * @param type $cronjobNamePath
     */
    private function set_Names($cronjobNamePath) {
        $pathArray = explode('/', $cronjobNamePath);
        $this->fileName = $pathArray[count($pathArray) - 1];

        $nameArray = explode('.', $this->fileName);
        $this->fileNameWithoutExtension = $nameArray[0];
    }

    /**
     * 
     * @param type $prop
     * @return type
     * @throws Exception
     */
    public function __get($prop){
        try {
            if($this->$prop !== NULL){
                return $this->$prop;
            } else {
                throw new Exception(
                    "\nError on calling: {$prop} field or method"
                  . " is not available in ".get_Class($this)."\n");
            }
        }
        catch(Exception $e){
            echo $e->getMessage() .  "Error on line " . $e->getLine() ."\n";
            print_r($e->getTrace());
        }
    }
    
    /*
    public function __set($prop, $value){
        $this->$prop = $value;
    }
    */
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        foreach($this->ini as $key => $value){
           switch ($value){
               case '':
                   $value = "FALSE";
                   break;
               case '1':
                   $value = "TRUE";
                   break;
               default:
                   $value = $value;
           }
            $s .= $key . "\t-->\t" . $value." \n";
        }
        return $s;
    }
}
    
?>
