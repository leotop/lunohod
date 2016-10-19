<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line",
	"ms_basket",
	array(
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"SHOW_PERSONAL_LINK" => "N",
		"BUY_URL_SIGN" => "action=ADD2BASKET",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_TOTAL_PRICE" => "Y",
		"SHOW_EMPTY_VALUES" => "Y",
		"SHOW_AUTHOR" => "N",
		"PATH_TO_REGISTER" => SITE_DIR."login/",
		"PATH_TO_PROFILE" => SITE_DIR."personal/",
		"SHOW_PRODUCTS" => "N",
		"SHOW_DELAY" => "N",
		"SHOW_NOTAVAIL" => "N",
		"SHOW_SUBSCRIBE" => "N",
		"SHOW_IMAGE" => "Y",
		"SHOW_PRICE" => "Y",
		"SHOW_SUMMARY" => "Y",
		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
		"POSITION_FIXED" => "N",
		"POSITION_HORIZONTAL" => "right",
		"POSITION_VERTICAL" => "bottom"
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
  "bitrix:sale.basket.basket.line",
  "ms_basket_panel",
  array(
    "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
    "PATH_TO_PERSONAL" => SITE_DIR."personal/",
    "SHOW_PERSONAL_LINK" => "N",
    "SHOW_NUM_PRODUCTS" => "Y",
    "SHOW_TOTAL_PRICE" => "Y",
    "SHOW_PRODUCTS" => "N",
    "POSITION_FIXED" =>"N",
    "SHOW_AUTHOR" => "Y",
    "PATH_TO_REGISTER" => SITE_DIR."login/",
    "PATH_TO_PROFILE" => SITE_DIR."personal/"
  ),
  false,
  Array('HIDE_ICONS' => 'Y')
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
