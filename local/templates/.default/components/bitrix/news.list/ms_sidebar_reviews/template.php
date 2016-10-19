<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (count($arResult["ITEMS"]) < 1)
	return;
?>

<div class="side-block side-articles">
	<div class="title"><a href="<?=SITE_DIR?>reviews/"><?=GetMessage("REVIEWS_TITLE")?></a></div>
	<div class="side-block-in">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<div class="item clearfix">
			    <?if(!empty($arItem["PREVIEW_PICTURE"]["SRC"])):?>
					<div class="col-1">
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="img">
							<img class="item_img" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"/>
						</a>
					</div>					
                <?endif?>
				<div class="col-2">
					<a class="item_title" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
						<?=(strlen($arItem["NAME"])> 0 ? $arItem["NAME"] : $arItem["PREVIEW_TEXT"])?>
					</a>
				</div>
			</div>
		<?endforeach;?>
	</div>
</div>