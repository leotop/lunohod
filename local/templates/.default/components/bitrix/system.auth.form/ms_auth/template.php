<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$this->setFrameMode(true);?>

<div class="auth-reg">
<?
CJSCore::Init(array("popup"));
?>

<?
if ($arResult["FORM_TYPE"] == "login")
{
?>
	<a rel="nofollow" class="auth-link" href="<?=$arResult["AUTH_URL"]?>"><?=GetMessage("AUTH_LOGIN")?></a>
	<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
	<span>/</span>
	<a rel="nofollow" class="reg-link" href="<?=$arResult["AUTH_REGISTER_URL"]?>" ><?=GetMessage("AUTH_REGISTER")?></a>
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
	<a rel="nofollow" class="logout-link" href="<?=$APPLICATION->GetCurPageParam("logout=yes", Array("logout"))?>"><?=GetMessage("AUTH_LOGOUT")?></a>
<?
}
?>
</div>
