<?php

namespace skintools\utils;

use pocketmine\entity\Human;
use skintools\SkinTools;

class SkinConverter{
    /**
     * Converts a human's skin to slim(32x64) if $slim is true, if $slim is false it will convert to non-slim(64x64)
     * @param Human $human
     * @param bool $slim
     */
    public static function setSlim(Human $human, $slim = true){
        $human->setSkin($human->getSkinData(), $slim);
    }
    /**
     * Compresses skin data, for efficient storage
     * @param string $data
     * @param int $level
     * @return string
     */
    public static function compress($data, $level = 9){
        return zlib_encode($data, ZLIB_ENCODING_DEFLATE, $level);
    }
    /**
     * Decompresses skin data, prepares it for usage in the plugin
     * @param string $data
     * @return string
     */
    public static function decompress($data){
        return zlib_decode($data);
    }
    /**
     * Checks if the data/image file for a human/player exists
     * @param Human $human
     * @param bool $isData
     * @return bool
     */
    public static function isFileCreated(Human $human, $isData = true){
        return file_exists(SkinTools::getInstance()->getDataFolder().($isData ? "data" : "images")."/".strtolower($human->getName()).($isData ? ".dat" : ".png"));
    }
    /**
     * Retrieves skin data from a file previously created
     * @param Human $human
     * @return string|bool
     */
    public static function fromFile(Human $human){
        if(self::isFileCreated($human)){
            return self::decompress(file_get_contents(SkinTools::getInstance()->getDataFolder()."data/".strtolower($human->getName()).".dat"));
        }
        return false;
    }
    /**
     * Creates a new file containing skin data
     * @param Human $human
     */
    public static function toFile(Human $human){
        @mkdir(SkinTools::getInstance()->getDataFolder()."data/");
        file_put_contents(SkinTools::getInstance()->getDataFolder()."data/".strtolower($human->getName()).".dat", self::compress($human->getSkinData()));
    }
    /**
     * Converts an image file back into skin data
     * @param Human $human
     * @return string
     */
    public static function fromImage(Human $human){
        //TODO: Work on image-to-data conversion
    }
    /**
     * Converts skin data into an image file
     * @param Human $human
     */
    public static function toImage(Human $human){
        if(extension_loaded("gd")){
            //TODO: Work on data-to-image conversion
        }
        else{
            SkinTools::getInstance()->getServer()->getLogger()->critical("Failed to create image from skin data, PHP extension \"GD\" wasn't found.");
        }
    }
}