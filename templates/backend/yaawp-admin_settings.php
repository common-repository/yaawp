<div style="width: 40%; float: left;">
	<form id="yaawp_settings" class="settings" method="POST" style="padding: 0 8px; height: 600px; border-style: solid; border-width: 1px 1px 0; border-color: #dfdfdf #dfdfdf #fff;">

		<div class="header">
			<h1><?php echo __('Einstellungen', $this->var_sTextdomain); ?></h1>
		</div>

		<div id="titlewrap">
			<label for="yaawp_secret_access_key"><?php echo __('Amazon Geheimer Zugriffsschl&uuml;ssel', $this->var_sTextdomain); ?></label>
			<input type="password" class="yyywp_setting" name="yaawp_secret_access_key" size="40" value="<?php echo get_option('yaawp_secret_access_key');?>" id="yaawp_secret_access_key" autocomplete="off">
		</div>

		<div id="titlewrap">
			<label for="yaawp_access_key_id"><?php echo __('Amazon Zugriffsschl&uuml;ssel-ID', $this->var_sTextdomain); ?></label>
			<input type="text" class="yyywp_setting" name="yaawp_access_key_id" size="20" value="<?php echo get_option('yaawp_access_key_id');?>" id="yaawp_access_key_id" autocomplete="off">
		</div>

		<div id="titlewrap">
			<label for="yaawp_associate_id"><?php echo __('Amazon Tracking ID', $this->var_sTextdomain); ?></label>
			<input type="text" class="yyywp_setting" name="yaawp_associate_id" size="255" value="<?php echo get_option('yaawp_associate_id');?>" id="yaawp_associate_id" autocomplete="off">
		</div>

		<div id="titlewrap">
			<label for="yaawp_associate_network"><?php echo __('Amazon Netzwerk', $this->var_sTextdomain); ?></label>
			<select class="yyywp_setting" name="yaawp_associate_network" disabled="disabled">
				<option>Amazon.ca (CA)</option>
				<option>Amazon.cn (CN)</option>
				<option selected>Amazon.de (DE)</option>
				<option>Amazon.es (ES)</option>
				<option>Amazon.fr (FR)</option>
				<option>Amazon.it (IT)</option>
				<option>Amazon.co.jp (JP)</option>
				<option>Amazon.co.uk (UK)</option>
				<option>Amazon.com (US)</option>
			</select>
		</div>

		<div class="yaawp-publishing-actions">
			<input type="submit" name="publish" id="yaawp_publish" class="button button-primary button-large" value="<?php echo __('Speichern', $this->var_sTextdomain); ?>" accesskey="p" disabled="disabled">
		</div>

	</form>
</div>