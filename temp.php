<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->AddHeadString('<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>',true);?>
<?$start = microtime(true); 
//$USER->Authorize(1);
CModule::IncludeModule("lunohod.dalliservice");
echo 'Подключили модуль: '.(microtime(true) - $start).' сек.<br>';?>
<pre>
<?//$obj1 = LunohodDalliservice::GetPvzCity("SDEK", "Москва");
//obj1 = LunohodDalliservice::GetPvzCityCoord("BOXBERRY", "Москва", $start);
echo 'Достали объекты: '.(microtime(true) - $start).' сек.<br>';
//echo microtime(true); 
//($obj1);
?>
<?$USER->Authorize(1); //?>
<style>
 

#info {
    float: left;
	position: relative;
	height: 300px;
    overflow: hidden;
    width: 245px;
    color: black;
top: -10px;
	z-index: 1000;
	height: 478px;
    left: 46px;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 0 5px #5D5D5D;
	top: 11px;
    z-index: 1000;
	opacity: 0.8; 
}
</style>
<pre>
<?CUtil::InitJSCore( array('ajax' , 'popup' ));?>

<div id="apiship_pvz"></div>



<script type="text/javascript">

  ymaps.ready(init);
    var myMap,
        myPlacemark;

    function init(){     
        myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 10
        });
		myMap.controls.add('typeSelector');
       /* myPlacemark = new ymaps.Placemark([55.76, 37.64], { 
            hintContent: 'Москва!', 
            balloonContent: 'Столица России' 
        });*/

        //myMap.geoObjects.add(myPlacemark);
	
		myMap.geoObjects
		/*.add(new ymaps.Placemark([55.684758, 37.738521], {
            balloonContent: 'цвет <strong>воды пляжа бонди</strong>'
        }, {
            preset: 'islands#icon',
            iconColor: '#0095b6'
        }))
        .add(new ymaps.Placemark([55.833436, 37.715175], {
            balloonContent: '<strong>серобуромалиновый</strong> цвет'
        }, {
            preset: 'islands#dotIcon',
            iconColor: '#735184'
        }))*/
		<?/*foreach($obj1 as $ob):?>
			.add(new ymaps.Placemark([<?=$ob["coords"][1]?>, <?=$ob["coords"][0]?>], {
            balloonContent: '<?=$ob["address"].$ob["phone"].$ob["worktime"]?><button class="sendpvzid" id="<?=$ob["address"]?>">send</button>'
        }))
		<?endforeach;*/?>
		
    }
	
/*
	
events: {
    onAfterPopupShow: function () {
        BX.ajax.post(
            '<?// echo $this->GetFolder(); ?>/popup.php',
            {
                lang: BX.message('LANGUAGE_ID'),
                site_id: BX.message('SITE_ID') || '',
                arParams: curSetParams
 },
            BX.delegate(function (result) {
                    this.setContent(result);
                    BX("CatalogSetConstructor_" + element_id).style.left = (window.innerWidth - BX("CatalogSetConstructor_" + element_id).offsetWidth) / 2 + "px";
                    var popupTop = document.body.scrollTop + (window.innerHeight - BX("CatalogSetConstructor_" + element_id).offsetHeight) / 2;
                    //BX("CatalogSetConstructor_" + element_id).style.top = popupTop > 0 ? popupTop + "px" : 0;
 },
                this)
        );
    }
} 
	
	
	
*/
	



BX.ready(function(){
    var Confirmer = new BX.PopupWindow("apiship_pvz", null, {
     content: '<div id="map" style="width:800px;height:500px"><!--div id="info"></div--></div>',
     closeIcon: {right: "20px", top: "10px"},
     titleBar: {content: BX.create("h3", {html: 'Список ПВЗ', 'props': {'className': 'access-title-bar'}})},
     zIndex: 0,
     offsetLeft: 0,
     offsetTop: 0,
     draggable: {restrict: false},
     overlay: {backgroundColor: 'black', opacity: '80' },  /* затемнение фона */
     /*buttons: [
      new BX.PopupWindowButton({
          text: "Перейти в корзину",
          className: "popup-window-button-accept",
          events: {click: function(){
           location.href="";
          }}
      }),
     ]*/
    });

    $('body').on('click','.buy_btn',function(){
	Confirmer.show();
	
     return false;
    });

});	
</script>
<a class="buy_btn" href="#"> В корзину </a>

	<div id="apiship_map">
		
	</div>

<?echo microtime(true); ?>

<?
//5786
$arResult["ORDER_DATA"]["ORDER_PRICE"];
$arResult["ORDER_DATA"]["ORDER_WEIGHT"];

foreach($arResult["ITEMS_DIMENSIONS"] as $dimension){
	$WIDTH[] = $dimension["WIDTH"];
	$LENGTH[] = $dimension["LENGTH"];
	$height += $dimension["HEIGHT"];
}

$width = max($WIDTH);
$length = max($LENGTH);
echo $height."/".$width."/".$length;


//LunohodDalliservice::GetPvzCost($token, $url, $partner, $city);
?>



<!--script type="text/javascript">
    var map = new ymaps.Map("map", {
            center: [55.76, 37.64], 
            zoom: 7
        });
</script>
<script type="text/javascript">
    ymaps.ready(init);
    var myMap;

    function init(){     
        myMap = new ymaps.Map("map", {
            center: [55.76, 37.64],
            zoom: 7
        });
    }
</script>
<script type="text/javascript">
  ymaps.ready(init);
    var myMap,
        myPlacemark;

    function init(){     
        myMap = new ymaps.Map ("map", {
            center: [55.76, 37.64],
            zoom: 7
        });

        myPlacemark = new ymaps.Placemark([55.76, 37.64], { hintContent: 'Москва!', balloonContent: 'Столица России' });
    }
</script-->


<?


//SDEK BOXBERRY RUPOST
LunohodDalliservice::setCityLocations(38, 40, 29);
echo 'Отобразили на карте: '.(microtime(true) - $start).' сек.';
echo 'Время выполнения скрипта: '.(microtime(true) - $start).' сек.';
	


?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

