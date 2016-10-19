<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-compare-result">
<?
	$compareLength = count($arResult["ITEMS"]);
?>

<h1><? echo  str_replace('#', $compareLength, GetMessage("COMPARE_TITLE")) ?></h1>
<a name="compare_table"></a>
	<!--
	<?if(!empty($arResult["DELETED_PROPERTIES"]) || !empty($arResult["DELETED_OFFER_FIELDS"]) || !empty($arResult["DELETED_OFFER_PROPS"])):?>
		<noindex><p>
		<?=GetMessage("CATALOG_REMOVED_FEATURES")?>:
		<?foreach($arResult["DELETED_PROPERTIES"] as $arProperty):?>
			<a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&pr_code=".$arProperty["CODE"],array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=$arProperty["NAME"]?></a>
		<?endforeach?>
		<?foreach($arResult["DELETED_OFFER_FIELDS"] as $code):?>
			<a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&of_code=".$code,array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=GetMessage("IBLOCK_FIELD_".$code)?></a>
		<?endforeach?>
		<?foreach($arResult["DELETED_OFFER_PROPERTIES"] as $arProperty):?>
			<a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_FEATURE&op_code=".$arProperty["CODE"],array("op_code","of_code","pr_code","action")))?>" rel="nofollow"><?=$arProperty["NAME"]?></a>
		<?endforeach?>
		</p></noindex>
	<?endif?>

	<?if(count($arResult["SHOW_PROPERTIES"])>0):?>
		<p>
		<form action="<?=$APPLICATION->GetCurPage()?>" method="get">
		<?=GetMessage("CATALOG_REMOVE_FEATURES")?>:<br />
		<?foreach($arResult["SHOW_PROPERTIES"] as $arProperty):?>
			<input type="checkbox" name="pr_code[]" value="<?=$arProperty["CODE"]?>" /><?=$arProperty["NAME"]?><br />
		<?endforeach?>
		<?foreach($arResult["SHOW_OFFER_FIELDS"] as $code):?>
			<input type="checkbox" name="of_code[]" value="<?=$code?>" /><?=GetMessage("IBLOCK_FIELD_".$code)?><br />
		<?endforeach?>
		<?foreach($arResult["SHOW_OFFER_PROPERTIES"] as $arProperty):?>
			<input type="checkbox" name="op_code[]" value="<?=$arProperty["CODE"]?>" /><?=$arProperty["NAME"]?><br />
		<?endforeach?>
		<input type="hidden" name="action" value="DELETE_FEATURE" />
		<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
		<input type="submit" value="<?=GetMessage("CATALOG_REMOVE_FEATURES")?>">
		</form>
		</p>
	<?endif?>
	-->
<!--
<pre>
<?
 //print_r ($arResult["ITEMS"]);
 ?>
</pre>
-->

<form action="<?=$APPLICATION->GetCurPage()?>" method="get">

<div class="ct_outer_wrap">
	<div class="ct-left">
		<a class="ct_remove_all btn bt3" href="javascript:void(0);"><?=GetMessage("CATALOG_REMOVE_PRODUCTS")?></a>
	<!--
		<div class="ct_remove_all">
			<input type="submit" value="<?=GetMessage("CATALOG_REMOVE_PRODUCTS")?>" />
		</div>
		-->
		<div class="ct_diff">
			<noindex>
			<?if($arResult["DIFFERENT"]):?>
				<a class="btn bt1" href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=N",array("DIFFERENT")))?>" rel="nofollow"><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?></a>
			<?else:?>
				<span class="btn disabled"><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?></span>
			<?endif?>

			<?if(!$arResult["DIFFERENT"]):?>
				<a class="btn bt1" href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=Y",array("DIFFERENT")))?>" rel="nofollow"><?=GetMessage("CATALOG_ONLY_DIFFERENT")?></a>
			<?else:?>
				<span class="btn disabled"><?=GetMessage("CATALOG_ONLY_DIFFERENT")?></span>
			<?endif?>
			</noindex>
		</div>
	</div>
	<?if($compareLength > 4):?>

	<?endif;?>
