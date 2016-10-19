<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>

<div class="product_page">
	<div class="row">

		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
			<div class="col-xs-6 col-sm-5 p_images">
				<div class="main_img">
					<div class="img_middle">
						<a class="img_middle_in" href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>">
							<img class="img-responsive" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>">
						</a>
					</div>
				</div>

				<div class="thumbs">
					<ul class="list-unstyled clearfix row">
						<li class="active">
							<div class="img_middle">
								<a class="img_middle_in" href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["NAME"]?>"></a>
							</div>
						</li>
					<?if(!empty($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"])) {?>
						<?foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $arPhoto) {?>
							<?$arFile = array();?>
							<?$arFile = CFile::GetFileArray($arPhoto);?>
							<li>
								<div class="img_middle">
									<a class="img_middle_in" href="<?echo($arFile["SRC"]);?>"><img src="<?echo($arFile["SRC"]);?>" alt=""></a>
								</div>
							</li>
						<?}?>
					<?}?>
					</ul>
				</div>

				<script type="text/javascript">
					var pp_gallery = [
						{href : '<?=$arResult["DETAIL_PICTURE"]["SRC"]?>'},
						<?foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $arPhoto) {?>
							<?$arFile = CFile::GetFileArray($arPhoto);?>
							<?echo "{href : '".$arFile['SRC']."'},";?>
						<?}?>
					];
				</script>

			</div>
		<?endif?>

		<div class="col-xs-6 col-sm-7 p_side">
			<ul class="short_specs no-marker">
			<?foreach ($arResult["PROPERTIES"] as $arProp) {?>
				<?if($arProp["CODE"] !== "PRICE" && $arProp["CODE"] !== "CURRENCY" && $arProp["CODE"] !== "MORE_PHOTO") {?>
					<li>
					<?echo $arProp["NAME"]?>:
					<?echo $arProp["VALUE"]?>
					</li>
				<?}?>
			<?}?>
			</ul>

			<?if($arResult["PREVIEW_TEXT"]):?>
				<div class="shot_descr"><?=$arResult["PREVIEW_TEXT"];?></div>
			<?endif;?>

			<?if($arResult["PROPERTIES"]["PRICE"]["VALUE"]) {?>
				<div class="price">
					<?echo $arResult["PROPERTIES"]["PRICE"]["VALUE"];?>
					<?echo $arResult["PROPERTIES"]["CURRENCY"]["VALUE"];?>
				</div>
			<?}?>

			<div class="buy_btn_wrap">
				<button class="btn btn-primary btn-sm buy_btn" type="button" data-url="<?=SITE_DIR?>ajax/order_form.php" data-name="<?=$arResult['NAME']?>" data-id="<?=$arResult['ID']?>"><?=GetMessage('PRODUCT_ORDER_BUTTON')?></button>
			</div>
		</div>

	</div>

	<?if(strlen($arResult["DETAIL_TEXT"])>0):?>
	<div class="p_bottom">
		<div class="full_descr">
			<h4><?=GetMessage('PRODUCT_DESCRIPTION_TITLE')?></h4>
			<?echo $arResult["DETAIL_TEXT"];?>
		</div>
	</div>
	<?endif?>
</div>
