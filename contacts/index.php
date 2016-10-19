<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?>
<h1>Контакты</h1>
<div class="bx_page">
	<p><b>Телефон:</b> 8 (499) 322-91-33 с 10-00 до 20-00 ежедневно<br>
<!-- 	
<iframe width="640" height="490" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.ru/maps?f=q&amp;source=s_q&amp;hl=ru&amp;geocode=&amp;q=%D0%B3.+%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0,+%D1%83%D0%BB.+2-%D1%8F+%D0%A5%D1%83%D1%82%D0%BE%D1%80%D1%81%D0%BA%D0%B0%D1%8F,+%D0%B4.+38%D0%90&amp;aq=&amp;sll=55,103&amp;sspn=90.84699,270.527344&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=2-%D1%8F+%D0%A5%D1%83%D1%82%D0%BE%D1%80%D1%81%D0%BA%D0%B0%D1%8F+%D1%83%D0%BB.,+38,+%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0,+127287&amp;ll=55.805478,37.569551&amp;spn=0.023154,0.054932&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="https://maps.google.ru/maps?f=q&amp;source=embed&amp;hl=ru&amp;geocode=&amp;q=%D0%B3.+%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0,+%D1%83%D0%BB.+2-%D1%8F+%D0%A5%D1%83%D1%82%D0%BE%D1%80%D1%81%D0%BA%D0%B0%D1%8F,+%D0%B4.+38%D0%90&amp;aq=&amp;sll=55,103&amp;sspn=90.84699,270.527344&amp;t=m&amp;ie=UTF8&amp;hq=&amp;hnear=2-%D1%8F+%D0%A5%D1%83%D1%82%D0%BE%D1%80%D1%81%D0%BA%D0%B0%D1%8F+%D1%83%D0%BB.,+38,+%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0,+127287&amp;ll=55.805478,37.569551&amp;spn=0.023154,0.054932&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left">Просмотреть увеличенную карту</a></small>
-->
	<h2>Задать вопрос</h2>
</div>
<?$APPLICATION->IncludeComponent("bitrix:main.feedback", "ms_contact_form", array(
	"USE_CAPTCHA" => "Y",
	"OK_TEXT" => "Спасибо, ваше сообщение принято.",
	"EMAIL_TO" => "info@lunohod.org",
	"REQUIRED_FIELDS" => array(
	),
	"EVENT_MESSAGE_ID" => array(
		0 => "7",
	)
	),
	false
);?>


<h1>Реквизиты</h1>

<div class="bx_page">
	<p><b>ООО "Луноход"</b> <br>
ИНН 7720346929 / КПП 772001001, <br>
Тел.: (499) 322-91-33<br>
р/с 40702810900000026073 в АО «Райффазен» г.Москва.<br>
к/с 30101810200000000700, БИК: 044525700,
ОГРН 1167746865956</p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>