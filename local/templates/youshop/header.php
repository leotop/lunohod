<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
CJSCore::Init(array("fx"));
CUtil::InitJSCore();
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>favicon.ico" />

	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-1.8.3.min.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.easytabs.min.js");?>

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<?$APPLICATION->ShowHead();?>

	<title><?$APPLICATION->ShowTitle()?></title>

	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/script.js");?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/ios-orientationchange-fix.js');?>

	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/libs/jquery.ui/jquery-ui-1.10.4.custom.css');?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/libs/jquery.ui/jquery-ui-1.10.4.custom.min.js');?>

	<!--jCarousel-->
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/libs/jcarousel/jcarousel.css');?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/libs/jcarousel/jquery.jcarousel.min.js');?>

	<script type="text/javascript">
		var tplUrl = '<?=SITE_TEMPLATE_PATH?>';
		var storesTitle = '<?=GetMessage('STORES_TITLE')?>';
		if(document.documentElement){document.documentElement.id="js"}
	</script>

	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.cookie.js');?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/forms.css');?>

	<!-- Nivoslider -->
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/libs/nivoslider/nivo-slider.css');?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/libs/nivoslider/default/default.css');?>

	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/libs/nivoslider/jquery.nivo.slider.js');?>

	<!--[if lt IE 9]>
		<script src="<?=SITE_TEMPLATE_PATH?>/js/html5shiv.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/ie8.css" />
	<![endif]-->

	<!--Fancybox-->
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/libs/fancybox/jquery.fancybox.css');?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/libs/fancybox/jquery.fancybox.pack.js');?>

	<link href="<?=SITE_TEMPLATE_PATH?>/css/responsive.css" media="screen" rel="stylesheet" type="text/css"/>

	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.placeholder.js');?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/scripts.js');?>

	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/catalog_grid.css');?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/catalog_list.css');?>
	<?$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/catalog_element.css');?>

	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/catalog_section.js');?>


	<script type="text/javascript">
		var cartURL = "<?=SITE_DIR;?>personal/cart/";
	</script>

	<script type="text/javascript">
		var siteOptions = ({
			"SITE_DIR" : "<?=SITE_DIR;?>"
		});
	</script>
</head>

<!-- <body class="site_boxed" style="background: url('/theme_files/grey_wash_wall.png') repeat;"> -->
<body>

<div id="panel"><?$APPLICATION->ShowPanel();?></div>

<?$isCatalog = CSite::InDir(SITE_DIR.'catalog/');?>
<?$isHome = CSite::InDir(SITE_DIR.'index.php');?>
<?$isPersonal = CSite::InDir(SITE_DIR.'personal/');?>

<?$theme = $APPLICATION->IncludeComponent(
	"ms.shop:theme",
	"",
	array(
	),
false,
Array('HIDE_ICONS' => 'Y')
);?>

<div id="content-bg"></div>

<div id="fix_panel" class="fp_light">
	<div class="maxwidth">
		<div id="fix_panel_in" class="clearfix">
			<div class="fp_item fp_feedback feedback-link">
				<i></i>
				<a rel="nofollow" class="dotted" href="<?=SITE_DIR?>feedback.php"><?=GetMessage("PANEL_FEEDBACK")?></a>
			</div>
			<div class="fp_item fp_search">
				<a rel="nofollow" href="<?=SITE_DIR?>catalog/?q=&s="></a>
			</div>

			<div class="fp_item">
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
						"PATH_TO_PROFILE" => SITE_DIR."personal/",
                        "HIDE_ON_BASKET_PAGES" => "N"
					),
					false,
					Array('HIDE_ICONS' => 'Y')
				);?>
			</div>

			<div class="fp_item">
				<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_SHOW" => "file",
					"PATH" => SITE_DIR."ajax/show_compare_line.php",
					"AREA_FILE_RECURSIVE" => "N",
					"EDIT_MODE" => "html",
				),
				false,
				Array('HIDE_ICONS' => 'Y')
				);?>
			</div>

			<div class="fp_item">
				<div class="fp_auth">
					<i></i>
					<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "ms_auth_panel", Array(
						"REGISTER_URL" => SITE_DIR."login/",	// Страница регистрации
						"PROFILE_URL" => SITE_DIR."personal/",	// Страница профиля
						"SHOW_ERRORS" => "N",	// Показывать ошибки
						),
						false,
						Array('HIDE_ICONS' => 'Y')
					);?>
				</div>
			</div>

		</div>
	</div>
