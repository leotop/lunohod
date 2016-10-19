<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
$APPLICATION->IncludeComponent("bitrix:catalog.compare.list", "ms_compare_line", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => "9",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"DETAIL_URL" => "",
	"COMPARE_URL" => "/catalog/compare/",
	"NAME" => "CATALOG_COMPARE_LIST",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
