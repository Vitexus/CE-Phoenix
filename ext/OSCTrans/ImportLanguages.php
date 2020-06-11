<?php

chdir('../../');
require 'includes/application_top.php';

class ImportLanguages {

    /**
     * Source Shop catalog location
     * @var string path 
     */
    public $oscLocation = '';

    /**
     * Destination
     * @var string Phoenix Sources dir 
     */
    public $phxLocation = '';

    /**
     * We work with this files
     * @var array translation files
     */
    protected $translationsList = [];

    /**
     * get candidates list from
     * @var string language dir name  
     */
    public $initialLanguage = 'english';

    /**
     * 
     * @param array $importLanguages
     */
    public function __construct($osc , $importLanguages = []) {
        $this->oscLocation = $osc;
        $this->phxLocation = dirname(dirname(__DIR__));
        $this->translationsList = $this->translationFiles($this->phxLocation . '/includes/languages/' . $this->initialLanguage);
        foreach ($importLanguages as $lng) {
            $this->importLanguage($lng);
        }
    }

    public function translationFiles($dest) {
        return self::scanAllDir($dest);
    }

    public function importLanguage($lng) {
        $srcDir = $this->oscLocation . '/includes/languages/' . $lng;
        $candidates = $this->translationFiles($srcDir);
        $destDir = $this->phxLocation . '/includes/languages/' . $lng;
        if (!file_exists($destDir)) {
            mkdir($destDir);
        }
        
        if(file_exists($srcDir.'.php') && !file_exists($destDir.'.php')){
            copy($srcDir.'.php', $destDir.'.php');
        }
        
        foreach ($this->translationsList as $weWant) {
            $srcFile = $srcDir . '/' . $weWant;
            $destFile = $destDir . '/' . $weWant;

            if (is_dir(dirname($srcFile)) && !is_dir(dirname($destFile)) ) {
                if(!mkdir(dirname($destFile), 0777, true)){
                   echo 'cannot mkdir  ' . dirname($destFile);
                }
            }

            if (array_key_exists($weWant, $candidates)) {
                if (file_exists($destFile)) {
                    echo '  :O';
                } else {
                    if (copy($srcFile, $destFile)) {
                        echo ' :)';
                    } else {
                        echo ' :/';
                    }
                }
            } else {
                echo ':( ';
            }
            echo ' ' . $weWant . " \n<br>";
        }
    }

    public static function scanAllDir($dir) {
        $result = [];
        foreach (scandir($dir) as $filename) {
            if ($filename[0] === '.')
                continue;
            $filePath = $dir . '/' . $filename;
            if (is_dir($filePath)) {
                foreach (self::scanAllDir($filePath) as $childFilename) {
                    $result[$filename . '/' . $childFilename] = $filename . '/' . $childFilename;
                }
            } else {
                $result[$filename] = $filename;
            }
        }
        return $result;
    }

}

//(new ImportLanguages('/home/vitex/Projects/PureHTML/yin20/WWW/osc/catalog',['czech', 'german', 'french']));
