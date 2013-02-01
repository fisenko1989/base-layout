<?php

/** DEFINE section***********************/

define('MANAGERS_GROUP', 7);

/****************************************/

//AddEventHandler("main", "OnUserTypeBuildList", array("userManagerLinkType", "GetUserTypeDescription"));


// привязка к человеку, например, пользователя к менеджеру
class userManagerLinkType extends CUserTypeString
{
    function GetUserTypeDescription() {
        return array(
            "USER_TYPE_ID" => "user_manager_link",
            "CLASS_NAME" => "userManagerLinkType",
            "DESCRIPTION" => "Привязка к менеджеру",
            "BASE_TYPE" => "string",
        );
    }

    function GetEditFormHTML($arUserField, $arHtmlControl){
        $managers = CUser::GetList(($by = "name"), ($sort = "asc"), array('GROUPS_ID' => array(MANAGERS_GROUP)));
        while($manager = $managers->GetNext()){
            $managers_list[] = $manager;
        }
        if(count($managers_list) > 0){
            ob_start();
            ?>
        <select name="<?=$arHtmlControl['NAME']?>" id="<?=$arHtmlControl['NAME']?>">
            <option value="">Нет</option>
            <?foreach($managers_list as $manager){?>
            <option value="<?=$manager['ID']?>" <?=$arHtmlControl["VALUE"] == $manager['ID']
                ? 'selected = "selected"' : ""?>><?=$manager['NAME']?></option>
            <?}?>
        </select>
            <?
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
        else {
            return "Нет ни одного менеджера";
        }
    }
}