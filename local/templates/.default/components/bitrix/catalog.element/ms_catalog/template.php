<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
 
<div data-pid="<?=$arResult['ID']?>" class="bx_item_detail product horizontal <? echo $templateData['TEMPLATE_CLASS']; ?> p_id_<?=$arResult['ID']?>" id="<? echo $arItemIDs['ID']; ?>">
	<?if ('Y' == $arParams['DISPLAY_NAME']) {?>
		<div class="bx_item_title">
			<!-- Name -->
			<h1><span>
				<? echo (
					isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
					? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
					: $arResult["NAME"]
				); ?>
			</span></h1>

			<!-- Rating -->
			<?if ($arParams['USE_VOTE_RATING'] == 'Y') {?>
				<?$APPLICATION->IncludeComponent(
						"bitrix:iblock.vote",
						"ms_catalog",
						array(
							"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
							"IBLOCK_ID" => $arParams['IBLOCK_ID'],
							"ELEMENT_ID" => $arResult['ID'],
							"ELEMENT_CODE" => "",
							"MAX_VOTE" => "5",
							"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
							"SET_STATUS_404" => "N",
							"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
							"CACHE_TYPE" => $arParams['CACHE_TYPE'],
							"CACHE_TIME" => $arParams['CACHE_TIME']
						),
						$component,
						array("HIDE_ICONS" => "Y")
				);?>
			<?}?>
			<!-- End Rating -->
		</div>
	<?}?>

	<?
	reset($arResult['MORE_PHOTO']);
	$arFirstPhoto = current($arResult['MORE_PHOTO']);
	?>

	<div class="bx_item_container product-page">

		<!-- Slider -->
		<div class="bx_lt">
			<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
				<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
					<div class="bx_bigimages_imgcontainer">
						<div class="bx_bigimages_imgcontainer_in">
							<span class="bx_bigimages_aligner"></span>
							<img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>">
							<i class="zoom"></i>
							<span class="stickers">
								<?
								foreach ($arResult['DISPLAY_PROPERTIES'] as $arOneProp)
								{
									if($arOneProp["CODE"] == "NEWPRODUCT"){
									?><span class="sticker new" title="<?=GetMessage("NEW")?>"><?=GetMessage("NEW")?></span><?
									} elseif($arOneProp["CODE"] == "SALELEADER") {
									?><span class="sticker bestseller" title="<?=GetMessage("HIT")?>"><?=GetMessage("HIT")?></span><?
									}
								}

								unset($arResult['DISPLAY_PROPERTIES']['RECOMMEND']);
								unset($arResult['DISPLAY_PROPERTIES']['NEWPRODUCT']);
								unset($arResult['DISPLAY_PROPERTIES']['SALELEADER']);
								?>

								<?if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']) {?>
									<span id="<? echo $arResult['DSC_PERC']; ?>" class="sticker discount" style="display:<? echo (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">-<? echo $arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</span>
								<?}?>
							</span>
						</div>
					</div>
				</div>
			<?if ($arResult['SHOW_SLIDER']) {?>
				<?if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])) {?>
				<?
					if (5 < $arResult['MORE_PHOTO_COUNT'])
					{
						$strClass = 'bx_slider_conteiner full';
						$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
						$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
						$strSlideStyle = '';
					}
					else
					{
						$strClass = 'bx_slider_conteiner';
						$strOneWidth = '20%';
						$strWidth = '100%';
						$strSlideStyle = 'display: none;';
					}
				?>
				<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
					<div class="bx_slider_scroller_container">
						<div class="bx_slide">
							<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">    
								<?foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto) {?>
									<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><a rel="pp_gal" class="cnt_item" href="<? echo $arOnePhoto['SRC']; ?>" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></a></span></li>
								<?}?>
								<?unset($arOnePhoto)?>
							</ul>
						</div>
						<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
				</div>
				<?} else {?>
					<?foreach ($arResult['OFFERS'] as $key => $arOneOffer) {?>
						<?
						if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
							continue;
						$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
						if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
						{
							$strClass = 'bx_slider_conteiner full';
							$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
							$strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
							$strSlideStyle = '';
						}
						else
						{
							$strClass = 'bx_slider_conteiner';
							$strOneWidth = '20%';
							$strWidth = '100%';
							$strSlideStyle = 'display: none;';
						}
					?>
					<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
						<div class="bx_slider_scroller_container">
							<div class="bx_slide">
								<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
							<?
							foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto)
							{
							?>
									<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><a rel="pp_gal_<?= $arOneOffer['ID']; ?>" class="cnt_item" href="<? echo $arOnePhoto['SRC']; ?>" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></a></span></li>
							<?
							}
							unset($arOnePhoto);
							?>
								</ul>
							</div>
							<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
							<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
						</div>
					</div>
					<?}?>
				<?}?>
			<?}?>
			</div>
		</div>
		<!-- End Slider -->

		<div class="bx_rt">
			<?
			if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
			{
				$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
			}
			else
			{
				$canBuy = $arResult['CAN_BUY'];
			}

			$buyBtnMessage = ($arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
			$addToBasketBtnMessage = ($arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD'));
			$notAvailableMessage = ($arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
			$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
			$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);

			$showSubscribeBtn = false;
			$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE'));
			?>
			<div class="pp-rt">
				<!-- Product Buy -->
				<?if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {?>
					<div class="pp-buy-block clearfix">
						<div class="fl">
							<div class="item_price">
							<?
							$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
							$boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
							if ($arParams['SHOW_OLD_PRICE'] == 'Y')
							{
							?>
								<div class="item_old_price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo($boolDiscountShow ? '' : 'none'); ?>"><? echo($boolDiscountShow ? $minPrice['PRINT_VALUE'] : ''); ?></div>
							<?
							}
							?>
								<div class="item_current_price" id="<? echo $arItemIDs['PRICE']; ?>"><? echo $minPrice['PRINT_DISCOUNT_VALUE']; ?></div>
							<?
							if ($arParams['SHOW_OLD_PRICE'] == 'Y')
							{
								?>
								<div style="display:none;">
									<div class="item_economy_price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo($boolDiscountShow ? '' : 'none'); ?>"><? echo($boolDiscountShow ? GetMessage('CT_BCE_CATALOG_ECONOMY_INFO', array('#ECONOMY#' => $minPrice['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>
								</div>
							<?
							}
							?>
							</div>

							<div class="q_block">
								<div class="q_block_in">
									<a href="javascript:void(0)" class="button" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
									<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
											? 1
											: $arResult['CATALOG_MEASURE_RATIO']
										); ?>">
									<a href="javascript:void(0)" class="button" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
									<span class="bx_cnt_desc" id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : ''); ?></span>
								</div>
							</div>
						</div>
						<div class="fr">
							<div class="pp-buttons">



								<div class="pp-button-wrap">

									<?if ($canBuy) {?>
										<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
											<?
												if ($showBuyBtn)
												{
											?>
														<a href="javascript:void(0);" class="btn bt1 bt-big bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
											<?
												}
												if ($showAddBtn)
												{
											?>
														<a href="javascript:void(0);" class="btn bt1 bt-big bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
											<?
												}
											?>

											<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
										</span>
									<?} else {?>
										<a href="javascript:void(0);" class="btn bt-big none bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $notAvailableMessage ?></a>
									<?}?>
								</div>

								<?if($arParams["SHOW_ONECLICK"] == "Y"):?>
								<?endif?>

									<?if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {?>
										<div class="pp-button-wrap">
											<a href="<?=SITE_DIR?>oneclick.php" class="btn bt2 bt-big buy1click"><? echo GetMessage('ONECLICK'); ?></a>
										</div>
									<?} else {?>
										<?if ($arResult['CATALOG_QUANTITY'] > 0 || $arResult['CATALOG_CAN_BUY_ZERO'] == "Y") {?>
											<div class="pp-button-wrap">
												<a href="<?=SITE_DIR?>oneclick.php" class="btn bt2 bt-big buy1click"><? echo GetMessage('ONECLICK'); ?></a>
											</div>
										<?}?>
									<?}?>

							</div>
						</div>

						<div style="clear:both"></div>

						<div class="pp-buy-block-bottom clearfix">

							<?if('Y' == $arParams['DISPLAY_COMPARE']) {?>
						 		<a data-id="<?=$arResult['ID']?>" class="p_btn_compare fl">
									<span class="add"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></span>
									<span class="added"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARED'); ?></span>
								</a>
							<?}?>

							<!-- Quantity -->
								<?if ('Y' == $arParams['SHOW_MAX_QUANTITY']) {?>
								<?}?>

								<?if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])) {?>
									<?if($arResult["CATALOG_QUANTITY"] > 0) {?>
										<div class="quantity yes">
											<i></i>
											<?=GetMessage("QUANTITY_AVAILABLE")?>
										</div>
									<?} else {?>
										<div class="quantity">
											<i></i>
											<?=GetMessage("QUANTITY_NOT_AVAILABLE")?>
										</div>
									<?}?>
								<?} else {?>
									<div class="quantity"></div>
								<?}?>

							<!-- End Quantity -->
						</div>
					</div>
				<?} else {?>
					<div class="item_buttons vam">
						<span class="item_buttons_counter_block">
							<a href="javascript:void(0);" class="<? echo $buyBtnClass; ?>" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
							<?if ('Y' == $arParams['DISPLAY_COMPARE']) {?>
								<a id="<? echo $arItemIDs['COMPARE_LINK']; ?>" href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart"><? echo ('' != $arParams['MESS_BTN_COMPARE'] ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE')); ?></a>
							<?}?>
						</span>
					</div>
					<div style="clear:both"></div>

					<?if ($arParams['DISPLAY_COMPARE']) {?>
				 		<a data-id="<?=$arResult['ID']?>" class="p_btn_compare">
							<span class="add"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></span>
							<span class="added"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARED'); ?></span>
						</a>
					<?}?>
				<?}?>
				<!-- End Product Buy -->

				<!-- Properties -->
				<?if (!empty($arResult['DISPLAY_PROPERTIES'])) {?>
					<div class="artnumber">
						<?foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp) {?>
							<?if ($arOneProp["CODE"] == "ARTNUMBER") {?>
								<div><? echo $arOneProp['NAME']; ?>: </div><?
								echo '<div>', (
									is_array($arOneProp['DISPLAY_VALUE'])
									? implode(' / ', $arOneProp['DISPLAY_VALUE'])
									: $arOneProp['DISPLAY_VALUE']
								), '</div>';?>
							<?}?>
						<?}?>
						<?unset($arOneProp)?>
					</div>
				<?}?>
				<!-- End Properties -->

				<!-- Offers -->
				<?if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP'])) {?>
					<?
					$arSkuProps = array();
					?>
					<div class="pp_offers_list no-marker" id="<? echo $arItemIDs['PROP_DIV']; ?>">
						<?foreach ($arResult['SKU_PROPS'] as &$arProp) {?>
							<?
							if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
								continue;
							$arSkuProps[] = array(
								'ID' => $arProp['ID'],
								'SHOW_MODE' => $arProp['SHOW_MODE'],
								'VALUES_COUNT' => $arProp['VALUES_COUNT']
							);
							if ('TEXT' == $arProp['SHOW_MODE'])
							{
								if (5 < $arProp['VALUES_COUNT'])
								{
									$strClass = 'sku_dd';
									$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
									$strWidth = (20*$arProp['VALUES_COUNT']).'%';
									$strSlideStyle = '';
								}
								else
								{
									$strClass = 'sku_dd';
									$strOneWidth = '20%';
									$strWidth = '100%';
									$strSlideStyle = 'display: none;';
								}
							?>
							<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
								<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
								<div class="bx_size_scroller_container">
									<div class="dd_label"><span></span><i></i></div>
									<div class="bx_size">
										<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list">
											<?foreach ($arProp['VALUES'] as $arOneValue) {?>
												<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>" data-onevalue="<? echo $arOneValue['ID']; ?>"><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span></li>
											<?}?>
										</ul>
									</div>
									<div class="bx_slide_left" style="display: none;" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
									<div class="bx_slide_right" style="display: none;" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
								</div>
							</div>
							<?
							} elseif ('PICT' == $arProp['SHOW_MODE']) {
								if (5 < $arProp['VALUES_COUNT'])
								{
									$strClass = 'bx_item_detail_scu full';
									$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
									$strWidth = (20*$arProp['VALUES_COUNT']).'%';
									$strSlideStyle = '';
								}
								else
								{
									$strClass = 'bx_item_detail_scu';
									$strOneWidth = '20%';
									$strWidth = '100%';
									$strSlideStyle = 'display: none;';
								}
							?>
							<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
								<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
								<div class="bx_scu_scroller_container">
									<div class="bx_scu">
										<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
											<?foreach ($arProp['VALUES'] as $arOneValue) {?>
												<li
													data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>"
													data-onevalue="<? echo $arOneValue['ID']; ?>"
													style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
												><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
												<span class="cnt"><span class="cnt_item"
													style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
													title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
												></span></span></li>
											<?}?>
										</ul>
									</div>
									<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
									<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
								</div>
							</div>
							<?}?>
						<?}?>
						<?unset($arProp)?>
					</div>
				<?
				}
				?>
				<!-- End Offers -->
			</div>

			<div class="pp_center">
				<!-- Top Properties -->
				<?if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) {?>
					<div class="item_info_section">
						<?if (!empty($arResult['DISPLAY_PROPERTIES'])) {?>
							<div class="props_base">
							<?
							$i = 0;
							?>
							<?foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp) {?>
								<?
								if ($arOneProp["CODE"] !== "ARTNUMBER") {
								?>
									<?$i++?>
									<?if ($i <= 5) {?>
										<dl class="item">
  										<dt><? echo $arOneProp['NAME']; ?>: </dt>
                                        <?if ($arOneProp['ID'] == '131'){?>
                                            <dd><a href="/catalog/serii/<?=$arResult['GROUPS_ID_LINKING']["ID"]?>/"><?=$arResult['GROUPS_ID_LINKING']["SERIES_NAME"]?></a></dd>    
                                        <?} else {?>
                                            <?echo '<dd>', (is_array($arOneProp['DISPLAY_VALUE']) ? implode(' / ', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE']), '</dd>';?>
                                        <?}?>                                        
										</dl>
									<?}?>
								<?}?>
							<?}?>
							<?unset($arOneProp)?>
							</div>
						<?}?>

						<?if ($arResult['SHOW_OFFERS_PROPS']) {?>
							<div class="<? echo $arItemIDs['DISPLAY_PROP_DIV'] ?> props_short" style="display: none;"></div>
						<?}?>

						<?if (!empty($arResult['DISPLAY_PROPERTIES']) && count($arResult['DISPLAY_PROPERTIES']) >= 5 || $arResult['SHOW_OFFERS_PROPS']) {?>
							<div class="link-to-props">
								<a class="dotted" href="javascript:void(0);"><? echo GetMessage('ALL_PROPERTIES'); ?></a>
							</div>
						<?}?>
					</div>
				<?}?>
				<!-- End Top Properties -->

				<!-- Preview Text-->
				<?if ('' != $arResult['PREVIEW_TEXT']) {?>
					<?if ('S' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] || ('E' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] && '' == $arResult['DETAIL_TEXT'])) {?>
						<div class="item_info_section">
							<?=('html' == $arResult['PREVIEW_TEXT_TYPE'] ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>')?>
						</div>
					<?}?>
				<?}?>
				<!-- End Preview Text-->

				<!-- Brands-->
				<?$useBrands = ('Y' == $arParams['BRAND_USE'])?>
				<?if ($useBrands) {?>
					<div class="bx_optionblock">
						<?if ($useBrands) {?>
							<?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", "ms_catalog", array(
								"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
								"IBLOCK_ID" => $arParams['IBLOCK_ID'],
								"ELEMENT_ID" => $arResult['ID'],
								"ELEMENT_CODE" => "",
								"PROP_CODE" => $arParams['BRAND_PROP_CODE'],
								"CACHE_TYPE" => $arParams['CACHE_TYPE'],
								"CACHE_TIME" => $arParams['CACHE_TIME'],
								"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
								"WIDTH" => "",
								"HEIGHT" => ""
								),
								$component,
								array("HIDE_ICONS" => "N")
							);?>
						<?}?>
					</div>
				<?}?>
				<?unset($useBrands)?>
				<!-- End Brands -->
			</div>
			<div class="clb"></div>
		</div>

		<!-- Set -->
		<div class="bx_md">
			<div class="item_info_section">
				<?if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {?>
					<?if ($arResult['OFFER_GROUP']) {?>
						<?foreach ($arResult['OFFERS'] as $arOffer) {?>
							<?
							if (!$arOffer['OFFER_GROUP'])
								continue;
							?>
							<span id="<? echo $arItemIDs['OFFER_GROUP'].$arOffer['ID']; ?>" style="display: none;">
								<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
									"ms_catalog",
									array(
										"IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
										"ELEMENT_ID" => $arOffer['ID'],
										"PRICE_CODE" => $arParams["PRICE_CODE"],
										"BASKET_URL" => $arParams["BASKET_URL"],
										"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
										"CACHE_TYPE" => $arParams["CACHE_TYPE"],
										"CACHE_TIME" => $arParams["CACHE_TIME"],
										"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
									),
									$component,
									array("HIDE_ICONS" => "Y")
								);?>
							</span>
						<?}?>
					<?}?>
				<?} else {?>
					<?if ($arResult['MODULES']['catalog']) {?>
						<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
							"ms_catalog",
							array(
								"IBLOCK_ID" => $arParams["IBLOCK_ID"],
								"ELEMENT_ID" => $arResult["ID"],
								"PRICE_CODE" => $arParams["PRICE_CODE"],
								"BASKET_URL" => $arParams["BASKET_URL"],
								"CACHE_TYPE" => $arParams["CACHE_TYPE"],
								"CACHE_TIME" => $arParams["CACHE_TIME"],
								"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
							),
							$component,
							array("HIDE_ICONS" => "Y")
						);?>
					<?}?>
				<?}?>
			</div>
		</div>
		<!-- End Set -->

		<!-- Tabs -->
		<div class="tabsblock not_adaptiv">
			<div class="clearfix">
				<div class="tabs">
					<?if ('' != $arResult['DETAIL_TEXT']) {?>
						<a href="#detail-text"><? echo GetMessage('FULL_DESCRIPTION'); ?></a>
					<?}?>

					<?if (!empty($arResult['DISPLAY_PROPERTIES'])) {?>
						<a href="#props"><? echo GetMessage('FULL_PROPERTIES'); ?></a>
					<?}?>

					<?/**if (!empty($arResult['DISPLAY_PROPERTIES']['FILES'])) {?>
						<a href="#files"><? echo GetMessage('TABS_FILES'); ?></a>
					<?}**/?>

					<?if ('Y' == $arParams['USE_COMMENTS']) {?>
						<a href="#comments"><? echo GetMessage('COMMENTS'); ?></a>
					<?}?>

					<?if ('Y' == $arParams['USE_STORE']) {?>
						<a href="#stores"><? echo GetMessage('STORES'); ?></a>
					<?}?>
				</div>
			</div>

			<div class="tabcontent">
				<!-- Detail text content -->
				<?if ('' != $arResult['DETAIL_TEXT']) {?>
					<div class="tab" id="tab-detail-text">
						<div class="bx_item_description">
							<?if ('html' == $arResult['DETAIL_TEXT_TYPE']) {?>
								<?=$arResult['DETAIL_TEXT']?>
							<?} else {?>
								<p><?=$arResult['DETAIL_TEXT']?></p>
							<?}?>
						</div>
					</div>
				<?}?>
				<!-- End Detail text content -->
                                                            
				<!-- Properties tab content -->
				<?if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS']) {?>
					<div class="tab" id="tab-props">
						<div class="properties clearfix">
							<?if (!empty($arResult['DISPLAY_PROPERTIES'])) {?>
								<?foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp) {?>
									<?if($arOneProp["CODE"] !== "RECOMMEND"
										&& $arOneProp["CODE"] !== "NEWPRODUCT"
										&& $arOneProp["CODE"] !== "SALELEADER"){?>
										<dl class="item">
											<dt><? echo $arOneProp['NAME']; ?></dt>
											<dd>
                                                <?if ($arOneProp['ID'] == '131'){?>
                                                    <a href="/catalog/serii/<?=$arResult['GROUPS_ID_LINKING']["ID"]?>/"><?=$arResult['GROUPS_ID_LINKING']["SERIES_NAME"]?></a>    
                                                <?} else {?>
                                                    <?echo (is_array($arOneProp['DISPLAY_VALUE']) ? implode(' / ', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE']);?>
                                                <?}?>
												<?/*=(is_array($arOneProp['DISPLAY_VALUE']) ? implode(' / ', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE'])*/?>
											</dd>
										</dl>
									<?}?>
								<?}?>
							<?unset($arOneProp)?>
							<?}?>
              <?if ($arResult['SHOW_OFFERS_PROPS']) {?>
                <div class="<? echo $arItemIDs['DISPLAY_PROP_DIV'] ?>" style="display: none;"></div>
              <?}?>
						</div>
					</div>
				<?}?>
				<!-- End Properties tab content  -->

				<!-- Files tab content -->
				<?/**if (!empty($arResult['DISPLAY_PROPERTIES']['FILES'])) {?>
					<div class="tab" id="tab-files">
						<?
						echo $arResult['DISPLAY_PROPERTIES']['FILES']['FILE_VALUE']['ORIGINAL_NAME'];
						echo $arResult['DISPLAY_PROPERTIES']['FILES']['DISPLAY_VALUE'];
						?>
					</div>
				<?}**/?>
				<!-- End Files tab content  -->

				<!-- Comments content -->
				<?if ('Y' == $arParams['USE_COMMENTS']) {?>
					<div class="tab" id="tab-comments">
						<div class="tab-section-container">
							<?$APPLICATION->IncludeComponent(
								"bitrix:catalog.comments",
								"ms_catalog",
								array(
									"ELEMENT_ID" => $arResult['ID'],
									"ELEMENT_CODE" => "",
									"IBLOCK_ID" => $arParams['IBLOCK_ID'],
									"URL_TO_COMMENT" => "",
									"WIDTH" => "",
									"COMMENTS_COUNT" => "5",
									"BLOG_USE" => $arParams['BLOG_USE'],
									"FB_USE" => $arParams['FB_USE'],
									"FB_APP_ID" => $arParams['FB_APP_ID'],
									"VK_USE" => $arParams['VK_USE'],
									"VK_API_ID" => $arParams['VK_API_ID'],
									"CACHE_TYPE" => $arParams['CACHE_TYPE'],
									"CACHE_TIME" => $arParams['CACHE_TIME'],
									"BLOG_TITLE" => "",
									"BLOG_URL" => $arParams['BLOG_URL'],
									"PATH_TO_SMILE" => "",
									"EMAIL_NOTIFY" => "N",
									"AJAX_POST" => "Y",
									"SHOW_SPAM" => "Y",
									"SHOW_RATING" => "N",
									"FB_TITLE" => "",
									"FB_USER_ADMIN_ID" => "",
									"FB_COLORSCHEME" => "light",
									"FB_ORDER_BY" => "reverse_time",
									"VK_TITLE" => "",
								),
								$component,
								array("HIDE_ICONS" => "Y")
							);?>
						</div>
					</div>
				<?}?>
				<!-- End Comments content -->

				<!-- Stores content -->
				<?if ('Y' == $arParams['USE_STORE']) {?>
					<div class="tab" id="tab-stores">
						<div class="tab-section-container">
								<?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", "ms_catalog", array(
									"ELEMENT_ID" => $arResult['ID'],
									"STORE_PATH" => $arParams['STORE_PATH'],
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "36000",
									"MAIN_TITLE" => $arParams['MAIN_TITLE'],
									"USE_MIN_AMOUNT" =>  $arParams['USE_MIN_AMOUNT'],
									"MIN_AMOUNT" => $arParams['MIN_AMOUNT'],
									"STORES" => $arParams['STORES'],
									"SHOW_EMPTY_STORE" => $arParams['SHOW_EMPTY_STORE'],
									"SHOW_GENERAL_STORE_INFORMATION" => $arParams['SHOW_GENERAL_STORE_INFORMATION'],
									"USER_FIELDS" => $arParams['USER_FIELDS'],
									"FIELDS" => $arParams['FIELDS']
								),
								$component,
								array("HIDE_ICONS" => "Y")
								);?>
						</div>
					</div>
				<?}?>
				<!-- End Stores content -->
			</div>
		</div>
		<!-- End Tabs -->

		<div style="clear: both;"></div>
	</div>
	<div class="clb"></div>
