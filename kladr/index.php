<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?=$_SERVER["DOCUMENT_ROOT"]?>
<?$APPLICATION->SetAdditionalCSS("/kladr/jquery.kladr.min.css"); 
$APPLICATION->AddHeadScript("/kladr/jquery.kladr.min.js");?>
<script>
$(function () {
	var $zip = $('[name="zip"]'),
		$region = $('[name="region"]'),
		$district = $('[name="district"]'),
		$city = $('[name="city"]'),
		$street = $('[name="street"]'),
		$building = $('[name="building"]');

	var $tooltip = $('.tooltip');

	$.kladr.setDefault({
		parentInput: '.js-form-address',
		verify: true,
		//parentType: 'city',
		//parentId: 12,
		select: function (obj) {
			setLabel($(this), obj.type);
			$tooltip.hide();
			console.log($city.kladr);
			console.log($.kladr.type.city)
			//console.log($.kladr.parentId)
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

	$region.kladr('type', $.kladr.type.region);
	$district.kladr('type', $.kladr.type.district);
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
});
</script>
<?CModule::IncludeModule("lunohod.dalliservice");
$data = array("query"=>"Москва", "limit"=>1, "contentType"=>"city");
$json = LunohodDalliservice::get_json("http://kladr-api.ru/api.php", $data);
$arrRequest = (json_decode($json, true));
echo $arrRequest["result"]["0"]["id"];?>
<form class="js-form-address">
	<div class="field">
		<label>Индекс</label>
		<input type="text" name="zip">
	</div>
	<div class="field">
		<label>Регион</label>
		<input type="text" name="region">
	</div>
	<div class="field">
		<label>Район</label>
		<input type="text" name="district">
	</div>
	<div class="field">
		<label>Город</label>
		<input type="text" data-kladr-id="<?=$arrRequest["result"]["0"]["id"];?>" name="city" value="Вологда">
	</div>
	<div class="field">
		<label>Улица</label>
		<input type="text" name="street">
	</div>
	<div class="field">
		<label>Дом</label>
		<input type="text" name="building">
	</div>
	<div class="tooltip" style="display: none;"><b></b><span></span></div>
</form>
<?$arLocs = CSaleLocation::GetByID(1256, LANGUAGE_ID);
print_r($arLocs);?>
<script>

//console.log($.kladr);

setTimeout(foo, 10000);
function foo(){
	$('[name="city"]').trigger( "click" );
	$('[name="street"]').trigger( "click" );
}
$('[name="city"]').val("<?=$arLocs["CITY_NAME"]?>");

</script>


CITY_NAME?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>