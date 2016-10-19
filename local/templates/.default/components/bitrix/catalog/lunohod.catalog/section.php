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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(false);
$this->addExternalCss("/bitrix/css/main/bootstrap.css");

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isFilter = ($arParams['USE_FILTER'] == 'Y');

if ($isFilter)
{
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
	{
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	}
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
	{
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
	}

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
	{
		$arCurSection = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		if (Loader::includeModule("iblock"))
		{
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->Fetch())
				{
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
				}
				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
	{
		$arCurSection = array();
	}
}
?>

<?
// Elements Count
$arFilter = array(
	"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
	"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
	'GLOBAL_ACTIVE' => 'Y',
	"INCLUDE_SUBSECTIONS" => ($arParams["INCLUDE_SUBSECTIONS"] == 'N' ? 'N' : 'Y')
);

$rsElementsCount = CIBlockElement::GetList(array(), $arFilter, array(), false, array());
?>

<?
// Catalog view
if (!isset($_COOKIE['catalogView'])) {
	$viewMode = 'ms_list';
	SetCookie('catalogView', 'ms_list', 0, '/');
} else {
	$viewMode = $_COOKIE['catalogView'];
}

// Sort
$arAvailableSort = array(
	"name" => Array("name", "asc"),
	"price" => Array('CATALOG_PRICE_1', "asc"),
);

$sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : "name";
$sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : $arAvailableSort[$sort][1];

// Limits
$arAvailableLimit = array("12", "24", "48");

$limit = $APPLICATION->get_cookie('limit') ? $APPLICATION->get_cookie("limit") : "12";

if($_REQUEST["limit"])
	$limit = "12";
	$APPLICATION->set_cookie("limit", $limit);
if($_REQUEST["limit"] == "24")
	$limit = "24";
	$APPLICATION->set_cookie("limit", $limit);
if($_REQUEST["limit"] == "48")
	$limit = "48";
	$APPLICATION->set_cookie("limit", $limit);
?>

<aside id="column-l">
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"ms_side_menu_catalog",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
			"TOP_DEPTH" => 3,
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"VIEW_MODE" => "list",
			"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
			"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
			"ADD_SECTIONS_CHAIN" => "N",
		),
		$component
	);?>

	<?if ($isFilter && $rsElementsCount > 0):?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.smart.filter",
			"ms_catalog",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $arCurSection['ID'],
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"PRICE_CODE" => $arParams["PRICE_CODE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"SAVE_IN_SESSION" => "N",
				"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
				"XML_EXPORT" => "Y",
				"SECTION_TITLE" => "NAME",
				"SECTION_DESCRIPTION" => "DESCRIPTION",
				'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
				"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
				"SEF_MODE" => $arParams["SEF_MODE"],
				"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
				"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
				"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
			),
			$component,
			array('HIDE_ICONS' => 'Y')
		);?>
	<?endif?>

	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "file",
			"PATH" => SITE_DIR."include/sidebar_adv.php",
			"AREA_FILE_RECURSIVE" => "N",
			"EDIT_MODE" => "html",
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
</aside>

