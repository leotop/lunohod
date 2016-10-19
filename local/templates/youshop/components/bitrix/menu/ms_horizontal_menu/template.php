<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "ms_shop_v3_adapt_horizontal", SITE_ID);

$this->setFrameMode(true);

if (empty($arResult["ALL_ITEMS"]))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

$menuBlockId = "catalog_menu_".$this->randString();
?>

<div class="bg"></div>
<div class="bx_horizontal_menu_advaced central no-marker bx_<?=$arParams["MENU_THEME"]?>" id="<?=$menuBlockId?>">
	<?if($wizTemplateId == "ms_shop_v3_adapt_horizontal"):?>
	<a href="javascript:void(0);"><span><?=GetMessage("TP_SHOWMENU_CATALOG")?></span></a>
	<?else:?>
	<a href="javascript:void(0);"><span><?=GetMessage("TP_SHOWMENU_MENU")?></span></a>
	<?endif?>
	<ul id="ul_<?=$menuBlockId?>">
	<!-- first level-->
	<?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>

		<?$existPictureDescColomn = ($arResult["ALL_ITEMS"][$itemID]["PARAMS"]["picture_src"] || $arResult["ALL_ITEMS"][$itemID]["PARAMS"]["description"]) ? true : false;?>
		<li class="bx_hma_one_lvl <?if($arResult["ALL_ITEMS"][$itemID]["SELECTED"]):?>current<?endif?><?if (is_array($arColumns) && count($arColumns) > 0):?> dropdown<?endif?>">
			<a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
				<?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?>
			</a>

		<?if (is_array($arColumns) && count($arColumns) > 0):?>
			<div class="bx_children_container b<?=($existPictureDescColomn) ? count($arColumns) : count($arColumns)?> animate">
				<?foreach($arColumns as $key=>$arRow):?>
				<div class="bx_children_block">
					<ul>
					<?foreach($arRow as $itemIdLevel_2=>$arLevel_3):?>  <!-- second level-->
						<li class="parent">
							<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>" <?if ($existPictureDescColomn):?>ontouchstart="document.location.href = '<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>';"<?endif?> data-picture="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["PARAMS"]["picture_src"]?>">
								<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?>
							</a>

						<?if (is_array($arLevel_3) && count($arLevel_3) > 0):?>
							<ul>
							<?foreach($arLevel_3 as $itemIdLevel_3):?>	<!-- third level-->
								<li>
									<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["LINK"]?>" <?if ($existPictureDescColomn):?>ontouchstart="document.location.href = '<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>';return false;"<?endif?> data-picture="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["PARAMS"]["picture_src"]?>"><?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["TEXT"]?></a>
								</li>
							<?endforeach;?>
							</ul>
						<?endif?>
						</li>
					<?endforeach;?>
					</ul>
				</div>
				<?endforeach;?>
				<?if ($existPictureDescColomn):?>
				<?endif?>
				<div style="clear: both;"></div>
			</div>
		<?endif?>
		</li>
	<?endforeach;?>

	<li class="m_more"><span>...</span><div class="mm_dd bx_children_container b1"></div></li>
	</ul>
</div>
