<div style="width: 40%; float: left;">
	<form id="yaawp_settings" class="cache" method="POST" style="padding: 0 8px; height: 600px; border-style: solid; border-width: 1px 1px 0; border-color: #dfdfdf #dfdfdf #fff;">

		<div class="header">
			<h1><?php echo __('Cache', $this->var_sTextdomain); ?></h1>
		</div>

		<div id="titlewrap">
			<label for="yaawp_cron_check"><?php echo __('Legt die Zeit f&uuml;r den Cache fest (in Sekunden)', $this->var_sTextdomain); ?></label>
			<input type="text" class="yyywp_setting" name="yaawp_cron_check" size="20" value="<?php echo get_option('yaawp_cron_check');?>" id="yaawp_cron_check" autocomplete="off">
		</div>

		<div class="yaawp-publishing-actions">
			<input type="submit" name="delete" id="delete" class="button button-primary button-large" value="<?php echo __('Speichern', $this->var_sTextdomain); ?>">
			<input type="submit" name="force-delete" id="force-delete" class="button button-primary button-large" style="float: right" value="<?php echo __('Cache komplett L&ouml;schen', $this->var_sTextdomain); ?>">
		</div>

	</form>
</div>