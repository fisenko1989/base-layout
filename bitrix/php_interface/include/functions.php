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

function decode_entities_full($string, $quotes = ENT_COMPAT, $charset = 'cp1251') {
    return html_entity_decode(preg_replace_callback('/&([a-zA-Z][a-zA-Z0-9]+);/', 'convert_entity', $string), $quotes, $charset); 
}

function convert_entity($matches, $destroy = true) {
    static $table = array('quot' => '&#34;','amp' => '&#38;','lt' => '&#60;','gt' => '&#62;','OElig' => '&#338;','oelig' => '&#339;','Scaron' => '&#352;','scaron' => '&#353;','Yuml' => '&#376;','circ' => '&#710;','tilde' => '&#732;','ensp' => '&#8194;','emsp' => '&#8195;','thinsp' => '&#8201;','zwnj' => '&#8204;','zwj' => '&#8205;','lrm' => '&#8206;','rlm' => '&#8207;','ndash' => '&#8211;','mdash' => '&#8212;','lsquo' => '&#8216;','rsquo' => '&#8217;','sbquo' => '&#8218;','ldquo' => '&#8220;','rdquo' => '&#8221;','bdquo' => '&#8222;','dagger' => '&#8224;','Dagger' => '&#8225;','permil' => '&#8240;','lsaquo' => '&#8249;','rsaquo' => '&#8250;','euro' => '&#8364;','fnof' => '&#402;','Alpha' => '&#913;','Beta' => '&#914;','Gamma' => '&#915;','Delta' => '&#916;','Epsilon' => '&#917;',
                       );
    if (isset($table[$matches[1]])) return $table[$matches[1]];
    // else 
    return $destroy ? '' : $matches[0];
}