<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$frame = $this->createFrame()->begin('');?>

<div class="fp_compare">
		<i></i>
		<a rel="nofollow" class="dotted" href="<?=$arParams["COMPARE_URL"]?>"><?=GetMessage("CATALOG_COMPARE_ELEMENTS")?></a>
		<b><?=count($arResult)?></b>

		<script type="text/javascript">
		BX.message({
			C_TITLE: '<? echo GetMessageJS('C_TITLE') ?>',
			C_BTN_TEXT: '<? echo GetMessageJS('C_BTN_TEXT') ?>',
			C_BTN_LINK: '<?=$arParams["COMPARE_URL"]?>',
			C_BTN_CONTINUE: '<?=GetMessage("C_BTN_CONTINUE")?>'
		});
		</script>
</div>

<?$frame->end();?>
