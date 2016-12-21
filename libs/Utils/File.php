<?php

    namespace Utils;

    /**
     * Helper for manipulation with Files.
     *
     * @author Juraj Čarnogurský
     * Class File
     * @package Utils
     */
    class File {

        /**
         * Returns the line number of searched keyword/s in file.
         * Used for debugging.
         * @param string $search
         * @param string|array $file
         * @return int|null
         * @throws \Exception
         */
        public static function getLine($search,$file) {
            if(!is_array($file) && is_string($file)) {
                $file = explode("\n", $file);
            }
            $line_number = NULL;
            for ($i=0; $i<count($file);$i++) {
                $line=$file[$i];
                if (strpos($line, $search)!==FALSE) {
                    $line_number=$i;
                }
            }
            if($line_number) {
                return $line_number;
            } else {
                throw new \InvalidArgumentException("Invalid file or line.");
            }
        }

        /**
         * Saves the file.
         * @param string $filename
         * @param string $content
         * @throws \Exception
         */
        public static function save($filename, $content) {
            $fp = fopen($filename, "w");
            if(!$fp) {
                throw new \Exception("Failed to open the file.");
            }
            fwrite($fp, $content);
            fclose($fp);
        }


    }

?>