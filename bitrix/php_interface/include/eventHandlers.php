<?php

/** DEFINE section***********************/
// sample
//define('BANNERS_IBLOCK_ID', '8');

/****************************************/
/*
AddEventHandler("iblock", "OnBeforeIBlockPropertyAdd", 
                array("customEventsHandler", "OnBeforeIBlockPropertyAddHandler"));
                
AddEventHandler("iblock", "OnBeforeIBlockPropertyUpdate", 
                array("customEventsHandler", "OnBeforeIBlockPropertyUpdateHandler"));

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", 
                array("customEventsHandler", "OnBeforeIBlockElementAddHandler"));
                
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", 
                array("customEventsHandler", "OnBeforeIBlockElementUpdateHandler"));

AddEventHandler("main", "OnEpilog", 
                array("customEventsHandler", "OnEpilogHandler"));
*/

class customEventsHandler {
    function OnBeforeIBlockPropertyAddHandler(&$arFields){
        
    }
    
    function OnBeforeIBlockPropertyUpdateHandler(&$arFields){
        
    }
    
    function OnBeforeIBlockElementAddHandler(&$arFields){
        
    }
    
    function OnBeforeIBlockElementUpdateHandler(&$arFields){
        
    }
    
    function OnEpilogHandler() {
        global $APPLICATION;
        if( 
            !defined('ADMIN_SECTION') &&  
            defined("ERROR_404") &&  
            file_exists($_SERVER["DOCUMENT_ROOT"]."/404.php") 
        ) {
            $APPLICATION->RestartBuffer();
            include $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/404/header.php';
            include $_SERVER['DOCUMENT_ROOT'].'/404.php';
            include $_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/404/footer.php';
            // если нужна именно переадресация
            // LocalRedirect('/404.php');
        }
    }
}