<?php
namespace Utilities;

class FileUtilities {
    // function to get a list of files in a directory
    public static function GetFileList($dir) {
        // scandir gives all files and directories
        // process to get just the files
        $files = array();
        foreach(scandir($dir) as $file) {
            if (is_file($dir . $file)) {
                $files[] = $file;
            }
        }

        return $files;
    }

    // function to return all contents of a file
    public static function GetFileContents($file) {
        return file_get_contents($file) ? file_get_contents($file) : '';
    }

    // function to create/update all file contents
    public static function WriteFile($file, $content) {
        $wFile = fopen($file, 'w');
        fwrite($wFile, $content);
        fclose($wFile);
    }
}