<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($USER->IsAuthorized() || $arParams["ALLOW_AUTO_REGISTER"] == "Y")
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			$APPLICATION->RestartBuffer();
			?>
			<script type="text/javascript">
				window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			</script>
			<?
			die();
		}

	}
}
$APPLICATION->AddHeadString('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>',true);
$APPLICATION->SetAdditionalCSS($templateFolder."/style_cart.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/style.css");
$APPLICATION->SetAdditionalCSS($templateFolder."/kladr/jquery.kladr.min.css");
$APPLICATION->AddHeadScript($templateFolder."/kladr/jquery.kladr.min.js");
CUtil::InitJSCore( array('ajax' , 'popup' ));
CModule::IncludeModule("lunohod.dalliservice");
$arLocs = CSaleLocation::GetByID($arResult["ORDER_PROP"]["USER_PROPS_Y"]["5"]["VALUE"], LANGUAGE_ID);
$city = $arLocs["CITY_NAME"];
$delvery_id = $arResult["ORDER_DATA"]["DELIVERY_ID"];
if($delvery_id == 40){
	$delivery = "BOXBERRY";
}elseif($delvery_id == 38){
	$delivery = "SDEK";
}
$obj1 = LunohodDalliservice::GetPvzCityCoord($delivery, $city);
?>
<pre style="display:none">
<?print_r($arResult);?>
</pre>
<?



?>
<script>


 ymaps.ready(init);
    var myMap,
        myPlacemark;

    function init(){     
        myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10
        });
		myMap.controls.add('typeSelector');
	var myPlacemark = new ymaps.Placemark([55.76, 37.56], {}, {
        iconLayout: 'default#image',
        iconImageHref: '/local/templates/.default/components/bitrix/sale.order.ajax/ms_order_edit/BOXBERRY.png',
        iconImageSize: [30, 42],
        iconImageOffset: [-3, -42]
    });
	
		myMap.geoObjects
			.add(myPlacemark);
			/*
		<?foreach($obj1 as $ob):?>
			.add(new ymaps.Placemark([<?=$ob["coords"][1]?>, <?=$ob["coords"][0]?>], {
				
			iconLayout: 'default#image',
			iconImageHref: '<?=$templateFolder."/BOXBERRY.png"?>',
			iconImageSize: [30, 42],
			iconImageOffset: [-3, -42],
            balloonContent: '<?=$ob["address"].$ob["phone"].$ob["worktime"]?><button class="sendpvzid" id="<?=$ob["address"]?>">send</button>'
        }))
		<?endforeach;?>*/
		
    }
	
/*
	
events: {
    onAfterPopupShow: function () {
        BX.ajax.post(
            '<?// echo $this->GetFolder(); ?>/popup.php',
            {
                lang: BX.message('LANGUAGE_ID'),
                site_id: BX.message('SITE_ID') || '',
                arParams: curSetParams
 },
            BX.delegate(function (result) {
                    this.setContent(result);
                    BX("CatalogSetConstructor_" + element_id).style.left = (window.innerWidth - BX("CatalogSetConstructor_" + element_id).offsetWidth) / 2 + "px";
                    var popupTop = document.body.scrollTop + (window.innerHeight - BX("CatalogSetConstructor_" + element_id).offsetHeight) / 2;
                    //BX("CatalogSetConstructor_" + element_id).style.top = popupTop > 0 ? popupTop + "px" : 0;
 },
                this)
        );
    }
} 


*/






BX.ready(function(){
    var Confirmer = new BX.PopupWindow("apiship_pvz", null, {
     content: '<div id="map" style="width:800px;height:500px"><!--div id="info"></div--></div>',
     closeIcon: {right: "20px", top: "10px"},
     titleBar: {content: BX.create("h3", {html: 'Список ПВЗ', 'props': {'className': 'access-title-bar'}})},
     zIndex: 0,
     offsetLeft: 0,
     offsetTop: 0,
     draggable: {restrict: false},
     overlay: {backgroundColor: 'black', opacity: '80' },  /* затемнение фона */
     /*buttons: [
      new BX.PopupWindowButton({
          text: "Перейти в корзину",
          className: "popup-window-button-accept",
          events: {click: function(){
           location.href="";
          }}
      }),
     ]*/
    });

    $('body').on('click','#lunohod_selectPVZ',function(){
	Confirmer.show();
	
     return false;
    });

});	
</script> 
<a name="order_form"></a>

