<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
$iblock_id = "9";
$product_id = intval($_REQUEST["add"]);

if($product_id) {
	if(!CModule::IncludeModule("sale") || !CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock")) {
		return;
	}

	if(array_key_exists($product_id, $_SESSION["CATALOG_COMPARE_LIST"][$iblock_id]["ITEMS"]) && !empty($_SESSION["CATALOG_COMPARE_LIST"][$iblock_id])) {
		unset($_SESSION["CATALOG_COMPARE_LIST"][$iblock_id]["ITEMS"][$product_id]);
	} else {
		$_SESSION["CATALOG_COMPARE_LIST"][$iblock_id]["ITEMS"][$product_id] = CIBlockElement::GetByID($product_id)->Fetch();
	}
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
