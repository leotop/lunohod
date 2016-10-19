<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$frame = $this->createFrame()->begin('');?>
<div class="fp_cart">
	<i></i>
	<a rel="nofollow" class="dotted" href="<?=$arParams["PATH_TO_BASKET"]?>"><?=GetMessage('FP_YOUR_CART')?></a>
	<b><?=intval($arResult["NUM_PRODUCTS"])?></b>
	<span><?=GetMessage('YOUR_CART_NA')?></span>
	<b><?=$arResult['TOTAL_PRICE']?></b>
	<a rel="nofollow" class="btn" href="<?=$arParams["PATH_TO_BASKET"]?>"><?=GetMessage('YOUR_CART_DETAIL')?></a>
</div>
<?$frame->end();?>
