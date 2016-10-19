<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>
<?=ShowError($arResult["strProfileError"]);?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
	echo ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>
<div class="bx_profile">
	<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
	<?=$arResult["BX_SESSION_CHECK"]?>
	<input type="hidden" name="lang" value="<?=LANG?>" />
	<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
	<input type="hidden" name="LOGIN" value=<?=$arResult["arUser"]["LOGIN"]?> />
	<input type="hidden" name="EMAIL" value=<?=$arResult["arUser"]["EMAIL"]?> />

		<h2><?=GetMessage("LEGEND_PROFILE")?></h2>
		
		<div class="field">
			<label><?=GetMessage('NAME')?></label><br/>
			<input class="input_text_style" type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" />
		</div>
		
		<div class="field">
			<label><?=GetMessage('LAST_NAME')?></label><br/>
			<input class="input_text_style" type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
		</div>
		
		<div class="field">
			<label><?=GetMessage('SECOND_NAME')?></label><br/>
			<input class="input_text_style" type="text" name="SECOND_NAME" maxlength="50"  value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
		</div>
		
		<h2><?=GetMessage("MAIN_PSWD")?></h2>
		<div class="field">
			<label><?=GetMessage('NEW_PASSWORD_REQ')?></label><br/>
			<input class="input_text_style" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" /> 
		</div>
		
		<div class="field">
			<label><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label><br/>
			<input class="input_text_style" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" /> 
		</div>
		<br/>
		<input name="save" value="<?=GetMessage("MAIN_SAVE")?>" class="bt1 bt-big" type="submit">
	</form>
</div>
<br>
<?
if($arResult["SOCSERV_ENABLED"])
{
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
			"SHOW_PROFILES" => "Y",
			"ALLOW_DELETE" => "Y"
		),
		false
	);
}
?>
