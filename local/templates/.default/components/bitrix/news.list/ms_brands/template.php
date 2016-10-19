<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>

<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

<div class="list products view-grid">

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N"):?>
			<?if($arItem["FIELDS"]["PREVIEW_PICTURE"] || $arItem["FIELDS"]["DETAIL_PICTURE"]):?>
				<?
				if($arItem["FIELDS"]["PREVIEW_PICTURE"]) {
					$picture = $arItem["FIELDS"]["PREVIEW_PICTURE"]["SRC"];
				} elseif($arItem["FIELDS"]["DETAIL_PICTURE"]) {
					$picture = $arItem["FIELDS"]["DETAIL_PICTURE"]["SRC"];
				}
				?>
				<div class="img img_middle">
					<a class="img_middle_in" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$picture?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>"></a>
				</div>	
			<?endif?>	
		<?endif?>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<div class="link"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></div>
			<?else:?>
				<b><?echo $arItem["NAME"]?></b><br />
			<?endif;?>
		<?endif;?>
		<div class="price"><?=$arItem["DISPLAY_PROPERTIES"]["PRICE"]["VALUE"]?> <?=$arItem["DISPLAY_PROPERTIES"]["CURRENCY"]["VALUE"]?></div>
	</div>
<?endforeach;?>

</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>