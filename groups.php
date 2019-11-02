<div class='block <?php echo $first_or_last_block; ?>' data-link-group='<?php echo $data_link_group; ?>'>
	<h2 class='titleBlock'>Тариф "<?php echo $title; ?>"</h2>
	<div class='blockContent'>
		<div class="speed"><span class="<?php echo $speed_color; ?>"><?php echo $speed; ?> Мбит/с</span></div>
		<div class="price"><b><?php echo $price; ?> ₽/мес</b></div>
		<ul class="freeOptions">
			<?php echo $free_options; ?>
		</ul>
	</div><a target="_blank"class="details" href=' <?php echo $link; ?>' onclick="event.stopPropagation()">узнать подробнее на сайте www.sknt.ru</a>
</div>