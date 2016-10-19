<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/icons_menu.php"
	)
);?>
<div class="tabs" id="home-tabs">
	<ul class="no-marker h_tabs_ctrl clearfix">
		<li><a href="#t_home_recommend">Советуем</a></li>
		<li><a href="#t_home_new">Новинки</a></li>
		<li><a href="#t_home_sl">Хиты продаж</a></li>
	</ul>
	<div class="ms_tab" id="t_home_recommend">
		<?
global $arrFilterShowOnMain;
$arrFilterShowOnMain = array(
	 "PROPERTY_SHOWONMAIN_VALUE" => "да"
);?>
		 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"ms_catalog",
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/cart/",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "180",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "ms_catalog",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_COMPARE" => "Y",
		"ELEMENT_COUNT" => "12",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "name",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_NAME" => "arrFilterShowOnMain",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "catalog",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "4",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "PHONE_COLOR",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "MORE_PHOTO",
			1 => "PHONE_COLOR",
			2 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(
			0 => "PHONE_COLOR",
		),
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id_section",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => array(
			0 => "NEWPRODUCT",
			1 => "SALELEADER",
			2 => "SPECIALOFFER",
			3 => "ARTNUMBER",
			4 => "",
		),
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "site",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"VIEW_MODE" => "SECTION",
		"COMPARE_PATH" => "catalog/compare/"
	),
	false
);?>
	</div>
	<div class="ms_tab" id="t_home_new">
		 <?
global $arrFilterNew;
$arrFilterNew = array(
    "PROPERTY_NEWPRODUCT_VALUE" => "да"
);?>
		 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"ms_catalog",
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/cart/",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "180",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "ms_catalog",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_COMPARE" => "Y",
		"ELEMENT_COUNT" => "12",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "name",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_NAME" => "arrFilterNew",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "catalog",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "4",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "В корзину",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "PHONE_COLOR",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "MORE_PHOTO",
			1 => "PHONE_COLOR",
			2 => "RAM",
			3 => "PIC",
			4 => "ARTNUMBER",
			5 => "MEMORY_SIZE",
			6 => "COLOR_REF",
			7 => "SIZES_SHOES",
			8 => "SIZES_CLOTHES",
			9 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "PHONE_COLOR",
		),
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id_section",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => array(
			0 => "NEWPRODUCT",
			1 => "SALELEADER",
			2 => "SPECIALOFFER",
			3 => "ARTNUMBER",
			4 => "",
		),
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "site",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"VIEW_MODE" => "SECTION"
	),
	false
);?>
	</div>
	<div class="ms_tab" id="t_home_sl">
		 <?
global $arrFilterSaleLeader;
$arrFilterSaleLeader = array(
    "PROPERTY_SALELEADER_VALUE" => "да"
);?>
		 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"ms_catalog",
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/cart/",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "180",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => "ms_catalog",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_COMPARE" => "Y",
		"ELEMENT_COUNT" => "12",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "name",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_NAME" => "arrFilterSaleLeader",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "catalog",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "4",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "В корзину",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "PHONE_COLOR",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "",
		),
		"OFFERS_LIMIT" => "0",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "MORE_PHOTO",
			1 => "PHONE_COLOR",
			2 => "RAM",
			3 => "PIC",
			4 => "ARTNUMBER",
			5 => "MEMORY_SIZE",
			6 => "COLOR_REF",
			7 => "SIZES_SHOES",
			8 => "SIZES_CLOTHES",
			9 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => array(
			0 => "PHONE_COLOR",
		),
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"PRODUCT_ID_VARIABLE" => "id_section",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PROPERTY_CODE" => array(
			0 => "NEWPRODUCT",
			1 => "SALELEADER",
			2 => "SPECIALOFFER",
			3 => "ARTNUMBER",
			4 => "",
		),
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "site",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"VIEW_MODE" => "SECTION"
	),
	false
);?>
	</div>
</div>

<div class="after-text">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/index_text.php"
	)
);?>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
