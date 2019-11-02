<div class='blockTarif' data-link-group='<?php echo $data_link_group; ?>' data-link-variant='<?php echo $data_link_variant; ?>'>
	<h2 class='titleBlock'>Тариф "<?php echo $title; ?>"</h2>
	<div class='blockContent noBackground'>
		<div class="price">Период оплаты - <?php echo $pay_period; ?></div>
		<div class="price"><?php echo $price_mounth; ?> ₽/мес</div>
		<div class="oncePay">разовый платёж - <?php echo $price; ?> ₽<br/>
		со счёта спишется - <?php echo $price; ?> ₽</div>
		<div class="greyText">вступит в силу - сегодня<br/>
		активно до - <?php echo $new_payday; ?></div>
	</div>
	<div class="selectButton">Выбрать</button>
	<script>
		$(".selectButton").on("click", function(){
			alert("Выбор сделан!");
		});
	</script>
</div>