<div class="ct_inner_wrap scroll-pane">
	<table class="scroll-content compare_table <?if($compareLength > 4) echo 'scrollable'?>" cellspacing="0" cellpadding="0" border="0" width="<?=count($arResult["ITEMS"]) * 195 - 230?>">
		<thead>
			<tr class="ct_images">
				<th valign="top" nowrap></th>
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<td valign="top">
							<div class="product_img">
								<?if(is_array($arElement["FIELDS"]['DETAIL_PICTURE'])):?>
								<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
									<img
									border="0"
									src="<?=$arElement["FIELDS"]['DETAIL_PICTURE']["SRC"]?>"
									width="<?=$arElement["FIELDS"]['DETAIL_PICTURE']["WIDTH"]?>"
									height="<?=$arElement["FIELDS"]['DETAIL_PICTURE']["HEIGHT"]?>"
									alt="<?=$arElement["FIELDS"]['DETAIL_PICTURE']["ALT"]?>"
									title="<?=$arElement["FIELDS"]['DETAIL_PICTURE']["TITLE"]?>"
									/>
								</a>
								<?endif;?>
								<a class="ct_del" href="javascript:void(0);"></a>
								<input style="display:none;" type="checkbox" name="ID[]" value="<?=$arElement["ID"]?>" />
							</div>

					</td>
				<?endforeach?>
			</tr>

			<tr class="ct_name">
				<th valign="top" nowrap></th>
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<td valign="top">
						<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement['NAME']?></a>
					</td>
				<?endforeach?>
			</tr>

			<!--
			<tr class="ct_canbuy">
				<th valign="top" nowrap></th>
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<td valign="top">
					<div class="ct_cb">
						<?
						if($arElement["CAN_BUY"]):
							?><noindex><a class="buy-btn bt1" href="<?=$arElement["BUY_URL"]?>" rel="nofollow"><?=GetMessage("CATALOG_COMPARE_BUY"); ?></a></noindex><?
						elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):
							?>
							<div class="stock-no"><?=GetMessage("CATALOG_NOT_AVAILABLE")?></div>

							<?
						endif;
						?>

							<div class="price">
								<?=$arElement["PRICES"]["BASE"]["PRINT_DISCOUNT_VALUE_VAT"]?>
							</div>

						</div>
					</td>
				<?endforeach?>
			</tr>
			-->
		</thead>
		<?foreach($arResult["ITEMS"][0]["PRICES"] as $code=>$arPrice):?>
			<?if($arPrice["CAN_ACCESS"]):?>
			<tr>
				<th valign="top" nowrap><?=$arResult["PRICES"][$code]["TITLE"]?></th>
				<?foreach($arResult["ITEMS"] as $arElement):?>
					<td valign="top">
						<?if($arElement["PRICES"][$code]["CAN_ACCESS"]):?>
							<b><?=$arElement["PRICES"][$code]["PRINT_DISCOUNT_VALUE"]?></b>
						<?endif;?>
					</td>
				<?endforeach?>
			</tr>
			<?endif;?>
		<?endforeach;?>

		<?foreach($arResult["SHOW_PROPERTIES"] as $code=>$arProperty):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement)
			{
				$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
				if(is_array($arPropertyValue))
				{
					sort($arPropertyValue);
					$arPropertyValue = implode(" / ", $arPropertyValue);
				}
				$arCompare[] = $arPropertyValue;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th valign="top" nowrap><?=$arProperty["NAME"]?></th>
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
						<td valign="top">
							<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</td>
						<?else:?>
						<td valign="top">
							<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</td>
						<?endif?>
					<?endforeach?>
				</tr>
			<?endif?>
		<?endforeach;?>

		<?foreach($arResult["SHOW_OFFER_FIELDS"] as $code):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement)
			{
				$Value = $arElement["OFFER_FIELDS"][$code];
				if(is_array($Value))
				{
					sort($Value);
					$Value = implode(" / ", $Value);
				}
				$arCompare[] = $Value;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th valign="top" nowrap><?=GetMessage("IBLOCK_FIELD_".$code)?></th>
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
						<td valign="top">
							<?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code])?>
						</td>
						<?else:?>
						<td valign="top">
							<?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code])?>
						</td>
						<?endif?>
					<?endforeach?>
				</tr>
			<?endif?>
		<?endforeach;?>
		<?foreach($arResult["SHOW_OFFER_PROPERTIES"] as $code=>$arProperty):
			$arCompare = Array();
			foreach($arResult["ITEMS"] as $arElement)
			{
				$arPropertyValue = $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["VALUE"];
				if(is_array($arPropertyValue))
				{
					sort($arPropertyValue);
					$arPropertyValue = implode(" / ", $arPropertyValue);
				}
				$arCompare[] = $arPropertyValue;
			}
			$diff = (count(array_unique($arCompare)) > 1 ? true : false);
			if($diff || !$arResult["DIFFERENT"]):?>
				<tr>
					<th valign="top" nowrap><?=$arProperty["NAME"]?></th>
					<?foreach($arResult["ITEMS"] as $arElement):?>
						<?if($diff):?>
						<td valign="top">
							<?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</td>
						<?else:?>
						<td valign="top">
							<?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
						</td>
						<?endif?>
					<?endforeach?>
				</tr>
			<?endif?>
		<?endforeach;?>
	</table>
</div>
</div>

	<input type="hidden" name="action" value="DELETE_FROM_COMPARE_RESULT" />
	<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
</form>

<?if(count($arResult["ITEMS_TO_ADD"])>0):?>
<p>
<form action="<?=$APPLICATION->GetCurPage()?>" method="get">
	<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
	<input type="hidden" name="action" value="ADD_TO_COMPARE_RESULT" />
	<select name="id">
	<?foreach($arResult["ITEMS_TO_ADD"] as $ID=>$NAME):?>
		<option value="<?=$ID?>"><?=$NAME?></option>
	<?endforeach?>
	</select>
	<input type="submit" value="<?=GetMessage("CATALOG_ADD_TO_COMPARE_LIST")?>" />
</form>
</p>
<?endif?>
</div>
