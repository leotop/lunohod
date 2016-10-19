<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?$APPLICATION->IncludeComponent("ms.shop:ms.oneclick", "", Array(
		"USE_CAPTCHA" => "N",
		"OK_TEXT" => "Спасибо! Ваше сообщение принято.",
		"EMAIL_TO" => "sale@press.webgk.ru",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "PHONE",
		),
		"EVENT_MESSAGE_ID" => array(0=>"7",),
		"AJAX_MODE" => "Y",  // режим AJAX
		"AJAX_OPTION_SHADOW" => "N", // затемн¤ть область
		"AJAX_OPTION_JUMP" => "N", // скроллить страницу до компонента
		"AJAX_OPTION_STYLE" => "N", // подключать стили
		"AJAX_OPTION_HISTORY" => "N",
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
