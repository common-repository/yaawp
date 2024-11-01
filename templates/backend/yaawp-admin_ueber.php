<div style="width: 40%; float: left;">
	<form id="yaawp_settings" class="settings" method="POST" style="padding: 0 8px; height: 600px; border-style: solid; border-width: 1px 1px 0; border-color: #dfdfdf #dfdfdf #fff;">

		<div class="header">
			<h1><?php echo __('&Uuml;ber', $this->var_sTextdomain); ?></h1>
		</div>

		<?php $data = yaawp::yaawp_data(); ?>

		<div id="titlewrap">
			<label for="Version"><?php echo __('Version', $this->var_sTextdomain); ?></label>
			<input type="text" class="yyywp_setting" name="Version" size="40" value="<?php echo $data['Version'];?>" id="Version" disabled="disabled">
		</div>

		<div id="titlewrap">
			<label for="PluginURI"><?php echo __('Plugin URL', $this->var_sTextdomain); ?></label>
			<input type="text" class="yyywp_setting" name="PluginURI" size="40" value="<?php echo $data['PluginURI'];?>" id="PluginURI" disabled="disabled">
		</div>

		<div id="titlewrap">
			<label for="Description"><?php echo __('Beschreibung', $this->var_sTextdomain); ?></label>
			<textarea rows="7" class="yyywp_setting" name="Description" id="Description" disabled="disabled"><?php echo $data['Description'];?></textarea>
		</div>

	</form>
</div>