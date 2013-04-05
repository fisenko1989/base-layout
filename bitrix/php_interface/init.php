<?php
require_once(dirname(__FILE__)."/include/functions.php");
require_once(dirname(__FILE__)."/include/eventHandlers.php");
require_once(dirname(__FILE__)."/include/customIblockProps.php");
require_once(dirname(__FILE__)."/include/customUserProps.php");
require_once(dirname(__FILE__)."/include/lessc.inc.php");

define("LESS_PATH", $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH."/less/styles.less");
define("LESS_COMPILED_PATH", $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH."/template_styles.css");

function autoCompileLess($inputFile, $outputFile) {
    
    if(!file_exists($inputFile)){
        return false;
    }
    
    $cacheFile = $inputFile.".cache";

    if (file_exists($cacheFile)) {
        $cache = unserialize(file_get_contents($cacheFile));
    } 
    else {
        $cache = $inputFile;
    }

    $less = new lessc();
    $newCache = $less->cachedCompile($cache);

    if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
        file_put_contents($cacheFile, serialize($newCache));
        file_put_contents($outputFile, $newCache['compiled']);
    }
}

autoCompileLess(LESS_PATH, LESS_COMPILED_PATH);

// Класс для работы с изображениями
require_once('classes/class.upload.php');