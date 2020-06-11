<?php

chdir('../../');
require 'includes/application_top.php';

class ImportLanguages {

    /**
     * Source Shop catalog location
     * @var string path 
     */
    public $oscLocation = '/home/vitex/Projects/PureHTML/yin20/WWW/osc/catalog';

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
    public function __construct($importLanguages = []) {
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
        $destDir = $this->phxLocation.'/includes/languages/'.$lng;
        if(!file_exists($destDir)){
            mkdir($destDir);
        }
        foreach ($this->translationsList as $weWant) {
            $trfile = $destDir.'/' . $weWant;
            if (array_key_exists(  $weWant, $candidates)) {
                if(file_exists( $trfile )){
                    echo $weWant . '  :O';
                } else {
                    if(copy($srcDir.'/'.$weWant, $trfile)) {
                        echo $weWant . ' :)';
                    } else {
                        echo $weWant . ' :/';
                    }
                }
            } else {
                echo $weWant . ':( ';
            }
            echo "\n<br>";
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

(new ImportLanguages(['czech', 'german', 'fracois']));
