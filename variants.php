<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$jsonText = file_get_contents('http://sknt.ru/job/frontend/data.json');
$json = json_decode($jsonText, true);

function sortFunc($a, $b){
	if ($a["ID"] == $b["ID"]){
		return 0;
	}
	return ($a["ID"] < $b["ID"]) ? -1 : 1;
}

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
<img src="img/chevron-left-solid.svg" alt="Back" class="backButton" onClick="showGroups()"/>
<div class="titleAndBack">Тариф "<?php echo $json["tarifs"][$_POST['group']]["title"]; ?>"</div>
<div class='grid'>
	<?php
	$variantsArray = $json["tarifs"][$_POST["group"]]["tarifs"];
	usort($variantsArray, "sortFunc");
	foreach ($variantsArray as $value){
		if($value["pay_period"] == "1"){
			$one_mounth_price = $value["price"];
			break;
		}
	}
	foreach ($variantsArray as $value){
		$data_link_variant = $value["ID"];
		$data_link_group = $_POST['group'];
		$pay_period = GetTextMounth($value["pay_period"]);
		$price = $value["price"];
		$price_mounth = $price / (int)$pay_period;
		$discount = "";
		if((int)$pay_period > 1 && isset($one_mounth_price)){
			$discount = "скидка - ".((int)$one_mounth_price * (int)$pay_period - (int)$price)." ₽";
		}
		?>
		<div class='block' data-link-group='<?php echo $data_link_group; ?>' data-link-variant='<?php echo $data_link_variant; ?>'>
			<h2 class='titleBlock'><?php echo $pay_period; ?></h2>
			<div class='blockContentVariants'>
				<div class="price"><?php echo $price_mounth; ?> ₽/мес</div>
				<div class="oncePay">разовый платёж - <?php echo $price; ?> ₽<br/>
					<?php echo $discount; ?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</div>