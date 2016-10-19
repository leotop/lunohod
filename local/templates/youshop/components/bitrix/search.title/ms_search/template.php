<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
<div class="top-<?echo $CONTAINER_ID?>" id="<?echo $CONTAINER_ID?>">
<div class="search-block">
	<form action="<?echo $arResult["FORM_ACTION"]?>">
		<input class="search-field" placeholder="<? echo GetMessage('CT_BST_SEARCH_BUTTON'); ?>" id="<?echo $INPUT_ID?>" type="text" name="q" value="" autocomplete="off"/>
		<input class="search-btn" name="s" type="submit" value=""/>		
	</form>
</div>
</div>
<?endif?>
<script type="text/javascript">
var jsControl_<?echo md5($CONTAINER_ID)?> = new JCTitleSearch({
	//'WAIT_IMAGE': '/bitrix/themes/.default/images/wait.gif',
	'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
	'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
	'INPUT_ID': '<?echo $INPUT_ID?>',
	'MIN_QUERY_LEN': 2
});

<?if (isset($_REQUEST["q"])):?>
BX.ready(function(){
	if(BX('.search-page').length){
		BX("<?=$INPUT_ID?>").value = "<?=CUtil::JSEscape($_REQUEST["q"])?>";
	}
});
<?endif?>
</script>