<div class="content">
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "ms_breadcrumb", Array(
	"START_FROM" => "1",	// Номер пункта, начиная с которого будет построена навигационная цепочка
		"PATH" => "",	// Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
		"SITE_ID" => "s1",	// Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
		"COMPONENT_TEMPLATE" => ".default"
	),
	false,
	array(
	"HIDE_ICONS" => "N"
	)
);?>

	<h1 class="bx_catalog_tile_category_title"><?=$APPLICATION->ShowTitle(false);?></h1>

	<!-- Start Description -->
	<?if(empty($_REQUEST["PAGEN_1"])) {?>
		<?
		$arFilter = array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			'GLOBAL_ACTIVE' => 'Y'
		);

		$arSelect = array(
			"NAME",
			"UF_TOP_DESCRIPTION"
		);

		$rsSections = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);

		while ($arSection = $rsSections->Fetch())
		{
				?>
				<div class="category-top-description">
					<? echo $arSection['UF_TOP_DESCRIPTION']; ?>
				</div>
				<?
		}
		?>
	<?}?>
	<!-- End Description -->

	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"ms_catalog",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
			"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
			"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
			"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
			"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
		),
		$component,
		array("HIDE_ICONS" => "N")
	);?>

	<?
	if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
	{
		$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
	}
	else
	{
		$basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
	}
	$intSectionID = 0;
	?>

	<?if($rsElementsCount > 0) {?>
	<div class="c_toolbar clearfix">
		<div class="filter_popup_btn_wrap">
			<button id="filter_popup_btn" class="btn bt3"><?=GetMessage("BTN_FILTER")?></button>
		</div>

		<div class="sort">
			<span class="label"><?=GetMessage('SECT_SORT_LABEL')?></span>
			<div class="no-marker">
				<ul>
					<?foreach ($arAvailableSort as $key => $val):
						$className = ($sort == $val[0]) ? ' current btn' : '';
						if ($className)
							$className .= ($sort_order == 'asc') ? ' asc' : ' desc';
						$newSort = ($sort == $val[0]) ? ($sort_order == 'desc' ? 'asc' : 'desc') : $arAvailableSort[$key][1];
						?>
						<li><a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, 	array('sort', 'order'))?>" class="sortbutton <?=$className?>" rel="nofollow"><?=GetMessage('SECT_SORT_'.$key)?><?if ($sort == $val[0]):?><span></span><?endif?></a></li>
					<?endforeach;?>
				</ul>
			</div>
		</div>

		<div class="prod-per-page">
			<span class="label"><?=GetMessage("SHOW_COUNT")?></span>
			<div class="select_dropdown no-marker">
				<div class="dd_label">
					<span>
						<?if($limit !== '900'):?>
							<?=$limit?>
						<?else:?>
							<?=GetMessage('SECT_COUNT_ALL');?>
						<?endif?>
					</span>
					<i></i>
				</div>
				<ul class="dd">
					<?foreach($arAvailableLimit as $val):?>
						<li <?if($limit==$val) echo " class='bx_active'";?>><a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('limit='.$val, array('limit'))?>"><?if($val=='900'): echo GetMessage('SECT_COUNT_ALL'); else: echo $val; endif;?></a></li>
					<?endforeach;?>
				</ul>
			</div>
		</div>

		<div class="catalog-view-ctrl right">
			<div><?=GetMessage("SECTIONS_VIEW")?> </div>
			<a rel="nofollow" class="view-list<?if($viewMode == 'ms_list'):?> active<?endif?>" href="ms_list" title="<?=GetMessage("SECTIONS_VIEW_LIST")?>"><span></span></a>
			<a rel="nofollow" class="view-table<?if($viewMode == 'ms_grid'):?> active<?endif?>" href="ms_grid" title="<?=GetMessage("SECTIONS_VIEW_TABLE")?>"><span></span></a>
		</div>
	</div>
	<?}?>

	<?$intSectionID = $APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		$viewMode,
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			//"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
			"ELEMENT_SORT_FIELD" => $sort,
			//"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
			"ELEMENT_SORT_ORDER" => $sort_order,
			"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"MESSAGE_404" => $arParams["MESSAGE_404"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"SHOW_404" => $arParams["SHOW_404"],
			"FILE_404" => $arParams["FILE_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			//"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"PAGE_ELEMENT_COUNT" => $limit,
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
			"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
			"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
			"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
			"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],

			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

			'LABEL_PROP' => $arParams['LABEL_PROP'],
			'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
			'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

			'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
			'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
			'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
			'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
			'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
			'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
			'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
			'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

			'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
			"ADD_SECTIONS_CHAIN" => "N",
			'ADD_TO_BASKET_ACTION' => $basketAction,
			'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
			'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
			'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : '')
		),
		$component
	);?>

	<?
	$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
	unset($basketAction);
	?>

	<?
	if (ModuleManager::isModuleInstalled("sale"))
	{
		$arRecomData = array();
		$recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
		$obCache = new CPHPCache();
		if ($obCache->InitCache(36000, serialize($recomCacheID), "/sale/bestsellers"))
		{
			$arRecomData = $obCache->GetVars();
		}
		elseif ($obCache->StartDataCache())
		{
			if (Loader::includeModule("catalog"))
			{
				$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
				$arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
			}
			$obCache->EndDataCache($arRecomData);
		}

		if (!empty($arRecomData))
		{
			if (!isset($arParams['USE_BIG_DATA']) || $arParams['USE_BIG_DATA'] != 'N')
			{
				?>
				<?$APPLICATION->IncludeComponent("bitrix:catalog.bigdata.products", "ms_catalog", array(
					"LINE_ELEMENT_COUNT" => 4,
					"TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
					"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_cbdp",
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
					"SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
					"PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"SHOW_NAME" => "Y",
					"SHOW_IMAGE" => "Y",
					"MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
					'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],					
					"MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
					"MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
					"MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
					"PAGE_ELEMENT_COUNT" => 4,
					"SHOW_FROM_SECTION" => "Y",
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"DEPTH" => "2",
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
					"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
					"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
					"CURRENCY_ID" => $arParams["CURRENCY_ID"],
					"SECTION_ID" => $intSectionID,
					"SECTION_CODE" => "",
					"SECTION_ELEMENT_ID" => "",
					"SECTION_ELEMENT_CODE" => "",
					"LABEL_PROP_".$arParams["IBLOCK_ID"] => $arParams['LABEL_PROP'],
					"PROPERTY_CODE_".$arParams["IBLOCK_ID"] => $arParams["LIST_PROPERTY_CODE"],
					"PROPERTY_CODE_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["LIST_OFFERS_PROPERTY_CODE"],
					"CART_PROPERTIES_".$arParams["IBLOCK_ID"] => $arParams["PRODUCT_PROPERTIES"],
					"CART_PROPERTIES_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFERS_CART_PROPERTIES"],
					"ADDITIONAL_PICT_PROP_".$arParams["IBLOCK_ID"] => $arParams['ADD_PICT_PROP'],
					"ADDITIONAL_PICT_PROP_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP'],
					"OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
					"RCM_TYPE" => (isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : '')
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>
			<?
			}
		}
	}
	?>

<!-- Start Description -->
<?if(empty($_REQUEST["PAGEN_1"])) {?>
	<?
	$arFilter = array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		'GLOBAL_ACTIVE' => 'Y'
	);

	$arSelect = array(
		"NAME",
		"DESCRIPTION"
	);

	$rsSections = CIBlockSection::GetList(array(), $arFilter, false, $arSelect);

	while ($arSection = $rsSections->Fetch())
	{
			?>
			<div class="category-bottom-description">
				<? echo $arSection['DESCRIPTION']; ?>
			</div>
			<?
	}
	?>
<?}?>
<!-- End Description -->

</div>
