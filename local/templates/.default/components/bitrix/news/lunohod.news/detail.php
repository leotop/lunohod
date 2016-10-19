<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?$ElementID = $APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "",
    Array(
        "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
        "DISPLAY_NAME" => $arParams["DISPLAY_NAME"],
        "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "FIELD_CODE" => $arParams["DETAIL_FIELD_CODE"],
        "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
        "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
        "META_KEYWORDS" => $arParams["META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["BROWSER_TITLE"],
        "SET_CANONICAL_URL" => $arParams["DETAIL_SET_CANONICAL_URL"],
        "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
        "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "MESSAGE_404" => $arParams["MESSAGE_404"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "SHOW_404" => $arParams["SHOW_404"],
        "FILE_404" => $arParams["FILE_404"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
        "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
        "ACTIVE_DATE_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
        "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
        "DISPLAY_TOP_PAGER" => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["DETAIL_PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => $arParams["DETAIL_PAGER_TEMPLATE"],
        "PAGER_SHOW_ALL" => $arParams["DETAIL_PAGER_SHOW_ALL"],
        "CHECK_DATES" => $arParams["CHECK_DATES"],
        "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
        "USE_SHARE" => $arParams["USE_SHARE"],
        "SHARE_HIDE" => $arParams["SHARE_HIDE"],
        "SHARE_TEMPLATE" => $arParams["SHARE_TEMPLATE"],
        "SHARE_HANDLERS" => $arParams["SHARE_HANDLERS"],
        "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
        "SHARE_SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
        "ADD_ELEMENT_CHAIN" => (isset($arParams["ADD_ELEMENT_CHAIN"]) ? $arParams["ADD_ELEMENT_CHAIN"] : '')
    ),
    $component
);?>
<p><a href="<?=$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"]?>"><?=GetMessage("T_NEWS_DETAIL_BACK")?></a></p>
<?if($arParams["USE_RATING"]=="Y" && $ElementID):?>
<?$APPLICATION->IncludeComponent(
    "bitrix:iblock.vote",
    "",
    Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ELEMENT_ID" => $ElementID,
        "MAX_VOTE" => $arParams["MAX_VOTE"],
        "VOTE_NAMES" => $arParams["VOTE_NAMES"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
    ),
    $component
);?>
<?endif?>
<?if($arParams["USE_CATEGORIES"]=="Y" && $ElementID):
    global $arCategoryFilter;
    $obCache = new CPHPCache;
    $strCacheID = $componentPath.LANG.$arParams["IBLOCK_ID"].$ElementID.$arParams["CATEGORY_CODE"];
    if(($tzOffset = CTimeZone::GetOffset()) <> 0)
        $strCacheID .= "_".$tzOffset;
    if($arParams["CACHE_TYPE"] == "N" || $arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N")
        $CACHE_TIME = 0;
    else
        $CACHE_TIME = $arParams["CACHE_TIME"];
    if($obCache->StartDataCache($CACHE_TIME, $strCacheID, $componentPath))
    {
        $rsProperties = CIBlockElement::GetProperty($arParams["IBLOCK_ID"], $ElementID, "sort", "asc", array("ACTIVE"=>"Y","CODE"=>$arParams["CATEGORY_CODE"]));
        $arCategoryFilter = array();
        while($arProperty = $rsProperties->Fetch())
        {
            if(is_array($arProperty["VALUE"]) && count($arProperty["VALUE"])>0)
            {
                foreach($arProperty["VALUE"] as $value)
                    $arCategoryFilter[$value]=true;
            }
            elseif(!is_array($arProperty["VALUE"]) && strlen($arProperty["VALUE"])>0)
                $arCategoryFilter[$arProperty["VALUE"]]=true;
        }
        $obCache->EndDataCache($arCategoryFilter);
    }
    else
    {
        $arCategoryFilter = $obCache->GetVars();
    }
    if(count($arCategoryFilter)>0):
        $arCategoryFilter = array(
            "PROPERTY_".$arParams["CATEGORY_CODE"] => array_keys($arCategoryFilter),
            "!"."ID" => $ElementID,
        );
        ?>
        <hr /><h3><?=GetMessage("CATEGORIES")?></h3>
        <?foreach($arParams["CATEGORY_IBLOCK"] as $iblock_id):?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                $arParams["CATEGORY_THEME_".$iblock_id],
                Array(
                    "IBLOCK_ID" => $iblock_id,
                    "NEWS_COUNT" => $arParams["CATEGORY_ITEMS_COUNT"],
                    "SET_TITLE" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "FILTER_NAME" => "arCategoryFilter",
                    "CACHE_FILTER" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                ),
                $component
            );?>
        <?endforeach?>
    <?endif?>
<?endif?>
<?if($arParams["USE_REVIEW"]=="Y" && IsModuleInstalled("forum") && $ElementID):?>
<hr />
<?$APPLICATION->IncludeComponent(
    "bitrix:forum.topic.reviews",
    "",
    Array(
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
        "USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
        "PATH_TO_SMILE" => $arParams["PATH_TO_SMILE"],
        "FORUM_ID" => $arParams["FORUM_ID"],
        "URL_TEMPLATES_READ" => $arParams["URL_TEMPLATES_READ"],
        "SHOW_LINK_TO_FORUM" => $arParams["SHOW_LINK_TO_FORUM"],
        "DATE_TIME_FORMAT" => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
        "ELEMENT_ID" => $ElementID,
        "AJAX_POST" => $arParams["REVIEW_AJAX_POST"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "URL_TEMPLATES_DETAIL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
    ),
    $component
);?>
<?endif?>
<?
    global $arrFilter;
    if($arParams['FILTER_FIELD'] == 'AUTHORS'){
        $arrFilter = array(
            "PROPERTY_AUTHOR_NAME" => $arResult["VARIABLES"]["ELEMENT_ID"],
        );   
    }
    if($arParams['FILTER_FIELD'] == 'PAINTERS'){
        $arrFilter = array(
            "PROPERTY_Painter" => $arResult["VARIABLES"]["ELEMENT_ID"],
        );   
    }
    if($arParams['FILTER_FIELD'] == 'TRANSLATERS'){
        $arrFilter = array(
            "PROPERTY_TRANSLATOR" => $arResult["VARIABLES"]["ELEMENT_ID"],
        );   
    }
    if($arParams['FILTER_FIELD'] == 'PUBLISHERS'){
        $arrFilter = array(
            "PROPERTY_MANUFACTURER" => $arResult["VARIABLES"]["ELEMENT_ID"],
        );   
    } 
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"ms_grid", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "ms_grid",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "30",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "AUTHOR_NAME",
			1 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N"
	),
	false
);?>