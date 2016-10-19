<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>

<div class="slider-wrapper theme-main-slider">
	<div id="slider" class="nivoSlider">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>

			<?if($arItem["FIELDS"]["PREVIEW_PICTURE"] || $arItem["FIELDS"]["DETAIL_PICTURE"]) {?>
				<?
				if($arItem["FIELDS"]["PREVIEW_PICTURE"]) {
					$picture = $arItem["FIELDS"]["PREVIEW_PICTURE"]["SRC"];
				} elseif($arItem["FIELDS"]["DETAIL_PICTURE"]) {
					$picture = $arItem["FIELDS"]["DETAIL_PICTURE"]["SRC"];
				}
				?>

				<a href="<?=$arItem["DISPLAY_PROPERTIES"]["PROP_URL"]["VALUE"]?>"><img src="<?=$picture?>" alt="<?=$arItem["NAME"]?>"/></a>
			<?}?>
		<?endforeach;?>
	</div>
</div>
