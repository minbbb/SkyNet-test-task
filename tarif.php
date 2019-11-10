<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$jsonText = file_get_contents('http://sknt.ru/job/frontend/data.json');
$json = json_decode($jsonText, true);

function GetTextMounth($period){
	$periodNumber = $period % 100;
	if ($periodNumber > 19){
		$periodNumber = $periodNumber % 10;
	}
	switch ($periodNumber){
		case 1:{
			return($period." месяц");
			break;
		}
		case 2: case 3: case 4:{
			return($period." месяца");
			break;
		}
		default:{
			return($period." месяцев");
			break;
		}
	}
}
?>

<img src="img/chevron-left-solid.svg" alt="Back" class="backButton" onClick="showVariants(<?php echo $_POST["group"] ?>)"/>
<div class="titleAndBack">Выбор тарифа</div>
<div class='gridTarif'>
	<?php
	foreach ($json["tarifs"][$_POST["group"]]["tarifs"] as $value){
		if($value["pay_period"] == "1"){
			$price_mounth = $value["price"];
			break;
		}
	}
	foreach ($json["tarifs"][$_POST["group"]]["tarifs"] as $value){
		if($value["ID"] == $_POST["variant"]){
			$data_link_group = $_POST["group"];
			$data_link_variant = $_POST["variant"];
			$title = $json["tarifs"][$_POST["group"]]["title"];
			$pay_period = GetTextMounth($value["pay_period"]);
			$price = $value["price"];
			$new_payday = date('d.m.Y', (int)$value['new_payday']);
			?>
			<div class='blockTarif' data-link-group='<?php echo $data_link_group; ?>' data-link-variant='<?php echo $data_link_variant; ?>'>
				<h2 class='titleBlock'>Тариф "<?php echo $title; ?>"</h2>
				<div class='blockContent noBackground'>
					<div class="price">Период оплаты - <?php echo $pay_period; ?></div>
					<div class="price"><?php echo $price_mounth; ?> ₽/мес</div>
					<div class="oncePay">разовый платёж - <?php echo $price; ?> ₽<br/>
					со счёта спишется - <?php echo $price; ?> ₽</div>
					<div class="activeDate">вступит в силу - сегодня<br/>
					активно до - <?php echo $new_payday; ?></div>
				</div>
				<div class="selectButton" onClick="alert('Выбор сделан!')">Выбрать</div>
			</div>
			<?php
			break;
		}
	}
	?>
</div>