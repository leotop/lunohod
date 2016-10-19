<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>

<div class="bx_news_detail">
    <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
    <h1><?=$arResult["NAME"]?></h1>
    <?endif;?>
    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
    <div class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div><br>
    <?endif;?>
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
	<a class="detail_picture fancybox" href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>">
		<img border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	</a>
	<?endif?>
	<p>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
 	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
 	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	</p>
</div>