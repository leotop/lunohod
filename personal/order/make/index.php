<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"ms_order_edit", 
	array(
		"PAY_FROM_ACCOUNT" => "N",
		"COUNT_DELIVERY_TAX" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"ALLOW_AUTO_REGISTER" => "N",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "Y",
		"TEMPLATE_LOCATION" => "popup",
		"PROP_1" => "",
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_PERSONAL" => "/personal/order/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"PATH_TO_ORDER" => "/personal/order/make/",
		"SET_TITLE" => "Y",
		"DELIVERY2PAY_SYSTEM" => "",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"COMPONENT_TEMPLATE" => "ms_order_edit",
		"DELIVERY_NO_SESSION" => "N",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"USE_PREPAYMENT" => "N",
		"PROP_7" => "",
		"PROP_8" => "",
		"ALLOW_NEW_PROFILE" => "Y",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"PATH_TO_AUTH" => "/auth/",
		"DISABLE_BASKET_REDIRECT" => "N",
		"PRODUCT_COLUMNS" => "",
		"COMPATIBLE_MODE" => "Y",
		"PRODUCT_COLUMNS_VISIBLE" => array(
			0 => "PREVIEW_PICTURE",
		),
		"ADDITIONAL_PICT_PROP_9" => "-",
		"ADDITIONAL_PICT_PROP_10" => "-",
		"BASKET_IMAGES_SCALING" => "standard"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
