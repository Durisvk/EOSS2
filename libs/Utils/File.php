<?php

    namespace Utils;

    /**
     * Helper for manipulation with Files.
     * Class File
     * @package Utils
     */
    class File {

        /**
         * Returns the line number of searched keyword/s in file.
         * Used for debugging.
         * @param string $search
         * @param string $file
         * @return int|null
         * @throws \Exception
         */
        public static function getLine($search,$file) {
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
                throw new \Exception("Invalid file or line.");
            }
        }

    }

?>