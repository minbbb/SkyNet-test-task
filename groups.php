<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$jsonText = file_get_contents('http://sknt.ru/job/frontend/data.json');
$json = json_decode($jsonText, true);

function getPriceMinMax($tarifs){
	$prices = array();
	foreach ($tarifs as $value){
		array_push($prices, $value['price'] / (int)$value['pay_period']);		
	}
	return min($prices)." - ".max($prices);
}

function getSpeedColor($title){
	switch($title){
		case "Земля":
			return "tarif_1";
			break;
		case "Вода":
			return "tarif_2";
			break;
		case "Огонь":
			return "tarif_3";
			break;
		case "Вода HD":
			return "tarif_2";
			break;
		case "Огонь HD":
			return "tarif_3";
			break;
		default:
			return "tarif_1";
	}
}
?>
<div class='grid'>
	<?php
	foreach ($json["tarifs"] as $key => $value){
		$data_link_group = $key;
		$title = $value["title"];
		$speed = $value["speed"];
		$speed_color = getSpeedColor($title);
		$first_block = "";
		if ($key == 0){
			$first_block = "firstBlock";
		}
		$price = getPriceMinMax($value["tarifs"]);
		$link = $value["link"];
		$free_options = "";
		if(isset($value['free_options'])){
			$free_options = "<ul class='freeOptions'>";
			foreach ($value['free_options'] as $option){
				$free_options .= "<li>".$option."</li>";
			}
			$free_options .= "</ul>";
		}
		?>
		<div class='block <?php echo $first_block; ?>' data-link-group='<?php echo $data_link_group; ?>'>
			<h2 class='titleBlock'>Тариф "<?php echo $title; ?>"</h2>
			<div class='blockContent'>
				<div class="speed"><span class="<?php echo $speed_color; ?>"><?php echo $speed; ?> Мбит/с</span></div>
				<div class="price"><b><?php echo $price; ?> ₽/мес</b></div>
				<?php echo $free_options; ?>
			</div><a target="_blank" class="details" href='<?php echo $link; ?>' onClick="event.stopPropagation()">узнать подробнее на сайте www.sknt.ru</a>
		</div>
		<?php
	}
	?>
</div>