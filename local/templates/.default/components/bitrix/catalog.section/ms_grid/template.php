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
if (!empty($arResult['ITEMS']))
{
	$templateLibrary = array('popup');
	$currencyList = '';
	if (!empty($arResult['CURRENCIES']))
	{
		$templateLibrary[] = 'currency';
		$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
	}
	$templateData = array(
		// 'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
		// 'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
		'TEMPLATE_LIBRARY' => $templateLibrary,
		'CURRENCIES' => $currencyList
	);
	unset($currencyList, $templateLibrary);

	$arSkuTemplate = array();
	if (!empty($arResult['SKU_PROPS']))
	{
		foreach ($arResult['SKU_PROPS'] as &$arProp)
		{
			ob_start();
			if ('TEXT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'sku_dd';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'sku_dd';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				?>
				<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
					<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
					<div class="bx_size_scroller_container">
						<div class="dd_label"><span></span><i></i></div>
						<div class="bx_size">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
							foreach ($arProp['VALUES'] as $arOneValue)
							{
								?><li
									data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>;"
								><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span></li><?
							}
							?>
							</ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
				</div>
			<?
			}
			elseif ('PICT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_scu full';
					$strWidth = ($arProp['VALUES_COUNT']*20).'%';
					$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_scu';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				?>
				<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
					<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
					<div class="bx_scu_scroller_container">
						<div class="bx_scu">
							<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;">
							<?
							foreach ($arProp['VALUES'] as $arOneValue)
							{
								?><li
									data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>"
									data-onevalue="<? echo $arOneValue['ID']; ?>"
									style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
									><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
									<span class="cnt"><span class="cnt_item"
									style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
									title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
								></span></span></li><?
							}
							?>
							</ul>
						</div>
						<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
				</div>
			<?
			}
			$arSkuTemplate[$arProp['CODE']] = ob_get_contents();
			ob_end_clean();
		}
		unset($arProp);
	}

	if ($arParams["DISPLAY_TOP_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}

	$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
	$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
	$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?>

<div class="bx_catalog_grid col<? echo $arParams['LINE_ELEMENT_COUNT']; ?>">
	<?
	foreach ($arResult['ITEMS'] as $key => $arItem)
	{
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
		$strMainID = $this->GetEditAreaId($arItem['ID']);

		$arItemIDs = array(
			'ID' => $strMainID,
			'PICT' => $strMainID.'_pict',
			'SECOND_PICT' => $strMainID.'_secondpict',
			'STICKER_ID' => $strMainID.'_sticker',
			'SECOND_STICKER_ID' => $strMainID.'_secondsticker',
			'QUANTITY' => $strMainID.'_quantity',
			'QUANTITY_DOWN' => $strMainID.'_quant_down',
			'QUANTITY_UP' => $strMainID.'_quant_up',
			'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
			'BUY_LINK' => $strMainID.'_buy_link',
			'BASKET_ACTIONS' => $strMainID.'_basket_actions',
			'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
			'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
			'COMPARE_LINK' => $strMainID.'_compare_link',

			'PRICE' => $strMainID.'_price',
			'DSC_PERC' => $strMainID.'_dsc_perc',
			'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
			'PROP_DIV' => $strMainID.'_sku_tree',
			'PROP' => $strMainID.'_prop_',
			'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
			'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
		);

		$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);

		$strTitle = (
			isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]) && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
			? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
			: $arItem['NAME']
		);
		$stock = '';
		if ((!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) && !$arItem['CAN_BUY'])
		{
			$stock = 'no_stock';
		}
		?>

		<div data-pid="<?=$arItem['ID']?>" class="product <? echo ($arItem['SECOND_PICT'] ? 'bx_catalog_item double' : 'bx_catalog_item'); ?> <?=$stock?>">
			<div class="bx_catalog_item_container" id="<? echo $strMainID; ?>">

				<!-- Picture -->
				<a id="<? echo $arItemIDs['PICT']; ?>" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" class="bx_catalog_item_images" style="background-image: url(<? echo $arItem['PREVIEW_PICTURE']['SRC']; ?>)" title="<? echo $strTitle; ?>">
					<span class="stickers">
						<?foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp) {?>
							<?if($arOneProp["CODE"] == "NEWPRODUCT") {?>
								<span class="sticker new" title="<?=GetMessage("NEW")?>"><?=GetMessage("NEW")?></span>
							<?} elseif($arOneProp["CODE"] == "SALELEADER") {?>
								<span class="sticker bestseller" title="<?=GetMessage("HIT")?>"><?=GetMessage("HIT")?></span><?
							}?>
						<?}?>

						<?if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']) {?>
							<span
								id="<? echo $arItemIDs['DSC_PERC']; ?>"
								class="sticker discount"
								style="display:<? echo (0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">
								-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%
							</span>
						<?}?>
					</span>
				</a>
				<?if ($arItem['SECOND_PICT']) {?>
					<a id="<? echo $arItemIDs['SECOND_PICT']; ?>"
							href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"
							class="bx_catalog_item_images_double"
							style="background-image: url(<? echo (!empty($arItem['PREVIEW_PICTURE_SECOND']) ? $arItem['PREVIEW_PICTURE_SECOND']['SRC'] : $arItem['PREVIEW_PICTURE']['SRC']); ?>)"
							title="<? echo $strTitle; ?>">

						<span class="stickers">
							<?foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp) {?>
								<?
								if($arOneProp["CODE"] == "NEWPRODUCT"){
								?><span class="sticker new" title="<?=GetMessage("NEW")?>"><?=GetMessage("NEW")?></span><?
								} elseif($arOneProp["CODE"] == "SALELEADER") {
								?><span class="sticker bestseller" title="<?=GetMessage("HIT")?>"><?=GetMessage("HIT")?></span><?
								}
								?>
							<?}?>

							<?if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']) {?>
								<span
									id="<? echo $arItemIDs['DSC_PERC']; ?>"
									class="sticker discount"
									style="display:<? echo (0 < $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ? '' : 'none'); ?>;">
									-<? echo $arItem['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%
								</span>
							<?}?>
						</span>
					</a>
				<?}?>
				<!-- End Picture -->

				<!-- Title -->
				<div class="bx_catalog_item_title">
					<a href="<? echo $arItem['DETAIL_PAGE_URL']; ?>" title="<? echo $arItem['NAME']; ?>"><? echo $arItem['NAME']; ?></a>
				</div>
				<!-- End Title -->

				<!-- Quantity -->
				<?if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) {?>
					<?if($arItem["CATALOG_QUANTITY"] > 0) {?>
						<div class="quantity yes">
							<i></i>
							<?=GetMessage("QUANTITY_AVAILABLE")?>
						</div>
					<?} else {?>
						<div class="quantity">
						<?=GetMessage("QUANTITY_NOT_AVAILABLE")?>
						</div>
					<?}?>
				<?} else {?>
					<div class="quantity"></div>
				<?}?>
				<!-- End Quantity -->

				<!-- Price -->
				<div class="bx_catalog_item_price">
					<div id="<? echo $arItemIDs['PRICE']; ?>" class="bx_price">
						<?if (!empty($arItem['MIN_PRICE'])) {?>
							<?if ('N' == $arParams['PRODUCT_DISPLAY_MODE'] && isset($arItem['OFFERS']) && !empty($arItem['OFFERS'])) {
								echo GetMessage(
									'CT_BCS_TPL_MESS_PRICE_SIMPLE_MODE',
									array(
										'#PRICE#' => $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
										'#MEASURE#' => GetMessage(
											'CT_BCS_TPL_MESS_MEASURE_SIMPLE_MODE',
											array(
												'#VALUE#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_RATIO'],
												'#UNIT#' => $arItem['MIN_PRICE']['CATALOG_MEASURE_NAME']
											)
										)
									)
								);?>
							<?} else {?>
								<?if($arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] !== $arItem['MIN_PRICE']['PRINT_VALUE']) {?>
									<div class="new_price"><?echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];?></div>
								<?} else {?>
									<?echo $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];?>
								<?}?>
							<?}?>

							<?if ('Y' == $arParams['SHOW_OLD_PRICE'] && $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE']) {?>
								<span><? echo $arItem['MIN_PRICE']['PRINT_VALUE']; ?></span>
							<?}?>
						<?}?>
					</div>
				</div>
				<!-- End Price -->

				<!-- PRODUCT_DISPLAY_MODE -->
				<?if ('Y' == $arParams['PRODUCT_DISPLAY_MODE']) {
          if (!empty($arItem['OFFERS_PROP'])) {
  					$arSkuProps = array();
  					?>
  					<div class="bx_catalog_item_scu" id="<? echo $arItemIDs['PROP_DIV']; ?>"><?
  					foreach ($arSkuTemplate as $code => $strTemplate)
  					{
  						if (!isset($arItem['OFFERS_PROP'][$code]))
  							continue;
  						echo '<div>', str_replace('#ITEM#_prop_', $arItemIDs['PROP'], $strTemplate), '</div>';
  					}
  					foreach ($arResult['SKU_PROPS'] as $arOneProp)
  					{
  						if (!isset($arItem['OFFERS_PROP'][$arOneProp['CODE']]))
  							continue;
  						$arSkuProps[] = array(
  							'ID' => $arOneProp['ID'],
  							'SHOW_MODE' => $arOneProp['SHOW_MODE'],
  							'VALUES_COUNT' => $arOneProp['VALUES_COUNT']
  						);
  					}
  					foreach ($arItem['JS_OFFERS'] as &$arOneJs)
  					{
  						if (0 < $arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'])
  							$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'] = '-'.$arOneJs['PRICE']['DISCOUNT_DIFF_PERCENT'].'%';
  					}
  					unset($arOneJs);
  					?></div>

  					<?
  					if ($arItem['OFFERS_PROPS_DISPLAY'])
  					{
  						foreach ($arItem['JS_OFFERS'] as $keyOffer => $arJSOffer)
  						{
  							$strProps = '';
  							if (!empty($arJSOffer['DISPLAY_PROPERTIES']))
  							{
  								foreach ($arJSOffer['DISPLAY_PROPERTIES'] as $arOneProp)
  								{
  									$strProps .= '<br>'.$arOneProp['NAME'].' <strong>'.(
  										is_array($arOneProp['VALUE'])
  										? implode(' / ', $arOneProp['VALUE'])
  										: $arOneProp['VALUE']
  									).'</strong>';
  								}
  							}
  							$arItem['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
  						}
  					}
  					?>

  					<!-- JS params -->
  					<?
  					$arJSParams = array(
  						'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
  						'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
  						'SHOW_ADD_BASKET_BTN' => false,
  						'SHOW_BUY_BTN' => true,
  						'SHOW_ABSENT' => true,
  						'SHOW_SKU_PROPS' => $arItem['OFFERS_PROPS_DISPLAY'],
  						'SECOND_PICT' => $arItem['SECOND_PICT'],
  						'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
  						'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
  						'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
  						'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
  						'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
  						'DEFAULT_PICTURE' => array(
  							'PICTURE' => $arItem['PRODUCT_PREVIEW'],
  							'PICTURE_SECOND' => $arItem['PRODUCT_PREVIEW_SECOND']
  						),
  						'VISUAL' => array(
  							'ID' => $arItemIDs['ID'],
  							'PICT_ID' => $arItemIDs['PICT'],
  							'SECOND_PICT_ID' => $arItemIDs['SECOND_PICT'],
  							'QUANTITY_ID' => $arItemIDs['QUANTITY'],
  							'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
  							'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
  							'QUANTITY_MEASURE' => $arItemIDs['QUANTITY_MEASURE'],
  							'PRICE_ID' => $arItemIDs['PRICE'],
  							'TREE_ID' => $arItemIDs['PROP_DIV'],
  							'TREE_ITEM_ID' => $arItemIDs['PROP'],
  							'BUY_ID' => $arItemIDs['BUY_LINK'],
  							'ADD_BASKET_ID' => $arItemIDs['ADD_BASKET_ID'],
  							'DSC_PERC' => $arItemIDs['DSC_PERC'],
  							'SECOND_DSC_PERC' => $arItemIDs['SECOND_DSC_PERC'],
  							'DISPLAY_PROP_DIV' => $arItemIDs['DISPLAY_PROP_DIV'],
  							'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
  							'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
  							'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
  						),
  						'BASKET' => array(
  							'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
  							'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
  							'SKU_PROPS' => $arItem['OFFERS_PROP_CODES'],
  							'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
  							'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
  						),
  						'PRODUCT' => array(
  							'ID' => $arItem['ID'],
  							'NAME' => $productTitle
  						),
  						'OFFERS' => $arItem['JS_OFFERS'],
  						'OFFER_SELECTED' => $arItem['OFFERS_SELECTED'],
  						'TREE_PROPS' => $arSkuProps,
  						'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
  					);
  					if ($arParams['DISPLAY_COMPARE'])
  					{
  						$arJSParams['COMPARE'] = array(
  							'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
  							'COMPARE_PATH' => $arParams['COMPARE_PATH']
  						);
  					}
  					?>
  					<script type="text/javascript">
  					  var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
  					</script>
  					<!-- End JS params -->
  					<?
					}
				}
				?>
				<!-- End PRODUCT_DISPLAY_MODE -->

				<?if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) {?>
					<!-- Simple product -->

					<!-- Buy Button -->
					<div class="bx_catalog_item_controls">
						<?if ($arItem['CAN_BUY']) {?>

							<?if ('Y' == $arParams['USE_PRODUCT_QUANTITY']) {?>
								<div class="bx_catalog_item_controls_blockone">
									<div style="display: inline-block;position: relative;">
										<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
										<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
										<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
									</div>
									<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
								</div>
							<?}?>

							<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo">
								<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_cart btn bt1" href="javascript:void(0)" rel="nofollow"><?
								if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
								{
									echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
								}
								else
								{
									echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));
								}
								?></a>
							</div>

						<?} else {?>

							<?/**?>
							<div class="buy_btn_wrap">
								<button class="btn btn-primary btn-sm buy_btn" type="button" data-url="<?=SITE_DIR?>ajax/order_form.php" data-name="<?=$arResult['NAME']?>" data-id="<?=$arResult['ID']?>"><?=GetMessage('CT_BCS_TPL_MESS_BTN_ORDER');?></button>
							</div>

							<div id="" class="bx_catalog_item_controls_blocktwo">
								<a id="" class="bx_cart btn bt1" href="javascript:void(0)" rel="nofollow"><?=GetMessage('CT_BCS_TPL_MESS_BTN_ORDER');?></a>
							</div>
							<?**/?>

							<div id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_catalog_item_controls_blockone">
                <span class="bx_notavailable">
                  <?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
                </span>
              </div>

              <div class="bx_catalog_item_controls touch">
                <a class="btn bt2 bx_detail" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
                  <?echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL'));?>
                </a>
              </div>
						<?}?>
						<div style="clear: both;"></div>
					</div>
					<!-- End Buy Button -->

					<!-- Display Properties -->
					<?if (isset($arItem['DISPLAY_PROPERTIES']) && !empty($arItem['DISPLAY_PROPERTIES'])) {?>
						<div class="bx_catalog_item_controls">
							<div class="preview-text no-marker">
								<ul>
									<?foreach ($arItem['DISPLAY_PROPERTIES'] as $arOneProp) {?>
										<?
										if($arOneProp["CODE"] == "ARTNUMBER") {
										?>
											<li>
												<? echo $arOneProp['NAME']; ?>:
												<b>
													<?echo (is_array($arOneProp['DISPLAY_VALUE']) ? implode('<br>', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE']);?>
												</b>
											</li>
										<?}?>
									<?}?>
								</ul>
							</div>
						</div>
					<?}?>
					<!-- End Display Properties -->

					<?if ($arParams['DISPLAY_COMPARE']) {?>
						<a data-id="<?=$arItem['ID']?>" class="p_btn_compare">
							<span class="add"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></span>
							<span class="added"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARED'); ?></span>
						</a>
					<?}?>

					<!-- Basket props -->
					<?
					$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
					?>
					<?if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties) {?>
						<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
							<?if (!empty($arItem['PRODUCT_PROPERTIES_FILL'])) {?>
								<?foreach ($arItem['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo) {?>
									<input
										type="hidden"
										name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
										value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"
										>
									<?
									if (isset($arItem['PRODUCT_PROPERTIES'][$propID]))
										unset($arItem['PRODUCT_PROPERTIES'][$propID]);
									?>
								<?}?>
							<?}?>

							<?
							$emptyProductProperties = empty($arItem['PRODUCT_PROPERTIES']);
							?>
							<?if (!$emptyProductProperties) {?>
								<table>
									<?foreach ($arItem['PRODUCT_PROPERTIES'] as $propID => $propInfo) {?>
										<tr>
											<td><? echo $arItem['PROPERTIES'][$propID]['NAME']; ?></td>
											<td>
												<?if('L' == $arItem['PROPERTIES'][$propID]['PROPERTY_TYPE'] && 'C' == $arItem['PROPERTIES'][$propID]['LIST_TYPE']) {?>
													<?foreach($propInfo['VALUES'] as $valueID => $value) {?>
														<label><input
														type="radio"
														name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
														value="<? echo $valueID; ?>"
														<? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>
														><? echo $value; ?>
														</label><br>
													<?}?>
												<?} else {?>
													<select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]">
														<?foreach($propInfo['VALUES'] as $valueID => $value) {?>
															<option
																value="<? echo $valueID; ?>"
																<? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>
																><? echo $value; ?>
															</option>
														<?
														}
														?>
													</select>
												<?}?>
											</td>
										</tr>
									<?}?>
								</table>
							<?}?>
						</div>
						<?
					}
					?>
					<!-- End Basket props -->

					<!-- JS params -->
					<?
					$arJSParams = array(
						'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
						'SHOW_QUANTITY' => ($arParams['USE_PRODUCT_QUANTITY'] == 'Y'),
						'SHOW_ADD_BASKET_BTN' => false,
						'SHOW_BUY_BTN' => true,
						'SHOW_ABSENT' => true,
						'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
						'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
						'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
						'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
						'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
						'PRODUCT' => array(
							'ID' => $arItem['ID'],
							'NAME' => $productTitle,
							'PICT' => $arItem['PREVIEW_PICTURE'],
							'CAN_BUY' => $arItem["CAN_BUY"],
							'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
							'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
							'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
							'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
							'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
							'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL'],
							'BASIS_PRICE' => $arItem['MIN_BASIS_PRICE']
						),
						'BASKET' => array(
							'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
							'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
							'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
							'EMPTY_PROPS' => $emptyProductProperties,
							'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
							'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
						),
						'VISUAL' => array(
							'ID' => $arItemIDs['ID'],
							'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
							'QUANTITY_ID' => $arItemIDs['QUANTITY'],
							'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
							'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
							'PRICE_ID' => $arItemIDs['PRICE'],
							'BUY_ID' => $arItemIDs['BUY_LINK'],
							'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
							'BASKET_ACTIONS_ID' => $arItemIDs['BASKET_ACTIONS'],
							'NOT_AVAILABLE_MESS' => $arItemIDs['NOT_AVAILABLE_MESS'],
							'COMPARE_LINK_ID' => $arItemIDs['COMPARE_LINK']
						),
						'LAST_ELEMENT' => $arItem['LAST_ELEMENT']
					);
					if ($arParams['DISPLAY_COMPARE'])
					{
						$arJSParams['COMPARE'] = array(
							'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
							'COMPARE_PATH' => $arParams['COMPARE_PATH']
						);
					}

					unset($emptyProductProperties);
					?>

					<script type="text/javascript">
					var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
					</script>
					<!-- End JS params -->

					<!-- End Simple product -->
				<?} else {?>
					<!-- Offers product -->

					<?if ('Y' == $arParams['PRODUCT_DISPLAY_MODE']) {?>
						<!-- PRODUCT_DISPLAY_MODE -->

						<?$canBuy = $arItem['JS_OFFERS'][$arItem['OFFERS_SELECTED']]['CAN_BUY'];?>

						<div class="bx_catalog_item_controls no_touch">
							<?
							if ('Y' == $arParams['USE_PRODUCT_QUANTITY'])
							{
							?>
							<div class="bx_catalog_item_controls_blockone">
								<div style="display: inline-block;position: relative;">
									<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
									<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>">
									<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
								</div>
								<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"></span>
							</div>
							<?
							}
							?>

							<div id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" class="bx_catalog_item_controls_blocktwo" style="display: <? echo ($canBuy ? '' : 'none'); ?>;">
								<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_cart btn bt1" href="javascript:void(0)" rel="nofollow"><?
								if ($arParams['ADD_TO_BASKET_ACTION'] == 'BUY')
								{
									echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
								}
								else
								{
									echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET'));
								}
								?></a>
							</div>

							<div style="clear: both;"></div>
						</div>

            <div class="bx_catalog_item_controls touch">
              <a class="btn bt2 bx_detail" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?
              echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL'));
              ?></a>
            </div>

						<?if ($arParams['DISPLAY_COMPARE']) {?>
							<a data-id="<?=$arItem['ID']?>" class="p_btn_compare">
								<span class="add"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></span>
								<span class="added"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARED'); ?></span>
							</a>
						<?}?>

					<!-- End PRODUCT_DISPLAY_MODE -->
					<?} else {?>
            <div class="bx_catalog_item_controls touch">
              <a class="btn bt2 bx_detail" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>">
                <?echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL'));?>
              </a>
            </div>

						<div class="bx_catalog_item_controls no_touch tac">
							<a class="bt2 detail-btn" href="<? echo $arItem['DETAIL_PAGE_URL']; ?>"><?
							echo ('' != $arParams['MESS_BTN_DETAIL'] ? $arParams['MESS_BTN_DETAIL'] : GetMessage('CT_BCS_TPL_MESS_BTN_DETAIL'));
							?></a>
						</div>

            <?if ($arParams['DISPLAY_COMPARE']) {?>
              <a data-id="<?=$arItem['ID']?>" class="p_btn_compare">
                <span class="add"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARE'); ?></span>
                <span class="added"><? echo GetMessageJS('CT_BCS_TPL_MESS_BTN_COMPARED'); ?></span>
              </a>
            <?}?>
					<?}?>



				<!-- End Offers product -->
				<?}?>
		</div>
	</div>
	<?}?>
	<div style="clear: both;"></div>

</div><!-- end .bx_catalog_grid -->

<!-- Start BX Message To JS -->
<script type="text/javascript">
BX.message({
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
	BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
	ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>',

	QUANTITY_NOT_AVAILABLE: '<? echo GetMessageJS('QUANTITY_NOT_AVAILABLE') ?>',
	QUANTITY_AVAILABLE: '<? echo GetMessageJS('QUANTITY_AVAILABLE') ?>'
});
</script>
<!-- End BX Message To JS -->

<!-- Start Bottom Pager -->
<?if ($arParams["DISPLAY_BOTTOM_PAGER"]) {?>
	<?echo $arResult["NAV_STRING"]; ?>
<?}?>
<!-- End Bottom Pager -->

<?
}
?>
