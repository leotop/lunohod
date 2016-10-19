<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>

<div class="f-modal feedback-popup">
	<div class="title"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/feedback_title.php"), false);?></div>

<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	ShowNote($arResult["OK_MESSAGE"]);
}
?>
	
<div class="personal">
<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
<?=bitrix_sessid_post()?>
<div class="content-form feedback-form">
	<div class="fields">
		<div class="field">
			<label class="field-title"><?=GetMessage("MFT_NAME")?></label><br>
			<input type="text" name="user_name" class="input_text_style" value="<?=$arResult["AUTHOR_NAME"]?>">
		</div>
		<div class="field">
			<label class="field-title"><?=GetMessage("MFT_EMAIL")?></label><br>
			<input type="text" name="user_email" class="input_text_style" value="<?=$arResult["AUTHOR_EMAIL"]?>">
		</div>
		<div class="field">
			<label class="field-title"><?=GetMessage("MFT_MESSAGE")?></label><br>
			<textarea class="input_text_style" name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
		</div>
	
		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
		<div class="field captcha-block">
		<label class="field-title"><?=GetMessage("MFT_CAPTCHA_CODE")?></label>
		<div class="form-input">
			<input class="input_text_style" type="text" name="captcha_word" size="30" maxlength="50" value="">
			<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		</div>	
		</div>
		<?endif;?>
	
		<div class="field field-button">
			<input type="submit" class="bt1 bt-medium" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
		</div>
	</div>
</div>	
</form>
</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>