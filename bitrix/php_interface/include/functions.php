<?php
require_once( dirname(__FILE__)."/mobile_device_detect.php");

function setPageClass($class){
    global $APPLICATION;
    $APPLICATION->SetPageProperty("page_class", $class);
}
function getPageClass($class){
    global $APPLICATION;
    $APPLICATION->GetPageProperty("page_class");
}

function isHome(){
    global $APPLICATION;
    return $APPLICATION->GetCurPage() == SITE_DIR ? true : false;
}

function vd($data){
    global $USER;
    if($USER->IsAdmin()){
        echo "<pre>"; var_dump($data); echo "</pre>";
    }
}

function pr($data){
    global $USER;
    if($USER->IsAdmin()){
        echo "<pre>"; print_r($data); echo "</pre>";
    }
}

function isAjax(){
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true: false;
}

function isMobile(){
    return mobile_device_detect();
}

function declOfNum($number, $titles) {
    $cases = array (2, 0, 1, 1, 1, 2);
    return $titles[($number % 100 > 4 && $number % 100 < 20)? 2 : $cases[min($number % 10, 5)]];
}

function toTranslit($text, $replace_space = "-", $replace_other = "-"){
    return CUtil::translit($text, "ru", array("replace_space"=>$replace_space,"replace_other"=>$replace_other));
}

function setContent($name, $content){
    $APPLICATION->AddViewContent($name, $content);
}

// отложенная функция, содержимое выводится после полной 
// буферизации вывода
function showContent($name) {
    $APPLICATION->ShowViewContent($name);
}

function setFlash($text){
    if(strlen(trim($text)) > 0){
        session_start();
        $_SESSION['flash_message'] = trim($text);
        return true;
    }
    return false;
}

function showFlash($class = null, $template = null){
    
    $class = is_null($class) ? "" : $class;
    $template = is_null($template) ? "<div class='flash_message #class#'>#message</div>" : $template;
    
    session_start();
    if(is_string($_SESSION['flash_message']) && strlen(trim($_SESSION['flash_message'])) > 0){
        $search = array(
            "#class#",
            "#message"
        );
        $replace = array(
            $class,
            trim($_SESSION['flash_message'])
        );
        echo str_replace($search, $replace, $template);
        unset($_SESSION['flash_message']);
    }
}

function getFlash(){
    session_start();
    return is_string($_SESSION['flash_message']) && strlen(trim($_SESSION['flash_message'])) > 0 ?
                trim($_SESSION['flash_message']) : false;
}