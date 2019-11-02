<?php
$type = $_POST['type'];
$jsonText = file_get_contents('http://sknt.ru/job/frontend/data.json');
$json = json_decode($jsonText, true);

switch ($type) {
    case "groups":
		?>
		<div class='grid'>
		<?php
		foreach ($json["tarifs"] as $key => $value) {
			$data_link_group = $key;
			$title = $value["title"];
			$speed = $value["speed"];
			switch($title){
				case "Земля":
					$speed_color = "tarif_1";
					break;
				case "Вода":
					$speed_color = "tarif_2";
					break;
				case "Огонь":
					$speed_color = "tarif_3";
					break;
				case "Вода HD":
					$speed_color = "tarif_4";
					break;
				case "Огонь HD":
					$speed_color = "tarif_5";
					break;
				default:
					$speed_color = "tarif_0";
			}
			unset($first_or_last_block);
			if ($key == 0){
				$first_or_last_block = "firstBlock";
			}
			$price = getPriceMinMax($value["tarifs"]);
			$link = $value["link"];
			$free_options = "";
			foreach ($value['free_options'] as $option) {
				$free_options .= "<li>".$option."</li>";
			}
			include("groups.php");
		}
		?>
		</div>
		<?php
        break;
    case "variants":
		?>
		<img src="img/chevron-left-solid.svg" alt"Back" class="backButton"/>
		<div class="titleAndBack">Тариф "<?php echo $json["tarifs"][$_POST['group']]["title"]; ?>"</div>
		<script>$(".backButton").on("click", showGroups);</script>
		<div class='grid'>
		<?php
		$variantsArray = $json["tarifs"][$_POST["group"]]["tarifs"];
		usort($variantsArray, "sortFunc");
		foreach ($variantsArray as $value) {
			if($value["pay_period"] == "1"){
				$one_mounth_price = $value["price"];
				break;
			}
		}
		foreach ($variantsArray as $value) {
			$data_link_variant = $value["ID"];
			$data_link_group = $_POST['group'];
			$pay_period = GetTextMounth($value["pay_period"]);
			$price = $value["price"];
			$price_mounth = $price / (int)$pay_period;
			unset($discount);
			if((int)$pay_period > 1 && isset($one_mounth_price)){
				$discount = "скидка - ".($one_mounth_price * $pay_period - $price)." ₽";
			}
			include("variants.php");
		}
		?>
		</div>
		<?php
        break;
    case "tarif":
		?>
		<img src="img/chevron-left-solid.svg" alt"Back" class="backButton"/>
		<div class="titleAndBack">Выбор тарифа</div>
		<script>$(".backButton").on("click", function(){
			showVariants(<?php echo $_POST["group"] ?>);
		});</script>
		<div class='gridTarif'>
		<?php
		foreach ($json["tarifs"][$_POST["group"]]["tarifs"] as $value) {
			if($value["pay_period"] == "1"){
				$price_mounth = $value["price"];
				break;
			}
		}
		foreach ($json["tarifs"][$_POST["group"]]["tarifs"] as $value) {
			if($value["ID"] == $_POST["variant"]){
				$data_link_group = $_POST["group"];
				$data_link_variant = $_POST["variant"];
				$title = $json["tarifs"][$_POST["group"]]["title"];
				$pay_period = GetTextMounth($value["pay_period"]);
				$price = $value["price"];
				//$price_mounth = $price / (int)$pay_period;
				$new_payday = date('d.m.Y', $value['new_payday']);
				include("tarif.php");
				break;
			}
		}
		?>
		</div>
		<?php
        break;
}

function getPriceMinMax($tarifs) {
	$prices = array();
	foreach ($tarifs as $value) {
		array_push($prices, $value['price'] / $value['pay_period']);		
	}
	return min($prices)." - ".max($prices);
}

function sortFunc($a, $b)
{
    if ($a["ID"] == $b["ID"]) {
        return 0;
    }
    return ($a["ID"] < $b["ID"]) ? -1 : 1;
}

function GetTextMounth($period){
	$periodNumber = $period % 100;
	if ($periodNumber > 19) {
        $periodNumber = $periodNumber % 10;
    }
	switch ($periodNumber) {
		case 1: {
            return($period." месяц");
			break;
        }
        case 2: case 3: case 4: {
            return($period." месяца");
			break;
        }
        default: {
            return($period." месяцев");
			break;
        }
	}
}