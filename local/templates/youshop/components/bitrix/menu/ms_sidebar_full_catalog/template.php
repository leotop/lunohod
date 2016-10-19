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

$this->setFrameMode(true);

if (empty($arResult["ALL_ITEMS"]))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css'))
	$APPLICATION->SetAdditionalCSS($this->GetFolder().'/themes/'.$arParams["MENU_THEME"].'/colors.css');

$menuBlockId = "catalog_menu_".$this->randString();
?>
<div class="side_menu no-marker bx_<?=$arParams["MENU_THEME"]?>" id="<?=$menuBlockId?>">
	<div class="title"><?=GetMessage('SIDE_MENU_TITLE');?></div>
	<ul id="ul_<?=$menuBlockId?>">
	<!-- first level-->
	<?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>
		<li class="bx_hma_one_lvl <?if($arResult["ALL_ITEMS"][$itemID]["SELECTED"]):?>current<?endif?>">
			<a href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
				<?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?>
			</a>
			
			<?if (is_array($arColumns) && count($arColumns) > 0):?>
				<ul>
				<?foreach($arColumns as $key=>$arRow):?>
					<?foreach($arRow as $itemIdLevel_2=>$arLevel_3):?>  <!-- second level-->
						<li class="">
							<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>">
								<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?>
							</a>
							
						<?if (is_array($arLevel_3) && count($arLevel_3) > 0):?>
							<ul>
							<?foreach($arLevel_3 as $itemIdLevel_3):?>	<!-- third level-->
								<li>
									<a href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["LINK"]?>"><?=$arResult["ALL_ITEMS"][$itemIdLevel_3]["TEXT"]?></a>
								</li>
							<?endforeach;?>
							</ul>
						<?endif?>
						</li>
					<?endforeach;?>
				<?endforeach;?>
				</ul>

			<?endif?>
		</li>
	<?endforeach;?>
	</ul>
</div>
