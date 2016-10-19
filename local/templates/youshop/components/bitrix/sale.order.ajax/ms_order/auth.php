<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
<!--
function ChangeGenerate(val)
{
	if(val)
	{
		document.getElementById("sof_choose_login").style.display='none';
	}
	else
	{
		document.getElementById("sof_choose_login").style.display='block';
		document.getElementById("NEW_GENERATE_N").checked = true;
	}

	try{document.order_reg_form.NEW_LOGIN.focus();}catch(e){}
}
//-->
</script>
<table class="order-auth form">
	<tr>
		<td>
			<form method="post" action="" name="order_auth_form">

				<h4><?echo GetMessage("STOF_2REG")?></h4>



				<?=bitrix_sessid_post()?>
				<?
				foreach ($arResult["POST"] as $key => $value)
				{
				?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
				<?
				}
				?>
				<div class="sale_order_full_table">
					<p><?echo GetMessage("STOF_LOGIN_PROMT")?></p>

					<div class="field">
						<label><?echo GetMessage("STOF_LOGIN")?> <span class="starrequired">*</span></label>
						<br />
						<input type="text" name="USER_LOGIN" maxlength="30" size="30" value="<?=$arResult["AUTH"]["USER_LOGIN"]?>">
					</div>

					<div class="field">
						<label><?echo GetMessage("STOF_PASSWORD")?> <span class="starrequired">*</span></label>
						<input type="password" name="USER_PASSWORD" maxlength="30" size="30">
					</div>

					<p>
						<a href="<?=$arParams["PATH_TO_AUTH"]?>?forgot_password=yes&back_url=<?= urlencode($APPLICATION->GetCurPageParam()); ?>"><?echo GetMessage("STOF_FORGET_PASSWORD")?></a>
					</p>
					<p>
						<input type="submit" class="btn bt1" value="<?echo GetMessage("STOF_NEXT_STEP")?>">
						<input type="hidden" name="do_authorize" value="Y">
					</p>
				</div>
			</form>
		</td>
		<td>
			<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
				<form method="post" action="" name="order_reg_form">
					<h4><?echo GetMessage("STOF_2NEW")?></h4>
					<?=bitrix_sessid_post()?>
					<?
					foreach ($arResult["POST"] as $key => $value)
					{
					?>
					<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
					<?
					}
					?>
					<div class="sale_order_full_table">

						<div class="field">
							<label><?echo GetMessage("STOF_NAME")?> <span class="starrequired">*</span></label>
							<br />
							<input type="text" name="NEW_NAME" size="40" value="<?=$arResult["AUTH"]["NEW_NAME"]?>">
						</div>

						<div class="field">
							<label><?echo GetMessage("STOF_LASTNAME")?> <span class="starrequired">*</span></label>
							<br />
							<input type="text" name="NEW_LAST_NAME" size="40" value="<?=$arResult["AUTH"]["NEW_LAST_NAME"]?>">
						</div>

						<div class="field">
							<label>E-Mail <span class="starrequired">*</span></label>
							<br />
							<input type="text" name="NEW_EMAIL" size="40" value="<?=$arResult["AUTH"]["NEW_EMAIL"]?>">
						</div>

						<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
						<div class="radio">
							<input type="radio" id="NEW_GENERATE_N" name="NEW_GENERATE" value="N" OnClick="ChangeGenerate(false)"<?if ($_POST["NEW_GENERATE"] == "N") echo " checked";?>>
							<label for="NEW_GENERATE_N"><?echo GetMessage("STOF_MY_PASSWORD")?></label>
						</div>
						<?endif;?>

						<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
						<div id="sof_choose_login">
							<div class="field">
								<label><?echo GetMessage("STOF_LOGIN")?> <span class="starrequired">*</span></label>
								<br />
								<input type="text" name="NEW_LOGIN" size="30" value="<?=$arResult["AUTH"]["NEW_LOGIN"]?>">
							</div>

							<div class="field">
								<label><?echo GetMessage("STOF_PASSWORD")?> <span class="starrequired">*</span></label>
								<br />
								<input type="password" name="NEW_PASSWORD" size="30">
							</div>

							<div class="field">
								<label><?echo GetMessage("STOF_RE_PASSWORD")?> <span class="starrequired">*</span></label>
								<br />
								<input type="password" name="NEW_PASSWORD_CONFIRM" size="30">
							</div>
						</div>
						<?endif;?>


						<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
						<div class="radio">
							<input type="radio" id="NEW_GENERATE_Y" name="NEW_GENERATE" value="Y" onclick="ChangeGenerate(true)"<?if ($POST["NEW_GENERATE"] != "N") echo " checked";?>>
							<label for="NEW_GENERATE_Y"><?echo GetMessage("STOF_SYS_PASSWORD")?></label>
							<script language="JavaScript">
							<!--
							ChangeGenerate(<?= (($_POST["NEW_GENERATE"] != "N") ? "true" : "false") ?>);
							//-->
							</script>
						</div>
						<?endif;?>

						<?
						if($arResult["AUTH"]["captcha_registration"] == "Y") //CAPTCHA
						{
							?>
							<b><?=GetMessage("CAPTCHA_REGF_TITLE")?></b>

							<input type="hidden" name="captcha_sid" value="<?=$arResult["AUTH"]["capCode"]?>">
							<img class="captcha_img" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["AUTH"]["capCode"]?>" width="180" height="40" alt="CAPTCHA">

							<div class="field">
								<label><span class="starrequired">*</span> <?=GetMessage("CAPTCHA_REGF_PROMT")?>:</label>
								<br />
								<input type="text" name="captcha_word" size="30" maxlength="50" value="">
							</div>
							<?
						}
						?>

						<input type="submit" class="btn bt1" value="<?echo GetMessage("STOF_NEXT_STEP")?>">
						<input type="hidden" name="do_register" value="Y">
					</div>
				</form>
			<?endif;?>
		</td>
	</tr>
</table>
<br /><br />
<?echo GetMessage("STOF_REQUIED_FIELDS_NOTE")?><br /><br />
<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
	<?echo GetMessage("STOF_EMAIL_NOTE")?><br /><br />
<?endif;?>
<?echo GetMessage("STOF_PRIVATE_NOTES")?>
