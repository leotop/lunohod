<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<?
CJSCore::Init(array("popup"));
?>

<?
if ($arResult["FORM_TYPE"] == "login")
{
?>
	<a rel="nofollow" class="auth-link" href="<?=$arResult["AUTH_URL"]?>"><?=GetMessage("FP_AUTH_LOGIN")?></a>
	<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
	<span>&nbsp;/&nbsp;</span>
	<a rel="nofollow" class="reg-link" href="<?=$arResult["AUTH_REGISTER_URL"]?>" ><?=GetMessage("FP_AUTH_REGISTER")?></a>
	<?endif;?>
<?
}
else
{
	$name = trim($USER->GetFullName());
	if (strlen($name) <= 0)
		$name = $USER->GetLogin();
?>
	<a rel="nofollow" class="profile-link" href="<?=$arResult['PROFILE_URL']?>"><?=htmlspecialcharsEx($name);?></a>
	<span>/</span>
	<a rel="nofollow" class="logout-link" href="<?=$APPLICATION->GetCurPageParam("logout=yes", Array("logout"))?>"><?=GetMessage("FP_AUTH_LOGOUT")?></a>
<?
}
?>

<script>
	function openAuthorizePopup()
	{
		var authPopup = BX.PopupWindowManager.create("AuthorizePopup", null, {
			autoHide: true,
			//	zIndex: 0,
			offsetLeft: 0,
			offsetTop: 0,
			overlay : true,
			draggable: {restrict:true},
			closeByEsc: true,
			closeIcon: { right : "12px", top : "10px"},
			content: '<div style="width:400px;height:400px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="<?=$this->GetFolder()?>/images/wait.gif"/></span></div>',
			events: {
				onAfterPopupShow: function()
				{
					BX.ajax.post(
							'<?=$this->GetFolder()?>/ajax.php',
							{
								backurl: '<?=CUtil::JSEscape($arResult["BACKURL"])?>',
								forgotPassUrl: '<?=CUtil::JSEscape($arResult["AUTH_FORGOT_PASSWORD_URL"])?>'
							},
							BX.delegate(function(result)
							{
								this.setContent(result);
							},
							this)
					);
				}
			}
		});

		authPopup.show();
	}
</script>