</div>

<div id="container">
	<?if ($theme["TEMPLATE_TYPE"] == "type1") {?>
		<div id="top-panel">
			<div class="maxwidth no-marker clearfix">
				<?$APPLICATION->IncludeComponent("bitrix:menu", "ms_top_menu", Array(
					"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
						"MENU_CACHE_TYPE" => "Y",	// Тип кеширования
						"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
						"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
						"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
						"MAX_LEVEL" => "1",	// Уровень вложенности меню
						"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
						"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
						"DELAY" => "N",	// Откладывать выполнение шаблона меню
						"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
					),
					false
				);?>

				<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "ms_auth", Array(
					"REGISTER_URL" => SITE_DIR."login/",	// Страница регистрации
					"PROFILE_URL" => SITE_DIR."personal/",	// Страница профиля
					"SHOW_ERRORS" => "N",	// Показывать ошибки
					),
					false
				);?>

				<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("user-block");?>
				<?if (!$USER->IsAuthorized()) {?>
				<?}?>
				<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("user-block", "");?>
			</div>
		</div>
	<?}?>

	<div id="container-in" class="maxwidth">
		<header id="site_header">
			<div class="h_item h_logo">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/header_logo.php"), false);?>
			</div>

			<div class="h_item h_search">
				<?$APPLICATION->IncludeComponent(
	"bitrix:search.title",
	"ms_search",
	array(
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "5",
		"CHECK_DATES" => "N",
		"SHOW_OTHERS" => "N",
		"PAGE" => SITE_DIR."catalog/",
		"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_iblock_catalog" => array(
			0 => "all",
		),
		"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "search",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CONVERT_CURRENCY" => "Y",
		"COMPONENT_TEMPLATE" => "ms_search",
		"ORDER" => "rank",
		"USE_LANGUAGE_GUESS" => "Y",
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"CURRENCY_ID" => "RUB"
	),
	false
);?>
			</div>

			<div id="header-contacts" class="h_item">
				<div id="header-contacts-in">
					<div class="phone">
						<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/telephone.php"), false);?>
					</div>
					<div class="worktime">
						<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/schedule.php"), false);?>
					</div>
				</div>
			</div>

			<div class="h_item top_cart">
					<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line", 
	"ms_basket", 
	array(
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"SHOW_PERSONAL_LINK" => "N",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_TOTAL_PRICE" => "Y",
		"SHOW_PRODUCTS" => "N",
		"POSITION_FIXED" => "N",
		"SHOW_AUTHOR" => "Y",
		"PATH_TO_REGISTER" => SITE_DIR."login/",
		"PATH_TO_PROFILE" => SITE_DIR."personal/",
		"COMPONENT_TEMPLATE" => "ms_basket",
		"SHOW_EMPTY_VALUES" => "Y",
		"BUY_URL_SIGN" => "action=ADD2BASKET",
		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
		"HIDE_ON_BASKET_PAGES" => "N"
	),
	false
);?>
			</div>
		</header>

		<div id="top-nav">
			<?if ($theme["TEMPLATE_TYPE"] == "type1") {?>
				<?$APPLICATION->IncludeComponent("bitrix:menu", "ms_horizontal_menu", Array(
				"ROOT_MENU_TYPE" => "catalog",	// Тип меню для первого уровня
				"MENU_THEME" => "site",	// Тема меню
				"MENU_CACHE_TYPE" => "A",	// Тип кеширования
				"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
				"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
				"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
				"MAX_LEVEL" => "3",	// Уровень вложенности меню
				"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
				"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
				"DELAY" => "N",	// Откладывать выполнение шаблона меню
				"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
				),
				false
				);?>
			<?} elseif ($theme["TEMPLATE_TYPE"] == "type2") {?>
				<?$APPLICATION->IncludeComponent("bitrix:menu", "ms_horizontal_menu", Array(
				"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
				"MENU_THEME" => "site",	// Тема меню
				"MENU_CACHE_TYPE" => "A",	// Тип кеширования
				"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
				"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
				"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
				"MAX_LEVEL" => "3",	// Уровень вложенности меню
				"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
				"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
				"DELAY" => "N",	// Откладывать выполнение шаблона меню
				"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
				),
				false
				);?>
			<?}?>
		</div>

		<section class="clearfix">

		<?if ($theme["TEMPLATE_TYPE"] == "type1") {?>
			<?if ($APPLICATION->GetCurPage(true) == SITE_DIR."index.php") {?>
				<?
				$APPLICATION->IncludeFile(
					SITE_DIR."include/index_slider.php",
					Array(),
					Array("MODE"=>"html")
				);
				?>
			<?}?>
		<?}?>

		<?if (!$isPersonal && !$isCatalog) {?>
			<aside id="column-l">
				<?$APPLICATION->ShowViewContent("sidebar_filter")?>

				<?if ($APPLICATION->GetCurPage(true) == SITE_DIR."index.php") {?>
					<?$APPLICATION->IncludeComponent("bitrix:menu", "ms_sidebar_full_catalog", Array(
						"ROOT_MENU_TYPE" => "catalog",	// Тип меню для первого уровня
						"MENU_THEME" => "site",	// Тема меню
						"MENU_CACHE_TYPE" => "A",	// Тип кеширования
						"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
						"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
						"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
						"MAX_LEVEL" => "3",	// Уровень вложенности меню
						"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
						"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
						"DELAY" => "N",	// Откладывать выполнение шаблона меню
						"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
						),
						false
					);?>
				<?}?>

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

				<?if (!$isCatalog || $isHome) {?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include/sidebar_reviews.php",
							"AREA_FILE_RECURSIVE" => "N",
							"EDIT_MODE" => "html",
						),
						false,
						Array('HIDE_ICONS' => 'Y')
					);?>

					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include/sidebar_news.php",
							"AREA_FILE_RECURSIVE" => "N",
							"EDIT_MODE" => "html",
						),
						false,
						Array('HIDE_ICONS' => 'Y')
					);?>
				<?}?>

				<?/**$APPLICATION->IncludeComponent(
	"bitrix:subscribe.form",
	".default",
	array(
		"USE_PERSONALIZATION" => "Y",
		"PAGE" => "#SITE_DIR#personal/subscribe/",
		"SHOW_HIDDEN" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);**/?>

			</aside>
		<?}?>

		<?if ($isHome || !$isCatalog) {?>
			<div class="content">
		<?}?>

		<div class="content full-w">
			<?if (!$isCatalog && !$isHome) {?>
				<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "ms_breadcrumb", Array(
						"START_FROM" => "0",
						"PATH" => "",
						"SITE_ID" => "-"
					),
					false,
					Array('HIDE_ICONS' => 'Y')
				);?>
			<?}?>

			<?if ($theme["TEMPLATE_TYPE"] == "type2") {?>
				<?if ($APPLICATION->GetCurPage(true) == SITE_DIR."index.php") {?>
					<?
					$APPLICATION->IncludeFile(
						SITE_DIR."include/index_slider.php",
						Array(),
						Array("MODE"=>"html")
					);
					?>
				<?}?>
			<?}?>
