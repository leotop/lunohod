<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
foreach($arResult["ITEMS"]["AnDelCanBuy"] as $key => $arItem) {
	$recomendResult = CIBlockElement::GetList(
		Array(), 
		array("ID" => $arItem["PRODUCT_ID"]), 
		false, 
		Array(), 
		array(
			"PROPERTY_RECOMMEND"
		)
	);
	
	$recommendProducts = array();
	
	while($arRecommend = $recomendResult->GetNextElement())
	{
		$arElement = $arRecommend->GetFields();
		if(!empty($arElement["PROPERTY_RECOMMEND_VALUE"])) {
			$arResult["ITEMS"]["RECOMMEND"][] = $arElement["PROPERTY_RECOMMEND_VALUE"];
		}
	}
	
	$arResult["ITEMS"]["PARENT_PRODUCTS_IDS"][] = $arItem["PRODUCT_ID"];
}
?>