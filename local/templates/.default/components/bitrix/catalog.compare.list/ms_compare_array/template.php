<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$frame = $this->createFrame()->begin('');?>
	<?
	$inCompare = array();

	foreach($arResult as $key=>$arElement){
		array_push($inCompare, $arElement["ID"]);
	}

	$inCompare = json_encode($inCompare);
	?>

	<script type="text/javascript">
		var compareIDs = <?=$inCompare?>;
		for (i = 0; i <= compareIDs.length; i++) {
			$('.p_btn_compare[data-id="'+compareIDs[i]+'"]').addClass('active');
		}
	</script>
<?$frame->end();?>