<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>

<?
if (!function_exists("getColumnName"))
{
	function getColumnName($arHeader)
	{
		return (strlen($arHeader["name"]) > 0) ? $arHeader["name"] : GetMessage("SALE_".$arHeader["id"]);
	}
}

if (!function_exists("cmpBySort"))
{
	function cmpBySort($array1, $array2)
	{
		if (!isset($array1["SORT"]) || !isset($array2["SORT"]))
			return -1;

		if ($array1["SORT"] > $array2["SORT"])
			return 1;

		if ($array1["SORT"] < $array2["SORT"])
			return -1;

		if ($array1["SORT"] == $array2["SORT"])
			return 0;
	}
}
?>
<?CModule::IncludeModule("lunohod.dalliservice");
$cityId = ($_REQUEST["ORDER_PROP_5"])? $_REQUEST["ORDER_PROP_5"] : $arResult["ORDER_PROP"]["USER_PROPS_Y"]["5"]["VALUE"];
$data_id = LunohodDalliservice::getKladrCityId($cityId);?> 
<div class="bx_order_make">
	<?
	if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
	{
		if(!empty($arResult["ERROR"]))
		{
			foreach($arResult["ERROR"] as $v)
				echo ShowError($v);
		}
		elseif(!empty($arResult["OK_MESSAGE"]))
		{
			foreach($arResult["OK_MESSAGE"] as $v)
				echo ShowNote($v);
		}

		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
	}
	else
	{
		if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y" || $arResult["NEED_REDIRECT"] == "Y")
		{
			if(strlen($arResult["REDIRECT_URL"]) == 0)
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
			}
		}
		else
		{
			?>
			<script type="text/javascript">

			<?if(CSaleLocation::isLocationProEnabled()):?>

				<?
				// spike: for children of cities we place this prompt
				$city = \Bitrix\Sale\Location\TypeTable::getList(array('filter' => array('=CODE' => 'CITY'), 'select' => array('ID')))->fetch();
				?>

				BX.saleOrderAjax.init(<?=CUtil::PhpToJSObject(array(
					'source' => $this->__component->getPath().'/get.php',
					'cityTypeId' => intval($city['ID']),
					'messages' => array(
						'otherLocation' => '--- '.GetMessage('SOA_OTHER_LOCATION'),
						'moreInfoLocation' => '--- '.GetMessage('SOA_NOT_SELECTED_ALT'), // spike: for children of cities we place this prompt
						'notFoundPrompt' => '<div class="-bx-popup-special-prompt">'.GetMessage('SOA_LOCATION_NOT_FOUND').'.<br />'.GetMessage('SOA_LOCATION_NOT_FOUND_PROMPT', array(
							'#ANCHOR#' => '<a href="javascript:void(0)" class="-bx-popup-set-mode-add-loc">',
							'#ANCHOR_END#' => '</a>'
						)).'</div>'
					)
				))?>);

			<?endif?>

			var BXFormPosting = false;
			function submitForm(val)
			{
				if (BXFormPosting === true)
					return true;

				BXFormPosting = true;
				if(val != 'Y')
					BX('confirmorder').value = 'N';

				var orderForm = BX('ORDER_FORM');
				BX.showWait();

				<?if(CSaleLocation::isLocationProEnabled()):?>					
					BX.saleOrderAjax.cleanUp();
				<?endif?>
				BX.ajax.submit(orderForm, ajaxResult);
				
			
				return true;
			}

			function ajaxResult(res)
			{
				var orderForm = BX('ORDER_FORM');
				try
				{
					// if json came, it obviously a successfull order submit

					var json = JSON.parse(res);
					BX.closeWait();

					if (json.error)
					{
						BXFormPosting = false;
						return;
					}
					else if (json.redirect)
					{
						window.top.location.href = json.redirect;
					}
				}
				catch (e)
				{
					// json parse failed, so it is a simple chunk of html

					BXFormPosting = false;
					BX('order_form_content').innerHTML = res;

					<?if(CSaleLocation::isLocationProEnabled()):?>
						BX.saleOrderAjax.initDeferredControl();
					<?endif?>
				}
				
				BX.closeWait();
				$city = $('[name="ORDER_PROP_5"]'),
				$street = $('[name="ORDER_PROP_20"]'),
				$building = $('[name="ORDER_PROP_21"]');
				var $tooltip = $('.tooltip');
				
				

				$.kladr.setDefault({
					parentInput: '#ORDER_FORM',
					verify: true,
					select: function (obj) {
						setLabel($(this), obj.type);
						$tooltip.hide();
					},
					check: function (obj) {
						var $input = $(this);

						if (obj) {
							setLabel($input, obj.type);
							$tooltip.hide();
						}
						else {
							showError($input, 'Введено неверно');
						}
					},
					checkBefore: function () {
						var $input = $(this);

						if (!$.trim($input.val())) {
							$tooltip.hide();
							return false;
						}
					}
				});
				
				$city.kladr('type', $.kladr.type.city);
				$street.kladr('type', $.kladr.type.street);
				$building.kladr('type', $.kladr.type.building);

				// Отключаем проверку введённых данных для строений
				$building.kladr('verify', false);

				// Подключаем плагин для почтового индекса
				//$zip.kladrZip();

				function setLabel($input, text) {
					text = text.charAt(0).toUpperCase() + text.substr(1).toLowerCase();
					$input.parent().find('label').text(text);
				}

				function showError($input, message) {
					$tooltip.find('span').text(message);

					var inputOffset = $input.offset(),
						inputWidth = $input.outerWidth(),
						inputHeight = $input.outerHeight();

					var tooltipHeight = $tooltip.outerHeight();

					$tooltip.css({
						left: (inputOffset.left + inputWidth + 10) + 'px',
						top: (inputOffset.top + (inputHeight - tooltipHeight) / 2 - 1) + 'px'
					});

					$tooltip.show();
				}
				$('[name="ORDER_PROP_5"]').attr("data-kladr-id", $('[name="KladrCity"]').val());
				
				BX.onCustomEvent(orderForm, 'onAjaxSuccess');
			}

			function SetContact(profileId)
			{
				BX("profile_change").value = "Y";
				submitForm();
			}
			</script>
			<?if($_POST["is_ajax_post"] != "Y")
			{
				?><form action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="ORDER_FORM" enctype="multipart/form-data">
				<?=bitrix_sessid_post()?>
				<div id="order_form_content">
				<?
			}
			else
			{
				$APPLICATION->RestartBuffer();
			}

			if($_REQUEST['PERMANENT_MODE_STEPS'] == 1)
			{
				?>
				<input type="hidden" name="PERMANENT_MODE_STEPS" value="1" />
				<?
			}

			if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
			{
				foreach($arResult["ERROR"] as $v)
					echo ShowError($v);
				?>
				<script type="text/javascript">
					top.BX.scrollToNode(top.BX('ORDER_FORM'));
				</script>
				<?
			}

			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
			if ($arParams["DELIVERY_TO_PAYSYSTEM"] == "p2d")
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
			}
			else
			{
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
				include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
			}

			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/related_props.php");

			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
			if(strlen($arResult["PREPAY_ADIT_FIELDS"]) > 0)
				echo $arResult["PREPAY_ADIT_FIELDS"];
			?>

			<?if($_POST["is_ajax_post"] != "Y")
			{
				?>
					</div>
					<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
					<input type="hidden" name="profile_change" id="profile_change" value="N">
					<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
					<input type="hidden" name="json" value="Y">
					<div class="bx_ordercart_order_pay_center"><a href="javascript:void();" onclick="submitForm('Y'); return false;" id="ORDER_CONFIRM_BUTTON" class="checkout bt1 bt-big"><?=GetMessage("SOA_TEMPL_BUTTON")?></a></div>
				</form>
				<?
				if($arParams["DELIVERY_NO_AJAX"] == "N")
				{
					?>
					<div style="display:none;"><?$APPLICATION->IncludeComponent("bitrix:sale.ajax.delivery.calculator", "", array(), null, array('HIDE_ICONS' => 'Y')); ?></div>
					<?
				}
			}
			else
			{
				?>
				<script type="text/javascript">
					top.BX('confirmorder').value = 'Y';
					top.BX('profile_change').value = 'N';
				</script>
				<?
				die();
			}
		}
	}
	?>
	</div>
</div>

<??>
<?if(CSaleLocation::isLocationProEnabled()):?>

	<div style="display: none">
		<?// we need to have all styles for sale.location.selector.steps, but RestartBuffer() cuts off document head with styles in it?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.steps",
			".default",
			array(
			),
			false
		);?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.location.selector.search",
			".default",
			array(
			),
			false
		);?>
	</div>

<?endif?>