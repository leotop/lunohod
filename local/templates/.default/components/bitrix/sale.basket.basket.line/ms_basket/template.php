<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$frame = $this->createFrame()->begin('');?>

<div id="top-cart">
<?
if (IntVal($arResult["NUM_PRODUCTS"])>0)
{
?>
	<a rel="nofollow" class="tc_icon" href="<?=$arParams["PATH_TO_BASKET"]?>"></a>
	<div class="tc_right tc_not_empty">
		<a rel="nofollow" class="t_cart_products" href="<?=$arParams["PATH_TO_BASKET"]?>"><?echo str_replace('#NUM#', intval($arResult["NUM_PRODUCTS"]), GetMessage('YOUR_CART'))?></a>
		<div class="t_cart_sum"><?=GetMessage('YOUR_CART_SUM')?> <?=$arResult['TOTAL_PRICE']?></div>
	</div>
<?
}
else
{
?>
	<a rel="nofollow" class="tc_icon" href="<?=$arParams["PATH_TO_BASKET"]?>"></a>
	<div class="tc_right tc_not_empty">
		<a rel="nofollow" class="t_cart_products" href="<?=$arParams["PATH_TO_BASKET"]?>"><?echo str_replace('#NUM#', intval($arResult["NUM_PRODUCTS"]), GetMessage('YOUR_CART'))?></a>
		<div class="t_cart_sum"><?=GetMessage('YOUR_CART_SUM')?> <?=$arResult['TOTAL_PRICE']?></div>
	</div>
<?
}
?>
</div>

<?$frame->end();?>
