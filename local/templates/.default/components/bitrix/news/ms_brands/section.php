<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>

<?
$arSections = CIBlockSection::GetList(
	array(), 
	array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"], 
		"CODE" => $arResult["VARIABLES"]["SECTION_CODE"], "ACTIVE" => "Y"
	), 
	false, 
	array("ID", "NAME")
);

while ($arSect = $arSections->GetNext())
{
   $arSectionName = $arSect["NAME"];
}
?>

<?
// Вид каталога
if($_REQUEST["view"]) {
	$viewMode = $_REQUEST["view"];
	setcookie("viewMode", $viewMode, 0, "/");
} else {
	if($_COOKIE["viewMode"]) {
		$viewMode = $_COOKIE["viewMode"];
	} else {
		$viewMode = "grid";
	}
}
$viewMode = "catalog-".$viewMode;

// Сортировка
$arAvailableSort = array(
	"NAME" => Array("NAME", "asc"),
	"PRICE" => Array('PRICE', "asc"),
	"DATE" => Array('DATE', "asc"),
);

$sort = array_key_exists("sort", $_REQUEST) && array_key_exists($_REQUEST["sort"], $arAvailableSort) ? $arAvailableSort[$_REQUEST["sort"]][0] : "NAME";
$sort_order = array_key_exists("order", $_REQUEST) && in_array($_REQUEST["order"], Array("asc", "desc")) ? $_REQUEST["order"] : $arAvailableSort[$sort][1];
?>

<?if(!isset($_REQUEST["ajax"])) $this->SetViewTarget("sidebar_filter");?>
<?/**$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter", 
	"filter", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => "1",
		"SECTION_CODE" => "generatory",
		"FILTER_NAME" => "arrFilter",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N",
		"INSTANT_RELOAD" => "N",
		"TEMPLATE_THEME" => "black",
		"FILTER_VIEW_MODE" => "vertical",
		"POPUP_POSITION" => "left",
		"XML_EXPORT" => "N",
		"SECTION_TITLE" => "-",
		"SECTION_DESCRIPTION" => "-",
		"COMPONENT_TEMPLATE" => "filter",
		"DISPLAY_ELEMENT_COUNT" => "Y",
		"SEF_MODE" => "N",
		"PAGER_PARAMS_NAME" => "arrPager"
	),
	false
);**/?>
<?if(!isset($_REQUEST["ajax"])) $this->EndViewTarget("sidebar_filter");?>

<div class="catalog_toolbar clearfix">
	<div class="item select_view">	
		<a href="<?=$APPLICATION->GetCurPageParam('view=grid', array('view'))?>" class="btn <?if($viewMode == 'catalog-grid'):?>active<?endif;?> view_grid"><i></i></a>
		<a href="<?=$APPLICATION->GetCurPageParam('view=list', array('view'))?>" class="btn <?if($viewMode == 'catalog-list'):?>active<?endif;?> view_list"><i></i></a>
	</div>

	<div class="item sort_wrap">
		<span class="item_label"><?=GetMessage('SECT_SORT_LABEL')?></span>
		<div class="dropdown">
			<button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
				<?=GetMessage('SECT_SORT_'.$sort)?>
				<i class="fa fa-angle-down"></i>
			</button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				<?foreach ($arAvailableSort as $key => $val):
					$className = ($sort == $val[0]) ? 'active' : '';
					if ($className)
						$className .= ($sort_order == 'asc') ? ' asc' : ' desc';
					$newSort = ($sort == $val[0]) ? ($sort_order == 'desc' ? 'asc' : 'desc') : $arAvailableSort[$key][1];
					?>
					<li class="<?=$className?>" role="presentation"><a role="menuitem" tabindex="-1" href="<?=$APPLICATION->GetCurPageParam('sort='.$key.'&order='.$newSort, array('sort', 'order'))?>" rel="nofollow"><?=GetMessage('SECT_SORT_'.$key)?><?if ($sort == $val[0]):?><?endif?></a></li>
				<?endforeach;?>
			</ul>
		</div>
	</div>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	$viewMode,
	Array(
		"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
		"NEWS_COUNT"	=>	$arParams["NEWS_COUNT"],
		"SORT_BY1"	=>	$sort,
		"SORT_ORDER1"	=>	$sort_order,
		"SORT_BY2"	=>	$arParams["SORT_BY2"],
		"SORT_ORDER2"	=>	$arParams["SORT_ORDER2"],
		"FIELD_CODE"	=>	$arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
		"DISPLAY_PANEL"	=>	$arParams["DISPLAY_PANEL"],
		"SET_TITLE"	=>	$arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN"	=>	$arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"ADD_SECTIONS_CHAIN"	=>	$arParams["ADD_SECTIONS_CHAIN"],
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"DISPLAY_TOP_PAGER"	=>	$arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER"	=>	$arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE"	=>	$arParams["PAGER_TITLE"],
		"PAGER_TEMPLATE"	=>	$arParams["PAGER_TEMPLATE"],
		"PAGER_SHOW_ALWAYS"	=>	$arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING"	=>	$arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME"	=>	$arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"DISPLAY_DATE"	=>	$arParams["DISPLAY_DATE"],
		"DISPLAY_NAME"	=>	"Y",
		"DISPLAY_PICTURE"	=>	$arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT"	=>	$arParams["DISPLAY_PREVIEW_TEXT"],
		"PREVIEW_TRUNCATE_LEN"	=>	$arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT"	=>	$arParams["LIST_ACTIVE_DATE_FORMAT"],
		"USE_PERMISSIONS"	=>	$arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS"	=>	$arParams["GROUP_PERMISSIONS"],
		"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
		"HIDE_LINK_WHEN_NO_DETAIL"	=>	$arParams["HIDE_LINK_WHEN_NO_DETAIL"],
		"CHECK_DATES"	=>	$arParams["CHECK_DATES"],
		"INCLUDE_SUBSECTIONS" => "N",		

		"PARENT_SECTION"	=>	$arResult["VARIABLES"]["SECTION_ID"],
		"PARENT_SECTION_CODE"	=>	$arResult["VARIABLES"]["SECTION_CODE"],
		"DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"SECTION_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"IBLOCK_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
	),
	$component
);?>

<?
if( strlen($APPLICATION->GetPageProperty('title') ) > 1){
	$title = $APPLICATION->GetPageProperty('title');
} else {
	$title = $arSectionName;
}
$APPLICATION->SetPageProperty("title", $title );
$APPLICATION->SetTitle( $title );
?>