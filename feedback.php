<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?$APPLICATION->IncludeComponent("bitrix:main.feedback", "ms_feedback", Array(
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "Спасибо, ваше сообщение отправлено!",
		"EMAIL_TO" => "sale@press.webgk.ru",
		"REQUIRED_FIELDS" => array(),
		"EVENT_MESSAGE_ID" => array(0=>"7",),
		"AJAX_MODE" => "Y",  // режим AJAX
		"AJAX_OPTION_SHADOW" => "N", // затемнять область
		"AJAX_OPTION_JUMP" => "N", // скроллить страницу до компонента
		"AJAX_OPTION_STYLE" => "N", // подключать стили
		"AJAX_OPTION_HISTORY" => "N",
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
