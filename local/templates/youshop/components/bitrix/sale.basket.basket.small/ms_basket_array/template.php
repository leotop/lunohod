<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$frame = $this->createFrame()->begin('');?>

<?
if ($arResult["READY"]=="Y" || $arResult["DELAY"]=="Y" || $arResult["NOTAVAIL"]=="Y" || $arResult["SUBSCRIBE"]=="Y")
{
	if ($arResult["READY"]=="Y")
	{
		$inCartIDs = array();

		foreach ($arResult["ITEMS"] as &$v)
		{
			if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
			{
				array_push($inCartIDs, $v["PRODUCT_ID"]);
			}
		}
		if (isset($v))
			unset($v);
	}
}
$inCartJsArr = json_encode($inCartIDs);
?>

<script type="text/javascript">
	var inCartIDs = <?=$inCartJsArr?>;

	if(inCartIDs == null || typeof inCartIDs == 'undefined'){
		var inCartIDs = [];
	}

	BX.message({
		BTN_INCART: '<? echo GetMessageJS('BTN_INCART') ?>'
	});

	function inCart(checkID){
		if(inCartIDs !== null && typeof inCartIDs !== 'undefined'){
			if(checkID){
				isId = false;
				for (i = 0; i <= inCartIDs.length; i++) {
					if(checkID == inCartIDs[i]){
						isId = true;
						break;
					}
				}
				return isId;
			}
			else{
				$('.product').removeClass('incart');
				for (i = 0; i <= inCartIDs.length; i++) {
					$('[data-pid="'+inCartIDs[i]+'"]').addClass('incart').find('.bx_cart').removeClass('bt1').addClass('bt3').attr('href',cartURL).text(BX.message('BTN_INCART'));
				}
			}
		}
	}

	function inCartAdd(id){
		if(inCartIDs !== null && typeof inCartIDs !== 'undefined'){
			inCartIDs.push(id);
		}
	}

	BX.ready(function() {
    inCart();
  });
</script>

<?$frame->end();?>
