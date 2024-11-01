<div style="width: 40%; float: left;">
	<form id="yaawp_settings" class="settings" method="POST" style="padding: 0 8px; height: 600px; border-style: solid; border-width: 1px 1px 0; border-color: #dfdfdf #dfdfdf #fff;">

		<div class="header">
			<h1><?php echo __('Statistik', $this->var_sTextdomain); ?></h1>
		</div>

		<?php
			$posts = get_posts( array(
				'post_type' => 'shop',
				'meta_key' => 'ASIN',
				'numberposts' => 1000
			) );
		?>

		<div id="titlewrap">
			<label for="Produkte"><?php echo __('Produkte', $this->var_sTextdomain); ?></label>
			<input type="text" class="yyywp_setting" name="Produkte" size="40" value="<?php echo count($posts);?>" id="Produkte" disabled="disabled">
		</div>

	</form>
</div>