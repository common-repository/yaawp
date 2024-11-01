<div class="wrap">  
	<div id="icon-themes" class="icon32"></div>  
	<h2><?php echo __('Yet Another Amazon Wordpress Plugin: Import', $this->var_sTextdomain); ?></h2>
	<div class="notice"><p></p></div>

	<form id="yaawp_import" class="import" method="POST" style="padding: 10px 0;">
		<div id="titlediv">

			<div id="titlewrap">
				<label for="keyword"><?php echo __('Suchwort', $this->var_sTextdomain); ?></label>
				<input type="text" class="keyword" name="keyword" size="60" id="keyword" autocomplete="off">
				<label for="SearchIndex"><?php echo __('Kategorie', $this->var_sTextdomain); ?></label>
				<select name="SearchIndex" id="SearchIndex">
	                <option value=""><?php echo __('Sortierung w&auml;hlen', $this->var_sTextdomain); ?></option>
	                <?php
	                global $wpdb;
	                $nodes = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."yaawp_nodes");
	                foreach($nodes as $node) {
	                    if(!empty($node->NodeId)) {
	                        echo '<option value="'.$node->SearchIndex.'" data-noteid="'.$node->NodeId.'">'.$node->Name.'</option>';
	                    }
	                }
	                ?>
				</select>
				<span id="load"><img src="/wp-content/plugins/yaawp/assets/img/ajax-loader-2.gif"/></span>
				<input type="submit" name="publish" id="yaawp_publish" class="button" value="<?php echo __('Suchen', $this->var_sTextdomain); ?>" accesskey="p">
			</div>

			<div style="height: 0; border-top: 1px dashed #dfdfdf;margin-bottom: 5px;margin-top: 5px;"></div>

			<div class="tablenav top">

				<div class="alignleft actions">
					<select name="page" id="page">
						<option value="-1" selected="selected"><?php echo __('Seite w&auml;hlen', $this->var_sTextdomain); ?></option>
					</select>
					<input type="submit" name="" id="yaawp_doaction" class="button action" value="<?php echo __('Importieren', $this->var_sTextdomain); ?>">
				</div>
	
				<br class="clear">
			</div>

			<table id="results" class="widefat">
				<thead>
					<tr>
						<th style="text-align: center; padding-top: 5px; padding-bottom: 5px;"><input type="checkbox" class="checkall"></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('Thumbnail', $this->var_sTextdomain); ?></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('Titel / Beschreibung', $this->var_sTextdomain); ?></th>
						<th style="width: 170px; padding-top: 5px; padding-bottom: 5px;"><?php echo __('Preis / UVP / Gebraucht', $this->var_sTextdomain); ?></th>
						<th style="width: 280px; padding-top: 5px; padding-bottom: 5px;"><?php echo __('ASIN / Kundenstimmen / Verkaufsrang', $this->var_sTextdomain); ?></th>
						<th style="width: 180px; padding-top: 5px; padding-bottom: 5px;"><?php echo __('Kategorie', $this->var_sTextdomain); ?></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('Verf&uuml;gbarkeit', $this->var_sTextdomain); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th style="text-align: center; padding-top: 5px; padding-bottom: 5px;"><input type="checkbox" class="checkall"></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('Thumbnail', $this->var_sTextdomain); ?></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('Titel / Beschreibung', $this->var_sTextdomain); ?></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('Preis / UVP / Gebraucht', $this->var_sTextdomain); ?></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('ASIN / Kundenstimmen / Verkaufsrang', $this->var_sTextdomain); ?></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('Kategorie', $this->var_sTextdomain); ?></th>
						<th style="padding-top: 5px; padding-bottom: 5px;"><?php echo __('Verf&uuml;gbarkeit', $this->var_sTextdomain); ?></th>
					</tr>
				</tfoot>
				<tbody style="text-align: left;">
					<tr>
						<td colspan="7"><?php echo __('Bitte auswahl treffen', $this->var_sTextdomain); ?></td>
					</tr>
				</tbody>
			</table>


		</div>
	</form>

</div><!-- /.wrap --> 