</div>

<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dl class="item"><dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd></dl>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
} else {?>
	<?$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES'])?>
	<?if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties) {?>
		<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
			<?if (!empty($arResult['PRODUCT_PROPERTIES_FILL'])) {?>
				<?foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) {?>
					<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
					<?
					if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
						unset($arResult['PRODUCT_PROPERTIES'][$propID]);
					?>
				<?}?>

			<?}?>

			<?$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES'])?>

			<?if (!$emptyProductProperties) {?>
				<table>
					<?foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo) {?>
						<tr>
							<td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
							<td>
								<?if('L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']) {?>
									<?foreach($propInfo['VALUES'] as $valueID => $value) {?>
										<label>
											<input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>"<? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?>
										</label>
										<br>
									<?}?>
								<?} else {?>
									<select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
										foreach($propInfo['VALUES'] as $valueID => $value) {?>
										<option value="<? echo $valueID; ?>"<? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option>
										<?}?>
									</select>
								<?}?>
							</td>
						</tr>
					<?}?>
				</table>
			<?}?>
		</div>
	<?}?>

	<!-- JS Params -->
	<?
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);
}?>

	<script type="text/javascript">
	var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
	</script>
	<!-- End JS Params -->

<!-- BX Message -->
<script type="text/javascript">
BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',

	TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('BTN_MESSAGE_CLOSE') ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('BTN_MESSAGE_BASKET_REDIRECT') ?>',

	QUANTITY_NOT_AVAILABLE: '<? echo GetMessageJS('QUANTITY_NOT_AVAILABLE') ?>',
	QUANTITY_AVAILABLE: '<? echo GetMessageJS('QUANTITY_AVAILABLE') ?>'
});
</script>
<!-- End BX Message -->

<script type="text/javascript">
var ItemJsCompare_<?=$arResult['ID']?> = {
	ID:"<?=$arResult['ID']?>",
	productName:"<? echo $arResult['NAME']; ?>",
	productImg:"<? echo $arFirstPhoto['SRC']; ?>"
};
</script>
